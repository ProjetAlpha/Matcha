<?php

class ImageController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function addProfilImg()
    {
        $request = new Request();
        $data = $request->toJson();
        if (!keysExist(['name'], $data) || empty($data)) {
            redirect('/');
        }
        $path = dirname(__DIR__).'/ressources/images/'.$_SESSION['user_id'].'/'.sha1($data['name']).'.png';
        if (file_exists($path)) {
            $this->update('Image', ['is_profil_pic' => 1], ['user_id' => $_SESSION['user_id'], 'name' => $data['name']]);
            $this->update('Profil', ['profil_pic' => $path], ['user_id' => $_SESSION['user_id']]);
            echo encodeToJs(['path' => base64_encode(file_get_contents($path))]);
        }
    }

    public function addImg()
    {
        $request = new Request();
        $data = $request->toJson();
        if (!keysExist(['image', 'name'], $data) || empty($data)) {
            redirect('/');
        }
        if ($this->fetch('Image', ['user_id' => $_SESSION['user_id'], 'name' => $data['name']])) {
            view('editProfil.php', ['warning' => Message::$userMessages['duplicate_img']]);
        }
        $validate = new Validate($data, ['image' => $data['image']], 'editProfil.php', Message::$userMessages);
        if (!file_exists(dirname(__DIR__).'/ressources/images/'.$_SESSION['user_id'])) {
            mkdir(dirname(__DIR__).'/ressources/images/'.$_SESSION['user_id']);
        }
        $path = dirname(__DIR__).'/ressources/images/'.$_SESSION['user_id'].'/'.sha1($data['name']).'.png';
        $image = imagecreatefromstring(extract_base64(trim($data['image'])));
        imagepng($image, $path);
        $this->insert('Image', ['name' => $data['name'], 'user_id' => $_SESSION['user_id'], 'path' => $path]);
        echo encodeToJs(['path' => base64_encode(file_get_contents($path))]);
    }

    public function deleteImg()
    {
        $request = new Request();
        $data = $request->toJson();
        if (!keysExist(['name'], $data) || empty($data)) {
            redirect('/');
        }
        $path = dirname(__DIR__).'/ressources/images/'.$_SESSION['user_id'].'/'.sha1($data['name']).'.png';
        if (file_exists($path)) {
            unlink($path);
        }
        $this->delete('Image', ['name' => $data['name'], 'user_id' => $_SESSION['user_id']]);
    }

    public function getImg()
    {
        $result = $this->fetchAll('Image', ['user_id' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
        if (!$result) {
            redirect('/');
        }
        foreach ($result as &$value) {
            $name = $value['name'];
            if (isset($name)) {
                $path = dirname(__DIR__).'/ressources/images/'.$_SESSION['user_id'].'/'.sha1($name).'.png';
                $im = file_get_contents($path);
                $value['path'] = base64_encode($im);
            }
        }
        echo encodeToJs($result);
    }

    public function getProfilPic()
    {
        $result = $this->fetch('Image', ['user_id' => $_SESSION['user_id'], 'is_profile_pic' => 1], PDO::FETCH_ASSOC);
        if (!$result) {
            $result = $this->fetch('Profil', ['user_id' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
            $path = base64_encode(file_get_contents($result['profile_pic']));
        } else {
            $path = base64_encode(file_get_contents($result['path']));
        }
        echo encodeToJs(['path' => $path, 'name' => $result['name']]);
    }
}
