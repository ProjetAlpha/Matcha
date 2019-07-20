<?php


class NotificationController
{
    public function getAll()
    {
        if (($notifications = $this->fetchAll('Notification', ['user_id' => $_SESSION['user_id']], PDO::FETCH_ASSOC))) {
            $result = $this->notification->fetchNotificationsInfo($notifications);
            echo encodeToJs(['notifications' => $result]);
        }
    }
}
