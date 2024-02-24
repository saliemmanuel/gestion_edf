<?php

// @autor 
// SALI EMMANUEL
// Tel : 698066896
// github : github.com/saliemmanuel

class API
{

    //Service inscription utilisateur
    public function inscription($bdd)
    {
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $phone = $_POST["phone"];
        $picture = $_POST["picture"];
        $isactive = $_POST["isactive"];
        $ville_id = $_POST["ville_id"];
        $status = $_POST["status"];
        $compte = $_POST["compte"];

        if ($compte == 'client') {
            $requet1 = 'INSERT INTO `clients`(`id`, `name`, `surname`, `email`, 
            `password`, `phone`, `picture`, `isactive`, `ville_id`, `created_at`, 
            `updated_at`) VALUES (NULL,"' . $name . '","' . $surname . '",
            "' . $email . '","' . $password . '","' . $phone . '",
            "' . $picture . '","' . $isactive . '","' . $ville_id . '",
            "' . $email . '","' . $email . '")';
        } else {
            $requet1 = 'INSERT INTO `prestataires`(`id`, `name`, `surname`, 
            `email`, `password`, `status`, `phone`, `picture`, 
            `isactive`, `ville_id`, `created_at`, `updated_at`) 
            VALUES (NULL,"' . $name . '","' . $surname . '",
            "' . $email . '","' . $password . '","' . $status . '","' . $phone . '",
            "' . $picture . '","' . $isactive . '","' . $ville_id . '",
            "' . $email . '","' . $email . '")';
        }
        $prepare1 = $bdd->prepare($requet1);
        $ins = $prepare1->execute();
        if ($ins === false) {
            $message = array('message' => 'E-mail déjà utiliser .', 'error' => '1');
        } else {
            $message =   array('message' => "Inscription effectué", 'error' => '0');
        }
        return  json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }
    
    // service connexion utilisateur
    public function connexion($bdd)
    {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);
        $compte = $_POST["compte"];

        if ($compte == 'client') {
            $connexion = 'SELECT * FROM `clients` WHERE `email` ="' . $email . '" AND
        `password` = "' . $password . '"';
        } else {
            $connexion = 'SELECT * FROM `prestataires` WHERE `email` ="' . $email . '" AND
        `password` = "' . $password . '"';
        }

        $getConnexion = $bdd->prepare($connexion);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "E-mail ou mot de passe incorrect.", "error" => '1');
        } else {
            $message = array(
                'message' => "Connexion effectué "  . $compte, 'id' => $responce[0]['id'],
                'name' => $responce[0]['name'],
                'surname' => $responce[0]['surname'],
                'email' => $responce[0]['email'],
                'status' => $responce[0]['status'],
                'phone' => $responce[0]['phone'],
                'ville_id' => $responce[0]['ville_id'],
                'isactive' => $responce[0]['isactive'],
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }

    public function getAnnonce($bdd)
    {
        $ann = "SELECT * FROM `annonces` WHERE 1 ORDER BY `annonces`.`id` DESC";
        $get = $bdd->prepare($ann);
        $get->execute();
        $responce = $get->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Aucune annonce disponible.", "error" => '1');
        } else {
            $message = array(
                'message' => "Succès ",
                'data' => $responce,
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }
    public function getClientInf($bdd)
    {
        $client_id = $_POST['client_id'];
        $getclient = 'SELECT * FROM `clients`  WHERE  `id` = "' . $client_id . '"';
        $getConnexion = $bdd->prepare($getclient);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Erreur.", "error" => '1');
        } else {
            $message = array(
                'message' => "effectué ", 'id' => $responce[0]['id'],
                'name' => $responce[0]['name'],
                'surname' => $responce[0]['surname'],
                'email' => $responce[0]['email'],
                'status' => $responce[0]['status'],
                'phone' => $responce[0]['phone'],
                'ville_id' => $responce[0]['ville_id'],
                'isactive' => $responce[0]['isactive'],
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }
    public function getPresInf($bdd)
    {
        $client_id = $_POST['prestataire_id'];
        $getclient = 'SELECT * FROM `prestataires`  WHERE  `id` = "' . $client_id . '"';
        $getConnexion = $bdd->prepare($getclient);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Erreur.", "error" => '1');
        } else {
            $message = array(
                'message' => "effectué ", 'id' => $responce[0]['id'],
                'name' => $responce[0]['name'],
                'surname' => $responce[0]['surname'],
                'email' => $responce[0]['email'],
                'status' => $responce[0]['status'],
                'phone' => $responce[0]['phone'],
                'ville_id' => $responce[0]['ville_id'],
                'isactive' => $responce[0]['isactive'],
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }

    public function getDiscution($bdd)
    {
        $compte = $_POST['compte'];
        $client_id = $_POST['client_id'];
        $prestataire_id = $_POST['prestataire_id'];
        if ($compte == 'client') {
            $req = 'SELECT * FROM `messages` WHERE client_id =  "' . $client_id . '"
              GROUP BY  `prestataire_id`; ';
        } else {
            $req = 'SELECT * FROM `messages` WHERE `prestataire_id` = "' . $prestataire_id . '" 
            GROUP BY  `client_id` ';
        }
        $get = $bdd->prepare($req);
        $get->execute();
        $responce = $get->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Indisponible.", "error" => '1');
        } else {
            $message = array(
                'message' => "Succès ",
                'data' => $responce,
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }

    public function getConversation($bdd)
    {
        $client_id = $_POST['client_id'];
        $prestataire_id = $_POST['prestataire_id'];
        $req = 'SELECT * FROM `messages` WHERE  `client_id` = "' . $client_id . '"  
        AND `prestataire_id` = "' . $prestataire_id . '" ';
        $get = $bdd->prepare($req);
        $get->execute();
        $responce = $get->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Indisponible.", "error" => '1');
        } else {
            $message = array(
                'message' => "Succès ",
                'data' => $responce,
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }
    public function sendMessage($bdd)
    {
        $message = $_POST['message'];
        $readstatus = $_POST['readstatus'];
        $receivedstatus = $_POST['receivedstatus'];
        $deletestatus = $_POST['deletestatus'];
        $client_id = $_POST['client_id'];
        $prestataire_id = $_POST['prestataire_id'];
        $created_at = $_POST['created_at'];

        $req = 'INSERT INTO `messages` (`id`, `message`, `readstatus`, 
       `receivedstatus`, `deletestatus`, `client_id`, `prestataire_id`, 
       `created_at`, `updated_at`) VALUES 
       (NULL, "' . $message . '" , "' . $readstatus . '", "' . $receivedstatus . '", 
       "' . $deletestatus . '", "' . $client_id . '", "' . $prestataire_id . '", "' . $created_at . '", NULL)';
        $get = $bdd->prepare($req);
        $get->execute();
    }

    public function getPubForPresta($bdd)
    {
        $prestataire_id = $_POST['prestataire_id'];
        $re = 'SELECT * FROM `publications` WHERE `prestataire_id` = "' . $prestataire_id . '"';
        $getConnexion = $bdd->prepare($re);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Erreur.", "error" => '1');
        } else {
            $message = array(
                'message' => "effectué ",
                'data' => $responce,
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }

    public function getPubForClient($bdd)
    {
        $client_id = $_POST['client_id'];
        $re = 'SELECT *  FROM `annonces` WHERE  `client_id` = "' . $client_id . '"';
        $getConnexion = $bdd->prepare($re);
        $getConnexion->execute();

        $responce = $getConnexion->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Erreur.", "error" => '1');
        } else {
            $message = array(
                'message' => "effectué ",
                'data' => $responce,
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }
    
    public function putPub($bdd)
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $prestataire_id = $_POST['prestataire_id'];

        $re = 'INSERT INTO `publications` (`id`, `title`, `description`,
         `picture`, `prestataire_id`, `created_at`, `updated_at`)
         VALUES (NULL, "' . $title . '", "' . $description . '", 
         "' . $prestataire_id . '", "' . $prestataire_id . '", NULL, NULL)';
        $getConnexion = $bdd->prepare($re);
        $getConnexion->execute();
    }
    public function putAnn($bdd)
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $client_id = $_POST['client_id'];

        $re = 'INSERT INTO `annonces`(`id`, `title`, `description`,
         `picture`, `client_id`, `created_at`, `updated_at`)
         VALUES (NULL, "' . $title . '", "' . $description . '", 
         "' . $client_id . '", "' . $client_id . '", NULL, NULL)';
        $getConnexion = $bdd->prepare($re);
        $getConnexion->execute();
    }

    public function getPublication($bdd)
    {
        $ann = "SELECT * FROM `publications` WHERE 1";
        $get = $bdd->prepare($ann);
        $get->execute();
        $responce = $get->fetchAll(PDO::FETCH_ASSOC);
        if (empty($responce)) {
            $message = array('message' => "Aucune annonce disponible.", "error" => '1');
        } else {
            $message = array(
                'message' => "Succès ",
                'data' => $responce,
                'error' => '0'
            );
        }
        return json_encode(array($message), JSON_UNESCAPED_UNICODE);
    }

    //GESTION DES ERREURS DE L'API 
    public function serviceInconnu()
    {
        return json_encode(array(["message" => "serviceInconnu", "error" => "1"]));
    }

    public function errorService()
    {
        return json_encode(array(["message" => "errorService", "error" => "1"]));
    }
}
