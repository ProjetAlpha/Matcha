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
        $this->update('Image', ['is_profil_pic' => 1], ['user_id' => $_SESSION['user_id'], 'name' => $data['name']]);
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
        echo encodeToJs(['path' => $path]);
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
}
