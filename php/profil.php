<?php
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
    $id = $_GET['id'];
    $req = $bdd->prepare("SELECT ROUND(AVG(jouer.note_joueur),1) FROM `jouer` WHERE jouer.numero_licence = ?;");
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_NUM);
    $avg = $data[0];
    $req = $bdd->prepare("SELECT * FROM `joueur` WHERE joueur.numero_licence = ?;");
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_NUM);
    
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
<body id="profil">
    <div id="contentContener">
        <h1>Profil</h1>
        <img src="../images/pp/" alt="">
        <div id="profil-content">
            <div></div>
            <?php
                echo "<img src='../images/pp/".$data[3]."' alt=''>
                <div>
                    <p>Nom : ".$data[1]."</p>
                    <p>Prénom : ".$data[2]."</p>
                </div>
                <p>Date naissance : ".$data[4]."</p>
                <div>
                    <p>Taille : ".$data[5]."cm </p>
                    <p>Poids : ".$data[6]."Kg</p>
                </div>
                <div>
                    <p>Statut : ".$data[7]."</p>
                    <p>Poste : ".$data[8]."</p>
                </div>
                <p>Note moyenne : ".$avg."/5</p>"
            ?>

        </div>
        <table id="table-stats">
            <thead>
                    <tr>
                        <th>Date</th>
                        <th>Score</th>
                        <th>Note</th>
                        <th>Commentaire</th>
                    </tr>
            </thead>
            <?PHP
                $res = $bdd->prepare("SELECT matchs.*,jouer.* FROM jouer,matchs WHERE matchs.id_match = jouer.id_match AND jouer.numero_licence = ?;");
                $res->execute(array($id));
                foreach ($res as $row){
                    echo"<tr><td>{$row['date_match']}</td><td>{$row['nom_equipe_adverse']} ".$row['score_adverse']." : ".$row['score_equipe']." Votre Club</td><td>{$row['note_joueur']}</td><td>{$row['commentaire']}</td>\n";
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