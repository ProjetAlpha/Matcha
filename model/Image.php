<?php

class Image
{
    public function getLikeProfilByUser($profilId)
    {
        $query = "SELECT user_id,liked_by FROM Profil INNER JOIN Likes ON Profil.user_id = ? WHERE Likes.liked_by = ?";
    }
}
