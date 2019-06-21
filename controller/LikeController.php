<?php

class LikeController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function setLike()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profil_id'], $data) || empty($data)) {
            redirect('/');
        }
        // validate...
        // en ligne : middelware qui update la date a chaque fois que le user consulte une page.
        // en ligne est set a l'inscription ou la connexion => middelware qd on se log.
        // si + de 30 min. inactif => derniere heure / date de visite.
        $this->insert('Likes', ['user_id' => $data['profil_id'], 'liked_by' => $_SESSION['user_id']]);
    }

    public function setDislike()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profil_id'], $data) || empty($data)) {
            redirect('/');
        }
        // validate...
        $this->delete('Likes', ['user_id' => $data['profil_id'], 'liked_by' => $_SESSION['user_id']]);
    }

    public function isLiked()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profil_id'], $data) || empty($data)) {
            redirect('/');
        }
        $result = $this->fetch('Like', ['user_id' => $data['profil_id'], 'liked_by' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
        // si liked_by === OK, on a like ce profil.
    }

    public function getLike()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profil_id'], $data) || empty($data)) {
            redirect('/');
        }
        // la personne qui a like ce profil
        // ? : si cette personne a like mon profil.
        // si $data['profil_id'] a like $_SESSION['user_id'].
        // 1 - fetch mon profil_id
        // 2 - check si liked_by = $data['profil_id'].
        // query : select user_id,liked_by from Profil inner join Likes ON Profil.user_id = Likes.user_id WHERE Likes.liked_by = $data['profil_id'].
        // ...
        //$this->fetch('Profil', ['user_id' => $_SESSION['user_id']]);
        //$result = $this->fetch('Like', ['user_id' => $data['profil_id'], 'liked_by' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
    }
}
