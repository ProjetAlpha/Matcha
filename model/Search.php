<?php

class Search
{
    public function fetchAllUsersInfo()
    {
        $sql = "SELECT User.id,score,orientation,latitude,longitude,lastname,firstname,age,genre,localisation FROM User
      INNER JOIN Profil ON Profil.user_id = User.id";
        return (execQuery($this->db, $sql, [], PDO::FETCH_OBJ, FETCH_ALL));
    }

    public function fetchUserTags($userId)
    {
        $sql = "SELECT user_id,name FROM Tag WHERE user_id = ?";
        return (execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC | PDO::FETCH_GROUP, FETCH_ALL));
    }

    public function fetchCommonTags($userId)
    {
        $sql = "SELECT user_id,name FROM Tag WHERE name IN (SELECT name FROM Tag WHERE Tag.user_id = ?)";
        return (execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC | PDO::FETCH_GROUP, FETCH_ALL));
    }

    public function fetchCurrentUserInfo($userId)
    {
        $sql = "SELECT User.id,score,orientation,latitude,longitude,genre FROM User
        INNER JOIN Profil ON Profil.user_id = User.id
        WHERE User.id = ?";
        return (execQuery($this->db, $sql, [$userId], PDO::FETCH_OBJ, FETCH_ONE));
    }
}
