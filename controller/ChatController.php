<?php

class ChatController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function fetchMatchedUser()
    {
        $matchedUser = $this->getMatchedUser($_SESSION['user_id']);
        echo encodeToJs('matched' => $matchedUser);
    }
}
