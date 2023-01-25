<?php
    $idM = $_GET['idM'];
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
    $req = $bdd->prepare("SELECT * FROM matchs WHERE id_match = ?;");
    $req->execute(array($idM));
    $data = $req->fetch(PDO::FETCH_NUM);
    if(isset($_GET['idJ'])){
        if(isset($_GET['note'])){
            if(isset($_GET['com'])){
                $ajout = $bdd->prepare('UPDATE jouer SET jouer  WHERE numero_licence = :idJ AND id_match = :idM');
                $ajout->execute(array('poste' => $_GET['poste']
                                ,'idJ' => $_GET['idJ']
                                ,'idM' => $_GET['idM']));
            }
            
        }
    }
?>
<html lang="en" id="modifMatch">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='../css/styles.css' rel='stylesheet' type='text/css'>
    <link rel="icon" href="../images/logo_teamzy.png">
    <title>Teamzy-Accueil</title>
</head>
<header>
        <a href="accueil.php" id="lg"><img src="../images/logo_teamzy+text.png" alt="logo haut de page" ></a>
        <a href="joueurs.php" class="headerLink">Joueurs</a>
        <a href="matchs.php" class="headerLink">Matchs</a>
        <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body>
    <div id="contentContener">
        <h1>modifications match</h1>
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