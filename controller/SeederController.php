<?php

class seederController extends Models
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
            // todo : test le passowrd hash avec un cout tres faible.
            if (isset($value['login'], $value['name'], $value['email'])) {
                $sqlUser .= "('".$value['login']['username']."','".$value['login']['password']."','".$value['name']['first']."','"
                .$value['name']['last']."',1,'".$value['email']."'),";
            }
            if (isset($value['location'], $value['age'], $value['gender'], $value['score'], $value['picture']) && isset($id)) {
                $sqlProfil .= "('".$currentId."','".$value['age']."','".'lorem'."','"
              .$value['score']."','".$value['gender']."','".$value['location']['city'].", France','".$value['picture']['large']."','".$value['location']['longitude']."','".$value['location']['latitude']."'),";
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
        mysqli_query($connection, "INSERT INTO User (username,password,firstname,lastname,is_confirmed,email) VALUES {$sqlUserRes}");
        mysqli_query($connection, "INSERT INTO Profil (user_id,age,bio,score,genre,localisation,profile_pic,longitude,latitude) VALUES {$sqlProfilRes}");
        mysqli_query($connection, "INSERT INTO Tag (user_id, name) VALUES {$sqlTagRes}");
        mysqli_close($connection);
    }
}
