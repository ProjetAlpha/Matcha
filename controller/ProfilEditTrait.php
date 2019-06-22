<?php

trait ProfilEditTrait
{
    public function getEditType($data)
    {
        $type = '';
        if (array_key_exists('genre', $data) && !empty($data['genre'])) {
            if ($data['genre'] !== ('Homme' || 'Femme')) {
                redirect('/');
            }
            $type = 'genre';
        }
        if (array_key_exists('orientation', $data) && !empty($data['orientation'])) {
            if ($data['orientation'] !== ('Homosexuel' || 'Hétérosexuel' || 'Bisexuel')) {
                redirect('/');
            }
            $type = 'orientation';
        }
        if (array_key_exists('bio', $data) && !empty($data['bio'])) {
            $validate = new Validate($data, ['bio' => 'text|min:5|max:1024'], 'editProfil.php', Message::$userMessages);
            $type = 'bio';
        }
        /*if (array_key_exists('localisation', $data) && !empty($data['localisation'])) {
            $validate = new Validate($data, ['localisation' => 'alpha|min:3|max:256'], 'editProfil.php', Message::$userMessages);
            $type = 'localisation';
        }*/
        return ($type);
    }
}
