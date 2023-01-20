<?php
    if(isset($_GET["search"])){
        $keyword = $_GET['search'];
    }
?>
<html lang="en" id="accueil">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='../css/styles.css' rel='stylesheet' type='text/css'>
    <title>Teamzy-Matchs</title>
    <link rel="icon" href="../images/logo_teamzy.png">
</head>
<header>
    <a href="accueil.php" id="lg"><img src="../images/logo_teamzy+text.png" alt="logo haut de page"></a>
    <a href="joueurs.php" class="headerLink">Joueurs</a>
    <a href="matchs.php" class="headerLink">Matchs</a>
    <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body id="match">
    <div id="contentContener">
    <div id="head">
            <h1>Matchs</h1>
            <a id="btnAdd" href="gestionMatch.php">Ajouter un match</a>
        </div>
        
        <form id="recherche">
            <form method="get" action="recherche.php" >
                <input type="search" name="search" placeholder="Rechercher ...">
                <input type="submit" value="Rechercher">
        </form>
        <table id="tableMatchs">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Equipe Adverse</th>
                    <th>Lieu</th>
                </tr>
            </thead>
            <?PHP
                ///Connexion au serveur MySQL
                $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
                if(isset($keyword)){
                    /* 
                    $res = $bdd->prepare("SELECT * FROM contact ");
                    $res->execute();
                    
                    $data = $res->fetchAll();
                    print_r($data);
                    */
                    
                    $res = $bdd->prepare("SELECT m.* FROM matchs as m WHERE UPPER(concat(date_match,heure,nom_equipe_adverse,lieu)) LIKE UPPER('%$keyword%')");
                    $res->execute();
                }else{
                    $res = $bdd->prepare("SELECT matchs.* FROM matchs");
                    $res->execute();
                    foreach ($res as $row){
                    echo"<tr><td>{$row['date_match']}</td><td>{$row['nom_equipe_adverse']}</td><td>{$row['lieu']}</td><td><a href='modifierMatch.php?id={$row['id_match']}'><img src='../images/supp.svg' alt=''></a><a href='modifierMatch.php?id={$row['id_match']}'><img src='../images/modif.svg' alt=''></a><a href='vueMatch.php?id={$row['id_match']}'><img src='../images/voir.svg' alt=''></a></td>\n";
                    }
                }

                // while ($row = $res->fetch()) {
                //     echo"<tr><td>{$row['nom']}</td><td>{$row['prenom']}</td><td>{$row['adresse']}
                //     </td><td>{$row['codepostal']}</td><td>{$row['ville']}</td><td>{$row['telephone']}</td>\n";
                // }
                foreach ($res as $row){
                    echo"<tr><td>{$row['date_match']}</td><td>{$row['nom_equipe_adverse']}</td><td>{$row['lieu']}</td><td><a href='modifierMatch.php?id={$row['id_match']}'><img src='../images/supp.svg' alt=''></a><a href='modifierMatch.php?id={$row['id_match']}'><img src='../images/modif.svg' alt=''></a><a href='vueMatch.php?id={$row['id_match']}'><img src='../images/voir.svg' alt=''></a></td>\n";
                }    
            ?>
        </table>
    </div>
    <footer>
        <div id="grid-footer">
            <div id="info">
                <p>Nous Contacter</p>
                <p>Politique des données</p>
                <p>Termes et conditions</p>
            </div>
            <div id="reseaux">
                <p>Nos reseaux</p>
                <div id="logoReseau">
                    <img src="../images/facebook.svg" alt="">
                    <img src="../images/twitter.svg" alt="">
                    <img src="../images/Instagram.svg" alt=""> 
                </div>    
            </div>
        </div>
        <div id="droit">
            <p>Tous droits reservé 2022 Teamzy.com Inc ©</p>
        </div>
    </footer>
</body>
</html>