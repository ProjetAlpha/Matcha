<?php

class LikeController extends Models
{
    public function setLike()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
            'profilId' => 'digit|max:11'
          ],
            'sendToJs',
            Message::$userMessages
        );
        if (!empty($validate->loadedMessage)) {
            redirect('/');
        }
        $result = $this->fetch('Likes', ['user_id' => $_SESSION['user_id'], 'liked_by' => $data['profilId']], PDO::FETCH_ASSOC);
        if (isset($result['liked_by']) && $result['liked_by'] == $data['profilId']) {
            $this->insert('Matched', ['user_id' => $_SESSION['user_id'], 'user_profil_id' => $data['profilId']]);
            $this->insert('Matched', ['user_id' => $data['profilId'], 'user_profil_id' => $_SESSION['user_id']]);
        }
        $this->insert('Likes', ['user_id' => $data['profilId'], 'liked_by' => $_SESSION['user_id']]);
    }

    public function setDislike()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
            'profilId' => 'digit|max:11'
          ],
            'sendToJs',
            Message::$userMessages
        );
        if (!empty($validate->loadedMessage)) {
            redirect('/');
        }
        $this->delete('Likes', ['user_id' => $data['profilId'], 'liked_by' => $_SESSION['user_id']]);
    }

    public function isLikedByUser()
    {
        $isLiked = false;
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
            'profilId' => 'digit|max:11'
          ],
            'sendToJs',
            Message::$userMessages
        );
        if (!empty($validate->loadedMessage)) {
            redirect('/');
        }
        $result = $this->fetch('Likes', ['user_id' => $data['profilId'], 'liked_by' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
        if (isset($result['liked_by']) && $result['liked_by'] == $_SESSION['user_id']) {
            $isLiked = true;
        }
        echo encodeToJs(['isLiked' => $isLiked]);
    }

    public function getLikeByUser()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
            'profilId' => 'digit|max:11'
          ],
            'sendToJs',
            Message::$userMessages
        );
        if (!empty($validate->loadedMessage)) {
            redirect('/');
        }
        $result = $this->fetch('Likes', ['user_id' => $_SESSION['user_id'], 'liked_by' => $data['profilId']], PDO::FETCH_ASSOC);
        if (isset($result['liked_by'])) {
            $info = $this->fetch('User', ['id' => $result['liked_by']], PDO::FETCH_ASSOC);
            echo encodeToJs(['name' => $info['firstname']]);
        }
    }
}
