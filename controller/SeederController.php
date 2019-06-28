<?php

class SeederController extends Models
{
    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    /**
     * Optimized sql insert.
     */
    public function storeSeed()
    {
        $request = new Request();
        $data = $request->toJson();
        $connection = mysqli_connect("mysql", "root", "rootpass");
        $db_select = mysqli_select_db($connection, "Matcha");
        $sqlUser = '';
        $sqlProfil = '';
        $sqlTag = '';
        $lastId = mysqli_query($connection, "SELECT id FROM User ORDER BY id DESC LIMIT 1")->fetch_row()[0];
        $currentId = ++$lastId;
        foreach ($data as $value) {
            $id = 0;
            // modifier par sha1 + hash_equals au lieu de password_verify si besoin.
            if (isset($value['login'], $value['age'], $value['name'], $value['email'])) {
                $sqlUser .= "('".$value['login']['username']."','".password_hash($value['login']['password'], PASSWORD_BCRYPT, ['cost' => 4])."','".$value['name']['first']."','"
                .$value['name']['last']."','".$value['age']."',1,'".$value['email']."'),";
            }
            if (isset($value['location'], $value['gender'], $value['score'], $value['picture'], $value['orientation']) && isset($id)) {
                $sqlProfil .= "('".$currentId."','".'lorem'."','"
              .$value['score']."','".$value['gender']."','".$value['orientation']."','".$value['location']['city'].", France','"
              .$value['picture']['large']."','".$value['picture']['name']."','".$value['location']['longitude'].
              "','".$value['location']['latitude']."'),";
            }

            if (isset($value['tags']) && isset($id)) {
                foreach ($value['tags'] as $value) {
                    $sqlTag .= "('".$currentId."','".$value."'),";
                }
            }
            ++$currentId;
        }
        $sqlUserRes = substr($sqlUser, 0, -1);
        $sqlProfilRes = substr($sqlProfil, 0, -1);
        $sqlTagRes = substr($sqlTag, 0, -1);
        mysqli_query($connection, "INSERT INTO User (username,password,firstname,lastname,age,is_confirmed,email) VALUES {$sqlUserRes}");
        //echo mysqli_errno($connection) . ": " . mysqli_error($connection) . "\n";
        mysqli_query($connection, "INSERT INTO Profil (user_id,bio,score,genre,orientation,localisation,profile_pic_path,profile_pic_name,longitude,latitude)
        VALUES {$sqlProfilRes}");
        //echo mysqli_errno($connection) . ": " . mysqli_error($connection) . "\n";
        mysqli_query($connection, "INSERT INTO Tag (user_id, name) VALUES {$sqlTagRes}");
        //echo mysqli_errno($connection) . ": " . mysqli_error($connection) . "\n";
        mysqli_close($connection);
    }
}
