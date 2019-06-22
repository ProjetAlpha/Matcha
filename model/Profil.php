<?php

class Profil
{
    public function fetchUserProfilData($userId)
    {
        $sql = "SELECT firstname,lastname,age,bio,score,genre,orientation,profile_pic_name,localisation,user_id
        FROM User INNER JOIN Profil ON User.id = Profil.user_id WHERE User.id = ?";
        $userInfo = execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC, FETCH_ONE);
        $sql = "SELECT name FROM Tag WHERE user_id=?";
        $userTags = execQuery($this->db, $sql, [$userId], PDO::FETCH_COLUMN, FETCH_ALL);
        $userInfo['tags'] = $userTags;
        return ($userInfo);
    }

    public function getProfilViews($userId)
    {
        // 10 tags  / 2 users. [ name, visiter_id]
        // regrouper les tags / users.
        // name [10], 2 user
        $sql ="SELECT lastname,firstname,age,localisation,last_visited,profile_pic_path,profile_pic_name,User.id
      FROM Profil INNER JOIN User ON Profil.id = User.id INNER JOIN Visite ON Visite.visiter_id = User.id WHERE Visite.user_id = ?";
        $visitedUserInfo = execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC, FETCH_ALL);
        // 1er v-for (user info) - 2eme v-for (user tags[key]) tags[0] = 1er user, tags[1] = 2eme user.
        // group les noms par user_id...
        $sql = "SELECT name,visiter_id FROM Tag INNER JOIN Visite ON Visite.visiter_id = Tag.user_id WHERE Visite.user_id = ?";
        // solution degeux : fetch les tags au fur et a mesure pour chaque user...
        $visitedUserTags = execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC, FETCH_ALL);
        $visitedUserInfo['visiterTags'] = $visitedUserTags;
        return ($visitedUserInfo);
    }

    public function getProfilLikes()
    {
        // inner join profil + user + likes
    }
}
