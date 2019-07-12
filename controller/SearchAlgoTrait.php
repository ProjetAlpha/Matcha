<?php

trait SearchAlgoTrait
{
    public function getOrientation($src, $dst, $genreSrc, $genreDst)
    {
        $match = 0;
        if ($src == 'bisexuel' && $dst == 'bisexuel') {
            if ($genreSrc == ('homme' || 'femme') && $genreDst == ('homme' || 'femme')) {
                return (0);
            }
        }
        if ($src == 'homosexuel' && $dst == 'homosexuel') {
            if (($genreSrc == 'homme' && $genreDst == 'homme') || ($genreSrc == 'femme' && $genreDst == 'femme')) {
                return (0);
            }
        }
        if ($src == 'heterosexuel' && $dst == 'heterosexuel') {
            if ($genreSrc == 'homme' && $genreDst == 'femme') {
                return (0);
            }
            if ($genreSrc == 'femme' && $genreDst == 'homme') {
                return (0);
            }
        }
        return (25);
    }

    public function getDistance($distance)
    {
        // max dist = 1000km
        return ($distance < 100 ? ($distance * 0.01) * 4 : ($distance * 0.001) * 8);
    }

    public function getTags($src, $dst)
    {
        // max tags = 10.
        $intersection = count(array_intersect($src, $dst));
        return (((10 - $intersection) * 0.1));
    }

    public function getPopularity($src, $dst)
    {
        // on veut le score le moins eleve.
        return (
          (abs($src - $dst) * 0.01) / 1.08
      );
    }

    public function validateRange($data)
    {
        $validate = new Validate(
        $data,
        [
          'minRange' => 'digit|max:3|min:1',
          'maxRange' => 'digit|max:3|min:1',
        ],
        'sendToJs',
        Message::$userMessages
      );
        if (!empty($validate->loadedMessage)) {
            var_dump($validate->loadedMessage);
            return (false);
        }
        return (true);
    }

    public function validateTags($tags)
    {
        foreach ($tags as $tag) {
            if (!isValidRegex(ALPHA, $tag) || strlen($tag) > 256) {
                return (false);
            }
        }
        return (true);
    }

    public function filterCacheData($params)
    {
        $key = 'sugestion:'.$_SESSION['user_id'];
        $data = json_decode($this->redis->get($key));
        $countFilter = count($params);
        $result = [];
        foreach ($data as $user) {
            $userMatchFilter = 0;
            // user : age - popularite - ville - tags.
            if (isset($params['age']) && !empty($params['age'])) {
                if ($user->age >= $params['age']['minRange'] && $user->age <= $params['age']['maxRange']) {
                    ++$userMatchFilter;
                }
            }
            if (isset($params['popularite']) && !empty($params['popularite'])) {
                if ($user->score >= $params['popularite']['minRange'] && $user->score <= $params['popularite']['maxRange']) {
                    ++$userMatchFilter;
                }
            }
            if (isset($params['localisation']) && !empty($params['localisation'])) {
                if (explode(',', $user->localisation)[0] == $params['localisation']) {
                    ++$userMatchFilter;
                }
            }
            // filtrer par tags des users...array intersect
            if (isset($params['tags']) && !empty($params['tags']) && $user->commonTags !== "") {
                if (count(array_intersect($user->commonTags, $params['tags'])) > 0) {
                    ++$userMatchFilter;
                }
            }
            if ($userMatchFilter == $countFilter) {
                $result[] = $user;
            }
        }
        if (!empty($result)) {
            $key = 'filterResult:'.$_SESSION['user_id'];
            $this->redis->set($key, encodeToJs($result));
            return (['sugestions' => array_slice($result, 0, 10)]);
        }
        // sinon message avec : aucun resultat pour ce filtre.
    }

    public function filterResult($params)
    {
        if (empty($params) || !isset($params)) {
            return (false);
        }
        if (isset($params['age'])) {
            if (!$this->validateRange($params['age'])) {
                return (false);
            }
        }
        if (isset($params['popularite'])) {
            if (!$this->validateRange($params['popularite'])) {
                return (false);
            }
        }
        if (isset($params['tags'])) {
            if (!$this->validateTags($params['tags'])) {
                return (false);
            }
        }
        if (isset($params['localisation'])) {
            if (!isValidRegex(ALPHA, $params['localisation']) || strlen($params['localisation']) > 256) {
                return (false);
            }
        }
        return ($this->filterCacheData($params));
    }

    public function sortCacheData($params)
    {
        $key = 'filterResult:'.$_SESSION['user_id'];
        if ($this->redis->exists($key)) {
            $data = json_decode($this->redis->get($key));
        } else {
            $key = 'sugestion:'.$_SESSION['user_id'];
            $data = json_decode($this->redis->get($key));
        }
        // ordre croissant ou decroissant.
        if (isset($params['type'])) {
            if ($params['type'] == 'user-Age') {
                usort($data, function ($a, $b) {
                    return $a->age > $b->age;
                });
            }
            if ($params['type'] == 'score') {
                usort($data, function ($a, $b) {
                    return $a->score > $b->score;
                });
            }
        }
        if (isset($params['localisation'])) {
            usort($data, function ($a, $b) {
                return $a->distance > $b->distance;
            });
        }
        // sort par tags des users... + de tags a - de tags / .. count(array_intersect($tags, $user->tags))
        /*if (isset($params['tags'])){
          usort($data, function ($a, $b) {
              return $a->distance > $b->distance;
          });
        }*/
        $key = 'filterResult:'.$_SESSION['user_id'];
        $this->redis->set($key, encodeToJs($data));
        return (['sugestions' => array_slice($data, 0, 10)]);
    }

    public function sortResult($params)
    {
        if (empty($params) || !isset($params)) {
            return (false);
        }
        if (isset($params['type'])) {
            if ($params['type'] !== 'user-Age' || $params['type'] !== 'score') {
                return (false);
            }
        }
        if (isset($params['localisation'])) {
            if (!isValidRegex(ALPHA, $params['localisation']) || strlen($params['localisation']) > 256) {
                return (false);
            }
        }
        if (isset($params['tags'])) {
            if (!$this->validateTags($params['tags'])) {
                return (false);
            }
        }
        return ($this->sortCacheData($params));
        // usort ordre decroissant
    }
}
