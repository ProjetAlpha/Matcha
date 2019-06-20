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
            $query = $this->profil->fetchUserProfilData($_SESSION['user_id']);
            view('profil.php', ['userProfilData' => $query]);
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
}
