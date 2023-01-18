<?php
    $bdd = new PDO("mysql:host=localhost;dbname=testprojet", 'root', '');
    $req = $bdd->prepare("SELECT count(matchs.id_match) FROM Matchs WHERE matchs.score_adverse < matchs.score_equipe;");
    $req->execute();
    $data = $req->fetch(PDO::FETCH_NUM);
    $nbVictoire = $data[0];
    $req = $bdd->prepare("SELECT count(matchs.id_match) FROM Matchs WHERE matchs.score_adverse > matchs.score_equipe;");
    $req->execute();
    $data = $req->fetch(PDO::FETCH_NUM);
    $nbDefaite = $data[0];
    $req = $bdd->prepare("SELECT count(matchs.id_match) FROM Matchs WHERE matchs.score_adverse = matchs.score_equipe;");
    $req->execute();
    $data = $req->fetch(PDO::FETCH_NUM);
    $nbEgalite = $data[0];
    $req = $bdd->prepare("SELECT count(matchs.id_match) FROM Matchs");
    $req->execute();
    $data = $req->fetch(PDO::FETCH_NUM);
    $nbMatchs = $data[0];
?>
<html lang="en" id="accueil">
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
        <h1>Statistiques</h1>
        <table id="statVictoire">
            <thead>
                <CAPTION ALIGN="TOP"> Pourcentages resultats </CAPTION>
                <tr>
                    <th>Victoire</th>
                    <th>Défaite</th>
                    <th>Egalité</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo ($nbVictoire*100)*1 ?>% (<?php echo $nbVictoire ?>)</td>
                    <td><?php echo ($nbDefaite*100)*1 ?>% (<?php echo $nbDefaite ?>)</td>
                    <td><?php echo ($nbEgalite*100)*1 ?>% (<?php echo $nbEgalite ?>)</td>
                </tr>
            </tbody>
        </table>

        <table id="statJouer">
            <thead>
                <CAPTION ALIGN="TOP"> Joueurs avec le plus de matchs </CAPTION>
                <tr>
                    <th>Nombre Matchs</th>
                    <th>Nom</th>
                    <th>Poste</th>
                </tr>
            </thead>
            <tbody>
                
                    <?PHP
                    $res = $bdd->prepare("SELECT COUNT(jouer.id_match),joueur.nom,joueur.prenom,joueur.poste_prefere FROM `joueur`,jouer WHERE jouer.numero_licence = joueur.numero_licence ORDER BY COUNT(jouer.id_match) ASC");
                    $res->execute();
                    foreach ($res as $row){
                        echo"<tr><td>{$row[0]}</td><td>{$row['nom']} {$row['prenom']}</td><td>{$row['poste_prefere']}</td>\n";
                    }
                    ?>
                
            </tbody>
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