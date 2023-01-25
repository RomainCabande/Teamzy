<?php
    $idJ = $_GET['idJ'];
    $idM = $_GET['idM'];
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
    $req = $bdd->prepare("SELECT * FROM `joueur` WHERE joueur.numero_licence = ?;");
    $req->execute(array($idJ));
    $data = $req->fetch(PDO::FETCH_NUM);
?>
<html lang="en" id="feuilleMatch">
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
        <h1>Feuille de match de <?PHP echo $data[1]." ".$data[2] ?></h1>
        <form action="modifierMatch.php" method="GET">
            <div class="part">
                <input type="hidden" name="idJ" value="<?PHP echo $data[1] ?>">
                <div>
                   <label for="note">Note du match</label> 
                </div>
                
                <input type="number" name="note" min="0" max="5">
            </div>
            <div class="part">
                <div>
                   <label for="com">Commentaire</label> 
                </div>
                
                <textarea name="com" rows="5" cols="33">
                </textarea>
            </div>
            <div>
                <input type="submit" value="valider la feuille">
            </div>
        </form>
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