<?php
    $bdd = new PDO("mysql:host=localhost;dbname=testprojet", 'root', '');
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    
    
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='../css/styles.css' rel='stylesheet' type='text/css'>
    <title>Teamzy-Profil</title>
    <link rel="icon" href="../images/logo_teamzy.png">
</head>
<header>
    <a href="accueil.php" id="lg"><img src="../images/logo_teamzy+text.png" alt="logo haut de page"></a>
    <a href="joueurs.php" class="headerLink">Joueurs</a>
    <a href="matchs.php" class="headerLink">Matchs</a>
    <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body id="vue-match">
    <div id="contentContener">
        <h1>Récapitulatif</h1>
        <img src="../images/pp/" alt="">
        <div id="vue-match-content">
        <p></p>
            <?php
                $res = $bdd->prepare("SELECT matchs.* FROM matchs WHERE matchs.id_match = ?;");
                $res->execute(array($id));
                $data = $res->fetch(PDO::FETCH_NUM);
                echo "<p> Adversaire : ".$data['matchs.nom_equipe_adverse']."</p>
                    <p> Date : ".$data['matchs.date_match']."</p>
                    <p> Heure : ".$data['matchs.heure']."</p>";
            ?>

        </div>
        <table id="table-joueurs">
            <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Poste</th>
                    </tr>
            </thead>
            <?PHP
                if(isset($_GET['id'])){
                    $res = $bdd->prepare("SELECT matchs.*,jouer.* FROM jouer,matchs WHERE matchs.id_match = jouer.id_match AND jouer.numero_licence = ?;");
                    $res->execute(array($id));
                    foreach ($res as $row){
                        echo"<tr><td>{$row['nom']}"." "."{$row['prenom']}</td><td>{$row['poste_prefere']}</td></tr>\n";
                    }
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