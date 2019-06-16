<?php

class ProfilController extends Models
{
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
        // todo : trait pour le profil.
        // genre + orientation sexuelle + Biographie + Tags + Localisation + Photo de profil + Images.
        $request = new Request();
        $isNewProfil = false;
        $data = $request->toJson();
        if ($this->fetch('Profil', ['user_id' => $_SESSION['user_id']])) {
            $isNewProfil = true;
        }
        if (array_key_exists('genre', $data) && !empty($data['genre'])) {
            if ($data['genre'] !== ('Homme' || 'Femme')) {
                redirect('/');
            }
            if (!$isNewProfil) {
                // si on a pas encore de profil... => insert.
                $this->insert('Profil', ['user_id' => $_SESSION['user_id'], 'genre' => $data['genre']]);
            } else {
                $this->update('Profil', ['genre' => $data['genre']], ['user_id' => $_SESSION['user_id']]);
            }
        }
        if (array_key_exists('orientation', $data) && !empty($data['orientation'])) {
            if ($data['orientation'] !== ('Homosexuel' || 'Hétérosexuel' || 'Bisexuel')) {
                redirect('/');
            }
            if (!$isNewProfil) {
                $this->insert('Profil', ['user_id' => $_SESSION['user_id'], 'orientation' => $data['orientation']]);
            } else {
                $this->update('Profil', ['orientation' => $data['orientation']], ['user_id' => $_SESSION['user_id']]);
            }
        }
        if (array_key_exists('bio', $data) && !empty($data['bio'])) {
            $validate = new Validate($data, ['bio' => 'alphanum|min:5|max:1024'], 'editProfil.php', Message::$userMessages);
            if (!$isNewProfil) {
                $this->insert('Profil', ['user_id' => $_SESSION['user_id'], 'bio' => $data['bio']]);
            } else {
                $this->update('Profil', ['bio' => $data['bio']], ['user_id' => $_SESSION['user_id']]);
            }
        }
        if (array_key_exists('tags', $data) && !empty($data['tags'])) {
            if (!$isNewProfil) {
                $this->profil->addTags($_SESSION['user_id'], $data['tags']);
            } else {
                $this->profil->updateTags($_SESSION['user_id'], $data['tags']);
            }
        }
        if (array_key_exists('localiation', $data) && !empty($data['localisation'])) {
            if (!$isNewProfil) {
                // note : latitude + longitude a la connexion ou a la creation du compte.
                $this->insert('Profil', ['user_id' => $_SESSION['user_id'], 'localisation' => $data['localisation']]);
            } else {
                $this->update('Profil', ['localisation' => $data['localisation']], ['user_id' => $_SESSION['user_id']]);
            }
        }
    }

    public function getData()
    {
        $result = $this->fetch('Profil', ['user_id' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
        echo encodeToJs($result);
    }
}
