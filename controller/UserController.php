<?php

require_once(dirname(__DIR__).'/Request.php');

class UserController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function create()
    {
        $request = new Request(['username', 'password', 'email', 'lastname', 'firstname']);
        $data = $request->get();
        if (!keysExist(['username', 'password', 'email', 'lastname', 'firstname'], $data)) {
            view('page_404.php');
        }
        if ($this->fetch('User', ['username' => $data['username']], PDO::FETCH_ASSOC)) {
            view("user_register_forms.php", array("warning" => "Ce nom d'utilisateur existe déjà.", "registerType" => "register"));
        }

        Validate::check(
            [
              'username' => $data['username'],
              'password' => $data['password'],
              'mail' => $data['email'],
              'lastname' => $data['lastname'],
              'firstname' => $data['firstname']
            ],
            'user_register_forms.php',
            Message::$userMessages,
            'USER_WARNING',
            ['registerType' => 'register']
        );

        Validate::validLengthData(
            $data,
            [
              'username' => 30,
              'password' => 256,
              'email' => 50,
              'lastname' => 30,
              'firstname' => 30
            ],
            'user_register_forms.php',
            'USER_WARNING',
            ['registerType' => 'register']
        );

        $hash = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $_SESSION['token'] = $hash;
        $this->insert(
            'User',
            [
              'email'=> $data['email'],
              'password' => $hash,
              'username' => $data['username'],
              'lastname' => $data['lastname'],
              'firstname' => $data['firstname']
            ]
        );
        $_SESSION['id'] = $this->fetch('User', ['email' => $data['email']], PDO::FETCH_OBJ)->id;
        $link = randomPassword();
        var_dump($data['email']);
        sendHtmlMail($data['email'], "<a href=http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].'/confirm/'.$link."> Confirmer votre compte</a>", "Mail de confirmation");
        //view("user_register_forms.php", ['registerType' => 'login']);
    }
}
