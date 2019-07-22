<?php

class ChatController extends Models
{
    public function fetchMatchedUser()
    {
        $matchedUser = $this->chat->getMatchedUser($_SESSION['user_id']);
        $userId = $_SESSION['user_id'];
        $result = [];
        if (($notifications = $this->notification->getAllMessageNotif($_SESSION['user_id']))) {
            foreach ($notifications as $value) {
                if ($value['is_seen'] == 1) {
                    continue;
                }
                $dstMsg = $this->notification->getUserRoom($_SESSION['user_id'], $value['room_id']);
                if ($dstMsg !== false && !$this->fetch('Blocked', ['user_id' => $userId, 'blocked_user' => $dstMsg['id']])) {
                    !isset($result[$value['room_id']]['countMessage']) ? $result[$value['room_id']]['countMessage'] = 1 : $result[$value['room_id']]['countMessage']++;
                }
            }
        }
        echo encodeToJs(['matched' => group_by('room_id', $matchedUser), 'notifications' => $result]);
    }

    public function addMessage()
    {
        $request = new Request();
        $data = $request->toJson();
        if (!keysExist(['roomId', 'message', 'time'], $data)) {
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
        $this->insert('Message', [
          'user_id' => $_SESSION['user_id'],
          'room_id' => $data['roomId'],
          'content' => $data['message'],
          'date' => $data['time']]);
        $dstUser = $this->notification->getUserRoom($_SESSION['user_id'], $data['roomId']);
        if ($dstUser !== false) {
            $this->insert('Notification', ['user_id' => $dstUser['id'], 'room_id' => $data['roomId'], 'name' => 'addroomMessage']);
        }
        $this->insert('Rooms', ['last_msg_date' => $data['time']], ['id' => $data['roomId']]);
    }

    public function searchMatchedUser()
    {
        // si le user n'est pas bloque
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['search'], $data)) {
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

    public function findUserRoom()
    {
        // si le user n'est pas bloque
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['userId'], $data)) {
            redirect('/');
        }
        $validate = new Validate(
            $data,
            [
          'userId' => 'digit|min:1|max:11'
        ],
            'sendToJs',
            Message::$userMessages
      );
        if (!empty($validate->loadedMessage)) {
            return ;
        }
        $roomId = 0;
        $haveMessages = false;
        if (($result = $this->chat->getRoom($_SESSION['user_id'], $data['userId'])) !== false) {
            if ($this->fetch('Message', ['room_id' => $result['id']])) {
                $haveMessages = true;
            }
            $roomId = $result['id'];
        } else {
            $this->insert('Rooms', ['user1_id' => $_SESSION['user_id'], 'user2_id' => $data['userId']]);
            $room = $this->fetch('Rooms', ['user1_id' => $_SESSION['user_id'], 'user2_id' => $data['userId']]);
            $roomId = $room['id'];
        }
        echo encodeToJs(['room_id' => $roomId, 'messageExist' => $haveMessages]);
    }
}
