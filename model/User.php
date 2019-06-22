<?php


class User
{
    public function getOnlineUser($profilId)
    {
        $sql = "SELECT last_visited FROM `Profil` INNER JOIN User ON User.id = Profil.user_id WHERE Profil.user_id = ?";
        return (execQuery($this->db, $sql, [$profilId], PDO::FETCH_ASSOC, FETCH_ONE));
    }
}
