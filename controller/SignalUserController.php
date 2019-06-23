<?php

class SignalUserController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    // reporter = 1 fois -- admin qui decide de delete le compte ou pas |
    // block ou unblock le user => liste de user blockées (sur le profil...)
    public function reportUser()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data) || empty($data)) {
            redirect('/');
        }
        $this->insert('Reported', ['user_id' => $_SESSION['user_id'], 'reported_user' => $data['profilId']]);
    }

    public function blockUser()
    {
        $request = new Request();
        $data = $request->toJson();

        if (!keysExist(['profilId'], $data) || empty($data)) {
            redirect('/');
        }
        $this->insert('Blocked', ['user_id' => $_SESSION['user_id'], 'blocked_user' => $data['profilId']]);
    }

    public function unblockUser()
    {
      $request = new Request();
      $data = $request->toJson();

      
    }

    public function isUserReported()
    {
      $request = new Request();
      $data = $request->toJson();

      if (!keysExist(['profilId'], $data) || empty($data)) {
          redirect('/');
      }
      $this->fetch('Reported', )
    }

    public function isUserBlocked()
    {
      $request = new Request();
      $data = $request->toJson();

      if (!keysExist(['profilId'], $data) || empty($data)) {
          redirect('/');
      }

    }
}
