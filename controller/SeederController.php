<?php

class seederController
{
    public function __construct()
    {
    }

    public function storeSeed()
    {
        $request = new Request();
        $data = $request->toJson();
        // store dans la db les infos.
    //$this->insert('User', [''])
    //$this->insert('Tags', [''])
    //$this->insert('Profil', [''])
    }
}
