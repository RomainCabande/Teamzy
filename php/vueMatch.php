<?php
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = $bdd->prepare("SELECT matchs.* from matchs where id_match = $id");
        $rs->execute();
        $data = $rs->fetch(PDO::FETCH_NUM);
        $rs2 = $bdd->prepare("SELECT COUNT(matchs.id_match) FROM matchs WHERE matchs.id_match = ? AND id_match IN (SELECT matchs.id_match From matchs where concat(matchs.date_match, ' ', matchs.heure) < NOW())");
        $rs2->execute(array($_GET['id']));
        $todate = $rs2->fetch(PDO::FETCH_NUM);
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
            <?php
                echo "<p> Adversaire : ".$data[3]."</p>
                    <p> Date : ".$data[1]."</p>
                    <p> Heure : ".$data[2]."</p>";
                if($todate[0] == 1):
            ?>

            <form action="vueMatch" method="post">
                    <label for="enemy">Score Adverse </label>
                    <input type="number" name="enemy" min=0>
                    <label for="us">Score Adverse </label>
                    <input type="number" name="us" min=0>
                    <input type="submit">
            </form>

            <?php endif; ?>
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
                    $res = $bdd->prepare("SELECT matchs.*,jouer.*,joueur.* FROM jouer,matchs,joueur WHERE matchs.id_match = jouer.id_match AND jouer.numero_licence = ? AND jouer.numero_licence =joueur.numero_licence ;");
                    $res->execute(array($_GET['id']));
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