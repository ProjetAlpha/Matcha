<?php

class ChatController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function fetchMatchedUser()
    {
        // 2 matchs => compter le nbre user_id / liked_by ---
        // 2 1001
        // 1001 2
        // SELECT user_id, likey_by from Likes WHERE user_id = ? AND liked_by = ?
        // user_id && liked_by
        // dans les liked_by chercher user_id.
        // rechercher les personnes qui ont like et celle que j ai like.
        // user_id = moi a ete like par liked_by | Pour chaque liked_by check si les likes === user_id.
        // array_compare($ownLikes, $visiterLikes)
        // Table Matched users avec user_1 user_2 => si user_id === user_1 ou user_2 => match user_ 1 ou 2.
        // si user_id === likey_by ===> Matched users [user_1, user_2]
        //$ownLikes = $this->fetchAll('Likes', ['user_id' => $_SESSION['user_id'], PDO::FETCH_OBJ);
    }
}
