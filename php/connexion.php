<?php
    $server = "localhost";
    $login = "id20110031_teamzyadmin";
    $mdp = "D2|7M~R1PGs^Jm!W";
    $db = "id20110031_teamzydb";
    $userLogin = $_POST["username"];
    
    //Connexion au serveur MySQL
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp, array(PDO::ATTR_PERSISTENT => true));
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $selectLoginPassword = "SELECT login, hashed_mdp FROM entraineur";
    foreach($linkpdo->query($selectLoginPassword) as $row) {
        $loginFromBDD = $row['login'];
        $passwordHashedFromBDD = $row['hashed_mdp'];
    }

    if($userLogin == $loginFromBDD AND password_verify($_POST["password"], $passwordHashedFromBDD)) {
        header('Location: accueil.php');
    } else {
        header('Location: ../index.html');
    }
?>
 