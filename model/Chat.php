<?php

class Chat
{
    public function getMatchedUser($userId)
    {
        $sql = "SELECT Matched.user_id,user_profil_id,lastname,firstname,last_visited,profile_pic_path from Matched
        INNER JOIN Profil ON Profil.user_id = user_profil_id
        INNER JOIN User ON User.id = Profil.user_id
        WHERE Matched.user_id = ?";

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
