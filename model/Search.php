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

    public function fetchTags($userId)
    {
        $sql = "SELECT user_id,name FROM Tag";
        return (execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC | PDO::FETCH_GROUP, FETCH_ALL));
    }

    public function fetchCurrentUserInfo($userId)
    {
        $sql = "SELECT User.id,score,orientation,latitude,longitude,genre FROM User
        INNER JOIN Profil ON Profil.user_id = User.id
        WHERE User.id = ?";
        return (execQuery($this->db, $sql, [$userId], PDO::FETCH_OBJ, FETCH_ONE));
    }

    public function findResult($filter)
    {
        $match = 0;
        $sql = "SELECT User.id AS 'id',age,score,localisation,Tag.name AS 'tagName',lastname,firstname FROM User
        INNER JOIN Profil ON Profil.user_id = User.id
        INNER JOIN Tag ON Tag.user_id = User.id
      ";
        $condition = ' WHERE ';
        $value = [];
        if (isset($filter['localisation'])) {
            $value[] = $filter['localisation'];
            $condition .= "substring_index(`localisation`,',',1) = ?";
            $match++;
        }
        if (isset($filter['slider']['popularite'])) {
            $value[] = $filter['slider']['popularite']['minRange'];
            $value[] = $filter['slider']['popularite']['maxRange'];
            $condition .= $match > 0 ? ' AND score >= ? AND score <= ?' : ' score >= ? AND score <= ?';
            $match++;
        }
        if (isset($filter['slider']['age'])) {
            $value[] = $filter['slider']['age']['minRange'];
            $value[] = $filter['slider']['age']['maxRange'];
            $condition .= $match > 0  ? ' AND age >= ? AND age <= ?' : ' age >= ? AND age <= ?';
        }
        $sql .= $condition;
        return (execQuery($this->db, $sql, $value, PDO::FETCH_GROUP | PDO::FETCH_OBJ, FETCH_ALL));
    }
}
