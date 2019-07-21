<?php

class Notification
{
    public function getUserInfo($userId, $type)
    {
        $sql = "SELECT firstname,lastname,User.id FROM User WHERE User.id = ?";
        $result = execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC, FETCH_ONE);
        $result['type'] = $type;
        return ($result);
    }

    public function getVisiter($userId, $currentUser)
    {
        $sql = "SELECT firstname,lastname,User.id FROM User
        INNER JOIN Visite ON User.id = Visite.visiter_id WHERE Visite.visiter_id = ? AND Visite.user_id = ?";
        $result = execQuery($this->db, $sql, [$userId, $currentUser], PDO::FETCH_ASSOC, FETCH_ONE);
        $result['type'] = 'visiter';
        return ($result);
    }

    public function getUserRoom($userId, $roomId)
    {
        $sql = "SELECT firstname,lastname,User.id,Rooms.id AS 'room_id' FROM User
        INNER JOIN Rooms ON Rooms.user1_id = User.id OR Rooms.user2_id = User.id
        WHERE Rooms.id = ?";
        $result = execQuery($this->db, $sql, [$roomId], PDO::FETCH_ASSOC, FETCH_ALL);
        $dstUser = $result[0]['id'] !== $userId ? $result[0] : $result[1];
        $result['type'] = 'message';
        return ($result);
    }
}
