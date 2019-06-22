<?php

class TagController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function addTag()
    {
        $request = new Request();
        $isNewProfil = false;
        $data = $request->toJson();
        if (!array_key_exists('name', $data) || empty($data['name'])) {
            redirect('/');
        }
        if ($this->fetch('Tag', ['user_id' => $_SESSION['user_id'], 'name' => $data['name']])) {
            die();
        }
        $this->insert('Tag', ['user_id' => $_SESSION['user_id'], 'name' => $data['name']]);
    }

    public function deleteTag()
    {
        $request = new Request();
        $data = $request->toJson();
        if (!array_key_exists('name', $data) || empty($data['name'])) {
            redirect('/');
        }
        $this->delete('Tag', ['name' => $data['name']], ['user_id' => $_SESSION['user_id']]);
    }

    public function getTag()
    {
        $tags = $this->fetchAll('Tag', ['user_id' => $_SESSION['user_id']], PDO::FETCH_ASSOC);
        if ($tags) {
            echo encodeToJs($tags);
        }
    }
}