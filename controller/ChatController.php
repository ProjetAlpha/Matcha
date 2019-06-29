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

    public function addMessage()
    {
        $request = new Request();
        $data = $request->toJson();
        //roomId:this.roomId, message:this.message, time:time
        if (!keysExist(['roomId', 'message', 'time'], $data) || empty($data)) {
            redirect('/');
        }
        //var_dump($data);
        /*$validate = new Validate(
            $data,
            [
            'user_id' => 'digit|max:11',
            'message' => 'digit|max:11',
            'time' => 'date'
          ],
            'sendToJs',
            Message::$userMessages
        );*/
        $this->insert('Message', ['user_id' => $_SESSION['user_id'], 'room_id' => $data['roomId'],'content' => $data['message'], 'date' => $data['time']]);
        $this->insert('Rooms', ['last_msg_date'], ['id' => $data['roomId']]);
    }

    public function searchMatchedUser()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['search'], $data) || empty($data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
            'search' => 'alpha|min:1|max:30'
          ],
            'sendToJs',
            Message::$userMessages
        );
        if (!empty($validate->loadedMessage)) {
            return ;
        }
        $result = $this->chat->findMatchedUser($_SESSION['user_id'], $data['search']);
        echo json_encode(['searchMatchedUser' => $result]);
    }
}
