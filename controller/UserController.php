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
        $request = new Request();
        $data = $request->get();
        if (!keysExist(['username', 'password', 'email', 'lastname', 'firstname'], $data)) {
            redirect('/');
        }
        if ($this->fetch('User', ['username' => $data['username']], PDO::FETCH_ASSOC)) {
            view("user_register_forms.php", array("warning" => "Ce nom d'utilisateur existe déjà.", "registerType" => "register"));
        }

        $validate = new Validate(
            $data,
            [
              'username' => 'alphanum|min:3|max:30',
              'password' => 'password|max:256|min:8',
              'mail' => 'mail|max:50|min:3',
              'lastname' => 'alpha|min:3|max:30',
              'firstname' => 'alpha|min:3|max:30'
            ],
            'user_register_forms.php',
            Message::$userMessages,
            ['registerType' => 'register']
        );

        $hash = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $_SESSION['token'] = $hash;
        $link = randomPassword();
        $this->insert(
            'User',
            [
              'email'=> $data['email'],
              'password' => $hash,
              'username' => $data['username'],
              'lastname' => $data['lastname'],
              'firstname' => $data['firstname'],
              'confirmation_link' => $link
            ]
        );
        $_SESSION['user_id'] = $this->fetch('User', ['username' => $data['username']], PDO::FETCH_OBJ)->id;
        sendHtmlMail(
            $data['email'],
            $data['firstname'],
            "<a href=http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].'/confirm/'.$link."> Confirmer votre compte</a>",
            "Mail de confirmation"
        );
        view("user_register_forms.php", array("registerType" => "login"));
    }

    public function confirm($userLink)
    {
        $query = $this->fetch('User', ['id' => $_SESSION['user_id'], 'confirmation_link' => $userLink], PDO::FETCH_OBJ);
        if (!$query) {
            redirect('/');
        }
        if (hash_equals($query->password, $_SESSION['token']) && $query->confirmation_link == $userLink) {
            $this->update('User', ['is_confirmed' => 1, 'confirmation_link' => ''], ['id' => $_SESSION['user_id']]);
        }
        redirect('/');
    }

    public function login()
    {
        $request = new Request();
        $data = $request->get();
        if (!keysExist(['username', 'password'], $data) || isAuth()) {
            redirect('/');
        }

        $validate = new Validate(
            $data,
            [
              'username' => 'alphanum|min:3|max:30',
              'password' => 'password|max:256|min:8'
            ],
            'user_register_forms.php',
            Message::$userMessages,
            ['registerType' => 'login']
        );
        $query = $this->fetch('User', ['username' => $data['username']], PDO::FETCH_OBJ);
        if (!$query) {
            view('user_register_forms.php', ['registerType' => 'login']);
        }
        if (!$query->is_confirmed) {
            view(
                'user_register_forms.php',
                array('warning' =>
            Message::$userMessages['confirm_login_info'],
            'registerType' => 'login')
          );
        }
        if (password_verify($data['password'], $query->password)) {
            $_SESSION['token'] = $query->password;
            $_SESSION['user_id'] = $query->id;
            redirect('/');
        } else {
            view(
                'user_register_forms.php',
                array('warning' =>
            Message::$userMessages['bad_credential'],
            'registerType' => 'login')
          );
        }
        redirect('/');
    }

    public function logout()
    {
        if (isset($_SESSION) && keysExist(['user_id', 'token'], $_SESSION) && isAuth()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['token']);
        }
        redirect('/');
    }
}