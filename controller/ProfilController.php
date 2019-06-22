<?php

require_once("ProfilEditTrait.php");

class ProfilController extends Models
{
    use ProfilEditTrait;

    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function getUserProfil()
    {
        if (isAuth()) {
            if (!$this->fetch('Profil', ['user_id' => $_SESSION['user_id']])) {
                view('profil.php', ['warning' => 'Veuillez complété votre profil']);
            }
            $query = encodeToJs($this->profil->fetchUserProfilData($_SESSION['user_id']));
            view('profil.php', ['userProfilData' => $query, 'profilType' => 'userProfilOwner']);
        } else {
            redirect('/');
        }
    }

    public function editProfil()
    {
        $request = new Request();
        $isNewProfil = false;
        $data = $request->toJson();
        $type = $this->getEditType($data);
        if ($this->fetch('Profil', ['user_id' => $_SESSION['user_id']])) {
            $isNewProfil = true;
        }
        if (empty($type)) {
            redirect('/');
        }
        if (!$isNewProfil) {
            $this->insert('Profil', ['user_id' => $_SESSION['user_id'], $type => $data[$type]]);
        } else {
            $this->update('Profil', [$type => $data[$type]], ['user_id' => $_SESSION['user_id']]);
        }
    }

    public function getData()
    {
        $result = $this->fetch('Profil', ['user_id' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
        echo encodeToJs($result);
    }

    public function getVisitedProfil($userId)
    {
        if (isset($userId)) {
            $result = $this->profil->fetchUserProfilData($userId);
            if (!$result) {
                // si il a pas complete le profil => afficher juste lastname + firstname + photo par defaut.
                view('page_404.php');
            } else {
                // function sur validate (pour redirect ou on veut...)
                // $validate = new Validate($result, ['user_id' => 'digit|min:1|max:11'], 'editProfil.php', Message::$userMessages);
                if ($result['user_id'] !== $_SESSION['user_id']) {
                    if (!$this->fetch('Visite', ['user_id' => $userId, 'visiter_id' => $_SESSION['user_id']])) {
                        $this->insert('Visite', ['user_id' => $userId, 'visiter_id' => $_SESSION['user_id']]);
                    }
                    $result['visitedUserId'] = $userId;
                    view('profil.php', ['userProfilData' => encodeToJs($result), 'profilType' => 'consultUserProfil']);
                } else {
                    $this->getUserProfil();
                }
            }
        }
    }

    public function isOnline()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data) || empty($data)) {
            redirect('/');
        }
        // validate...
        $result = $this->user->getOnlineUser($data['profilId']);
        if (!$result) {
            redirect('/');
        }
        $minuteDiff = round(abs(strtotime($result['last_visited']) - strtotime(date("Y-m-d H:i:s"))) / 60, 2);
        if (isset($result['last_visited'])) {
            echo encodeToJs(['last_visited' => $result['last_visited'], 'minDiff' => $minuteDiff]);
        }
    }

    public function getProfilViews()
    {
        $result = $this->profil->getProfilViews($_SESSION['user_id']);
        if ($result) {
            echo encodeToJs(['visiterViews' => $result]);
        }
    }

    public function getProfilLikes()
    {
        $result = $this->profil->getProfilLikes();
    }
}
