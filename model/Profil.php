<?php

class Profil
{
    public function fetchUserProfilData($userId)
    {
        $sql = "SELECT firstname,lastname,age,bio,score,genre,orientation,profile_pic_name,localisation,user_id
        FROM User INNER JOIN Profil on User.id = Profil.user_id WHERE User.id = ?";
        $userInfo = execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC, FETCH_ONE);
        $sql = "SELECT name FROM Tag WHERE user_id=?";
        $userTags = execQuery($this->db, $sql, [$userId], PDO::FETCH_COLUMN, FETCH_ALL);
        $userInfo['tags'] = $userTags;
        return ($userInfo);
    }
}
