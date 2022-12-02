<?php
    $server = "teamzy.go.yj.fr";
    $login = "root";
    $mdp = "";
    $db = "kvefnnxj_teamzy";

    ///Connexion au serveur MySQL
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
        echo "Connexion réussie";
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
?>
 