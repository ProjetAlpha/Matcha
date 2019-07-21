<?php


class NotificationController extends Models
{
    public function getAll()
    {
        if (($notifications = $this->fetchAll('Notification', ['user_id' => $_SESSION['user_id']]))) {
            $result = [];
            $userId = $_SESSION['user_id'];
            foreach ($notifications as $value) {
                if ($value['name'] === null) {
                    continue;
                }
                if ($value['name'] == 'like' && !$this->fetch('Blocked', ['user_id' => $userId, 'blocked_user' => $value['liked_by']])) {
                    $result[] = $this->notification->getUserInfo($value['liked_by'], $value['name']);
                }
                if ($value['name'] == 'unmatch' && !$this->fetch('Blocked', ['user_id' => $userId, 'blocked_user' => $value['unmatched_by']])) {
                    $result[] = $this->notification->getUserInfo($value['unmatched_by'], $value['name']);
                }
                if ($value['name'] == 'match' && !$this->fetch('Blocked', ['user_id' => $userId, 'blocked_user' => $value['liked_by']])) {
                    $result[] = $this->notification->getUserInfo($value['liked_by'], $value['name']);
                }
                if ($value['name'] == 'visiter' && !$this->fetch('Blocked', ['user_id' => $userId, 'blocked_user' => $value['visiter_id']])) {
                    $result[] = $this->notification->getVisiter($value['visiter_id'], $userId);
                }
                if ($value['name'] == 'addroomMessage') {
                    $dstMsg = $this->notification->getUserRoom($value['user_id'], $value['room_id']);
                    if ($dstMsg !== false && !$this->fetch('Blocked', ['user_id' => $userId, 'blocked_user' => $dstMsg['id']]) && $userId == $dstMsg['id']) {
                        $result[] = $dstMsg;
                    }
                }
            }
            $result['notifCount'] = count($notifications);
            echo encodeToJs(['notifications' => $result]);
        }
    }
}
