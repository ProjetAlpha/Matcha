<?php

require_once('SearchAlgoTrait.php');

class SearchController extends Models
{
    use SearchAlgoTrait;

    public function searchSugestions()
    {
        //  si le numero de la page === 1, refresh le cache, sinon paginate avec les datas en cache.
        $result = [];
        $usersCollection = $this->search->fetchAllUsersInfo();
        $currentUser = $this->search->fetchCurrentUserInfo($_SESSION['user_id']);
        $commonTags = $this->search->fetchCommonTags($_SESSION['user_id']);
        $currentUserTags = oneDimArray($this->search->fetchUserTags($_SESSION['user_id']));

        foreach ($usersCollection as $user) {
            if ($currentUser->id == $user->id) {
                continue;
            }
            $targetUserTags = '';
            $score = 0.0;
            if ($currentUser->orientation === $user->orientation) {
                $score += $this->getOrientation($currentUser->orientation, $user->orientation, $currentUser->genre, $user->genre);
            } else {
                $score += 10;
            }
            $distance = geoCoordsDistance($currentUser->latitude, $currentUser->longitude, $user->latitude, $user->longitude);
            if ($distance !== 0.0) {
                $score += $this->getDistance($distance);
            }
            $score += $this->getPopularity($currentUser->score, $user->score);
            if (isset($commonTags[$user->id])) {
                $targetUserTags = array_unique(oneDimArray($commonTags[$user->id]));
                $score += $this->getTags(
                  $currentUserTags,
                  $targetUserTags
              );
            } else {
                $score += 5;
            }
            if ($score !== 0.0) {
                $formatDist = round($distance, 3);
                $user->computed_score = $score;
                $user->km = (int)$formatDist;
                $user->meters = (int)(($formatDist - (int)$formatDist) * 1000);
                $user->commonTags = $targetUserTags;
                $result[] = $user;
            }
        }
        usort($result, function ($a, $b) {
            return $a->computed_score > $b->computed_score;
        });
        // - hit le cache pour : pagination / filtre / sort.
        $key = 'sugestion:'.$_SESSION['user_id'];
        $this->redis->set($key, encodeToJs($result));
        echo encodeToJs(['sugestions' => array_slice($result, 0, 10)]);
    }

    public function paginateSugestion()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['pageNumber'], $data) || empty($data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
            'pageNumber' => 'digit|max:4'
          ],
            'sendToJs',
            Message::$userMessages
        );
        if (!empty($validate->loadedMessage)) {
            redirect('/');
        }
        $key = 'sugestion:'.$_SESSION['user_id'];
        $result = json_decode($this->redis->get($key));
        $startData = (($data['pageNumber'] - 1) * 10);
        echo encodeToJs(['result' => array_slice($result, $startData, 10)]);
    }

    public function sortSugestionsResults()
    {
        // sort / filtrer les resultats mis en cache
        // update les resultats mis en cache
        // repaginate => redirect page 1
    }

    public function searchUsers()
    {
        // met en cache les resultats de la recherche [paginate ...]
        // si le numero de la page === 1, refresh le cache, sinon paginate avec les datas en cache.
    }

    public function sortUsersResults()
    {
        // sort / filtrer les resultats mis en cache
        // update les resultats mis en cache
        // repaginate => redirect page 1
    }
}
