<?php
    $server = "localhost";
    $login = "kvefnnxj_user";
    $mdp = "User4phpmyadminpassword";
    $db = "kvefnnxj_teamzy";
    $userLogin = $_POST["username"];

    ///Connexion au serveur MySQL
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $selectLoginPassword = 'SELECT login, hashed_mdp FROM entraineur';
    foreach  ($linkpdo->query($selectLoginPassword) as $row) {
        $loginFromBDD = $row['login'];
        $passwordHashedFromBDD = $row['hashed_mdp'];
    }

    if($userLogin == $loginFromBDD AND password_verify($_POST["password"], $passwordHashedFromBDD)) {
        header('Location: ../accueil.html');
    } else {
        header('Location: ../index.html');
    }
?>
 