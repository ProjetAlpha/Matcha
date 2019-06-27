<?php

class LikeController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function setLike()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data) || empty($data)) {
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
            $this->insert('Matched', ['user_1' => $_SESSION['user_id'], 'user_2' => $data['profilId']]);
        }
        $this->insert('Likes', ['user_id' => $data['profilId'], 'liked_by' => $_SESSION['user_id']]);
    }

    public function setDislike()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data) || empty($data)) {
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

        if (!keysExist(['profilId'], $data) || empty($data)) {
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

        if (!keysExist(['profilId'], $data) || empty($data)) {
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
