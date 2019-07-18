<?php

require_once('SearchAlgoTrait.php');

class SearchController extends Models
{
    use SearchAlgoTrait;

    public function searchSugestions()
    {
        $result = [];
        $usersCollection = $this->search->fetchAllUsersInfo();
        $currentUser = $this->search->fetchCurrentUserInfo($_SESSION['user_id']);
        $time_start = microtime(true);
        $commonTags = $this->search->fetchTags($_SESSION['user_id']);
        $currentUserTags = oneDimArray($this->search->fetchUserTags($_SESSION['user_id']));

        foreach ($usersCollection as $user) {
            if ($currentUser->id == $user->id) {
                continue;
            }
            $targetUserTags = '';
            $score = 0.0;
            if ($currentUser->orientation && !isset($user->orientation) && ($currentUser->orientation == 'bisexuel')) {
                $score += 10;
            } elseif ($user->orientation && $currentUser->orientation === $user->orientation) {
                $score += $this->getOrientation($currentUser->orientation, $user->orientation, $currentUser->genre, $user->genre);
            } else {
                if ($currentUser->genre == $user->genre && $currentUser->orientation == 'homosexuel') {
                    $score += 10;
                } elseif ($currentUser->orientation == 'bisexuel') {
                    $score += 10;
                } else {
                    $score += 25;
                }
            }

            $distance = geoCoordsDistance($currentUser->latitude, $currentUser->longitude, $user->latitude, $user->longitude);
            if ($distance !== 0.0) {
                $score += $this->getDistance($distance);
            }
            $score += $this->getPopularity($currentUser->score, $user->score);
            if (isset($commonTags[$user->id])) {
                $targetUserTags = oneDimArray($commonTags[$user->id]);
                $score += $this->getTags(
                    $currentUserTags,
                    $targetUserTags
              );
            } else {
                $score += 5;
            }
            if ($score !== 0.0 && $score < 40) {
                $formatDist = round($distance, 3);
                $user->computed_score = $score;
                $user->distance = $formatDist;
                $user->km = (int)$formatDist;
                $user->meters = (int)(($formatDist - (int)$formatDist) * 1000);
                $user->commonTags = $targetUserTags;
                $result[] = $user;
            }
        }
        usort($result, function ($a, $b) {
            return $a->computed_score > $b->computed_score;
        });
        $key = 'sugestion:'.$_SESSION['user_id'];
        $this->redis->set($key, encodeToJs($result));
        echo encodeToJs(['sugestions' => array_slice($result, 0, 10), 'userTags' => $currentUserTags]);
    }

    public function paginateSugestion()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['pageNumber', 'type'], $data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
            'type' => 'alpha',
            'pageNumber' => 'digit|max:4'
          ],
            'sendToJs',
            Message::$userMessages
        );
        if (!empty($validate->loadedMessage)) {
            redirect('/');
        }
        // aussi type = search.
        if ($data['type'] == 'sugestion') {
            $key = 'sugestion:'.$_SESSION['user_id'];
        } elseif ($data['type'] == 'filter') {
            $key = 'filterResult:'.$_SESSION['user_id'];
        }
        $result = json_decode($this->redis->get($key));
        $startData = (($data['pageNumber'] - 1) * 10);
        echo encodeToJs(['result' => array_slice($result, $startData, 10)]);
    }

    public function manageResult()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['filterResult', 'sortResult'], $data)) {
            redirect('/');
        }
        if (empty($data['filterResult']) && empty($data['sortResult'])) {
            return ;
        }
        // reset le filter.
        $key = 'filterResult:'.$_SESSION['user_id'];
        if ($this->redis->exists($key)) {
            $this->redis->del($key);
        }
        if (!empty($data['filterResult'])) {
            $result = $this->filterResult($data['filterResult']);
        }
        //var_dump($result);
        if (!empty($data['sortResult'])) {
            $result = $this->sortResult($data['sortResult']);
        }
        echo encodeToJs($result);
    }

    public function searchResult()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['filterResult'], $data)) {
            redirect('/');
        }
        // Liste de tags les + utilisés / Liste des localisations (departements)
        if (isset($data['tags'])) {
        }
        var_dump($data);
    }
}
