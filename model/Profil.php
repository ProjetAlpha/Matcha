<?php

class Profil
{
    public function fetchUserProfilData($userId)
    {
        $sql = "SELECT firstname,lastname,age,bio,score,genre,orientation,profile_pic_name,localisation FROM User INNER JOIN Profil on User.id = Profil.user_id WHERE User.id = ?";
        $userInfo = execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC, FETCH_ONE);
        $sql = "SELECT name FROM Tag WHERE user_id=?";
        $userTags = execQuery($this->db, $sql, [$userId], PDO::FETCH_COLUMN, FETCH_ALL);
        $userInfo['tags'] = $userTags;
        return ($userInfo);
    }

    public function addTags($userId, $tags)
    {
        $sql = "INSERT INTO Tag (user_id, name) VALUES (?, ?)";
        $tagsNumber = count($tags);
        for ($i = 0; $i < $tagsNumber; $i++) {
            execQuery($this->db, $sql, [$userId, $tags[$i]]);
        }
    }

    public function updateTags($userId, $tags)
    {
        $sql = "UPDATE Tag SET name=? WHERE user_id=?";
        $tagsNumber = count($tags);
        for ($i = 0; $i < $tagsNumber; $i++) {
            execQuery($this->db, $sql, [$tags[$i]]);
        }
    }
}
