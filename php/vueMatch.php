<?php
    //BD connexion
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'id20110031_teamzyadmin', 'D2|7M~R1PGs^Jm!W');

    //select match data for id
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $rs = $bdd->prepare("SELECT matchs.* from matchs where id_match = $id");
        $rs->execute();
        $data = $rs->fetch(PDO::FETCH_NUM);
        $us = $data[6];
        $enemy = $data[5];
        $rs3 = $bdd->prepare("SELECT count(id_match),score_adverse,score_equipe from matchs where id_match = $id AND score_adverse IS NOT NULL AND score_equipe IS NOT NULL ");
        $rs3 ->execute();
        $vic = $rs3->fetch(PDO::FETCH_NUM);
        if($vic[0] = 1){
            $us = $vic[1];
            $enemy = $vic[2];
        }
        $rs2 = $bdd->prepare("SELECT COUNT(matchs.id_match) FROM matchs WHERE matchs.id_match = ? AND id_match IN (SELECT matchs.id_match From matchs where concat(matchs.date_match, ' ', matchs.heure) < NOW())");
        $rs2->execute(array($_GET['id']));
        $todate = $rs2->fetch(PDO::FETCH_NUM);
    }

    //update match player rating, comments and status for  
    if(isset($_GET['idJ'])){
        $id = $_GET['id'];
        $rs = $bdd->prepare("SELECT matchs.* from matchs where id_match = $id");
        $rs->execute();
        $data = $rs->fetch(PDO::FETCH_NUM);
        $rs2 = $bdd->prepare("UPDATE jouer SET note_joueur=:note,commentaire=:com,titulaire=:tit  WHERE numero_licence = :id");
        $rs2->execute(array('note' => $_GET['rating'],
                            'com'=> $_GET['com'],
                            'tit'=> $_GET['statut'],
                            'id'=> $_GET['idJ']));
        $rs3 = $bdd->prepare("SELECT COUNT(matchs.id_match) FROM matchs WHERE matchs.id_match = ? AND id_match IN (SELECT matchs.id_match From matchs where concat(matchs.date_match, ' ', matchs.heure) < NOW())");
        $rs3->execute(array($_GET['id']));
        $todate = $rs3->fetch(PDO::FETCH_NUM);
    }

    //update match score
    if(isset($_GET['enemy'])){
        if(isset($_GET['us'])){
            $rs4 = $bdd->prepare("UPDATE matchs SET score_adverse=:enemy,score_equipe=:us WHERE id_match = :id");
            $rs4->execute(array('enemy' => $_GET['enemy'],
                                'us'=> $_GET['us'],
                                'id'=> $_GET['id'])); 
        }
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
            <?php endif; ?>

            <form action="vueMatch.php" method="get">
                    <input type="hidden" name="id" value="<?PHP echo $id; ?>">
                    <label for="enemy">Score Adverse </label>
                    <input type="number" name="enemy" min=0 value="<?PHP if(isset($_GET['us'])){echo $_GET['us'];} else { echo $us;}?>">
                    <label for="us">Score Equipe </label>
                    <input type="number" name="us" min=0 value="<?PHP if(isset($_GET['enemy'])){echo $_GET['enemy'];} else { echo $enemy;}?>">
                    <input type="submit">
            </form>
        </div>
        <table id="table-joueurs">
            <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Poste</th>
                    </tr>
            </thead>
            <?PHP
                //display match players
                if(isset($_GET['id'])){
                    $res = $bdd->prepare("SELECT matchs.*,jouer.*,joueur.* FROM jouer,matchs,joueur WHERE matchs.id_match = jouer.id_match AND matchs.id_match = ? AND jouer.numero_licence =joueur.numero_licence ;");
                    $res->execute(array($_GET['id']));
                    foreach ($res as $row){
                        echo"<tr><td>{$row['nom']}"." "."{$row['prenom']}</td><td>{$row['poste_prefere']}</td><td><a href='feuilleDeMatch.php?idJ={$row['numero_licence']}&idM=$id'><img src='../images/feuille.svg' alt=''></a></td></tr>\n";
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