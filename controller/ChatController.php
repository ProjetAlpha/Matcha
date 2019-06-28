<?php

class ChatController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function fetchMatchedUser()
    {
        $matchedUser = $this->chat->getMatchedUser($_SESSION['user_id']);
        echo encodeToJs(['matched' => group_by('room_id', $matchedUser)]);
    }
}
