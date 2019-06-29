<?php

class Chat
{
    public function getMatchedUser($userId)
    {
        /*$sql = "SELECT Message.date as 'msg_time',profile_pic_path,lastname,firstname,Message.room_id AS 'room_id',
        Message.user_id as 'user_msg_id',content,
        Message.date as 'post_msg_time',user_profil_id FROM Matched
        INNER JOIN Message ON Message.user_id = Matched.user_id OR Message.user_id = user_profil_id
        INNER JOIN Rooms ON Rooms.id = Message.room_id AND ((Rooms.user1_id = Matched.user_id AND Rooms.user2_id = user_profil_id) OR (Rooms.user1_id = user_profil_id AND Rooms.user2_id = Matched.user_id))
        INNER JOIN Profil ON Profil.user_id = Message.user_id
        INNER JOIN User ON User.id = Profil.user_id
        WHERE Matched.user_id = ?
        GROUP BY Rooms.id,Message.user_id
        ORDER BY Rooms.last_msg_date ASC";*/
        $sql = "SELECT Message.date as 'msg_time',profile_pic_path,lastname,firstname,Message.room_id AS 'room_id',
        Message.user_id as 'user_msg_id',content,
        Message.date as 'post_msg_time',user_profil_id FROM Matched
        INNER JOIN Message ON Message.user_id = Matched.user_id OR Message.user_id = user_profil_id
        INNER JOIN Rooms ON Rooms.id = Message.room_id AND ((Rooms.user1_id = Matched.user_id AND Rooms.user2_id = user_profil_id) OR (Rooms.user1_id = user_profil_id AND Rooms.user2_id = Matched.user_id))
        INNER JOIN Profil ON Profil.user_id = Message.user_id
        INNER JOIN User ON User.id = Profil.user_id
        WHERE Matched.user_id = ?";
        return (execQuery($this->db, $sql, [$userId], PDO::FETCH_ASSOC, FETCH_ALL));
        /*
        SELECT Matched.user_id,user_profil_id,lastname,firstname,last_visited,profile_pic_path,content,date from Matched
        INNER JOIN Profil ON Profil.user_id = user_profil_id AND Profil.user_id = Matched.user_id
        INNER JOIN User ON User.id = Profil.user_id
        INNER JOIN Rooms ON Rooms.user1_id = Matched.user_id AND Rooms.user2_id = user_profil_id
        INNER JOIN Message ON Message.room_id = Rooms.id
        WHERE Matched.user_id = 3

        SELECT Matched.user_id,user_profil_id,lastname,firstname,last_visited,profile_pic_path,content,date,Rooms.id from Matched
        INNER JOIN Profil ON Profil.user_id = Matched.user_id OR Profil.user_id = user_profil_id
        INNER JOIN User ON User.id = Profil.user_id
        INNER JOIN Rooms ON Rooms.user1_id = Matched.user_id AND Rooms.user2_id = user_profil_id
        INNER JOIN Message ON Message.room_id = Rooms.id
        WHERE Matched.user_id = 3

        SELECT Matched.user_id,user_profil_id,lastname,firstname,last_visited,profile_pic_path from Matched
        INNER JOIN Profil ON Profil.user_id = Matched.user_id OR Profil.user_id = user_profil_id
        INNER JOIN User ON User.id = Profil.user_id
        WHERE Matched.user_id = 3

        SELECT Matched.user_id,user_profil_id,lastname,firstname,last_visited,profile_pic_path from Matched
        INNER JOIN Profil ON Profil.user_id = Matched.user_id OR Profil.user_id = user_profil_id
        INNER JOIN User ON User.id = Profil.user_id
        INNER JOIN Rooms ON Rooms.user1_id = Matched.user_id AND Rooms.user2_id = user_profil_id
        WHERE Matched.user_id = 3
         */
    }
}
