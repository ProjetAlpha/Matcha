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
                $result['visitedUserId'] = $userId;
                view('profil.php', ['userProfilData' => encodeToJs($result), 'profilType' => 'consultUserProfil']);
            }
        }
    }
}
