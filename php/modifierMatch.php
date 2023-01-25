<?php
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');

    /*
    $idM = $_GET['idM'];
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
    */

    //update match for id clicked if all values are set
    if(isset($_GET['date'])) {
        if(isset($_GET['time'])) { 
            if(isset($_GET['nomEquipeAdverse'])) {
                if(isset($_GET['lieu'])) {
                    $update = $bdd->prepare("UPDATE matchs SET date_match=:date_match, heure=:heure, nom_equipe_adverse=:nomEquipeAdverse, lieu=:lieu, score_equipe=:scoreEquipe, score_adverse=:scoreAdverse WHERE id_match = :id");
                    $update->execute(array('date_match' => $_GET['date'],
                                            'heure'=> $_GET['time'],
                                            'nomEquipeAdverse'=> $_GET['nomEquipeAdverse'],
                                            'lieu'=> $_GET['lieu'],
                                            'scoreEquipe' => $_GET['scoreEquipe'],
                                            'scoreAdverse' => $_GET['scoreAdv'],
                                            'id' => $_GET['id']));
                }
            }
        }    
    }

    //get matchs data for id clicked
    $id = $_GET['id'];
    $req = $bdd->prepare("SELECT * from matchs where id_match = ?");
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_NUM);
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
<body id="pageModifMatch">
    <div id="contentContener">
        <div id="head">
            <h1>Modifier le match</h1>
        </div>
        <form id="formModifMatch" method="get" action="modifierMatch.php">
                <div>
                    <input type="hidden" name="id" value="<?php if(isset($id)){echo $data[0];} ?>">
                </div>
                <div class="dateTimeForm">
                    <label for="date">Date</label>  
                    <input type="date" name="date" value="<?php if(isset($id)){echo $data[1];} ?>">
                    <label for="time">Heure</label>  
                    <input type="time" name="time" value="<?php if(isset($id)){echo $data[2];} ?>">
                </div>
                <div class="nomEquipeAdverseForm">
                    <label for="nomEquipeAdverse">Nom de l'équipe adverse</label>
                    <input type="text" name="nomEquipeAdverse" placeholder="PSG" value="<?php if(isset($id)){echo $data[3];} ?>">
                </div>
                <div class="lieuForm">
                    <label for="lieu">Lieu du match</label>
                    <input type="text" name="lieu" placeholder="Paris" value="<?php if(isset($id)){echo  $data[4];} ?>">
                </div>
                <div class="buttonForm">
                    <input type="submit" value="Enregistrer le match" id="btn">
                </div>
        </form>	 
        <div id="head">
            <h1>Mon équipe</h1>
        </div> 
        <div id="head">
            <h1>Composer mon équipe</h1>
        </div>
        <div>
            <table id="tableCompo">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Poste</th>
                    </tr>
                </thead>
                <?PHP
                    ///Connexion au serveur MySQL
                    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
                    $res = $bdd->prepare("SELECT joueur.* FROM joueur");
                    $res->execute();
                    foreach ($res as $row){
                        echo"<tr><td>{$row['prenom']}</td><td>{$row['nom']}</td><td>{$row['poste_prefere']}</td><td><a href='profil.php?id={$row['numero_licence']}'><img src='../images/voir.svg' alt=''></a></td>\n";
                    }
                ?>
            </table>
            <div id="head">
                <h1>Tout les joueurs</h1>
            </div>
            <form id="recherche">
            <form method="GET" action="recherche.php" >
                <input type="search" name="search" placeholder="Rechercher ...">
                <input type="submit" value="Rechercher">
            </form>
            <table id="tablejoueurs">
                <thead>
                    <tr>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Poste</th>
                    </tr>
                </thead>
                <?PHP
                    ///Connexion au serveur MySQL
                    if(isset($keyword)){
                        $res = $bdd->prepare("SELECT joueur.* FROM joueur WHERE UPPER(concat(nom,prenom,poste_prefere,numero_licence)) LIKE UPPER('%$keyword%');");
                        $res->execute();
                    }else{
                        $res = $bdd->prepare("SELECT joueur.* FROM joueur");
                        $res->execute();
                        foreach ($res as $row){
                        echo"<tr><td>{$row['prenom']}</td><td>{$row['nom']}</td><td>{$row['poste_prefere']}</td><td><a href='joueurs.php?id={$row['numero_licence']}'><img src='../images/supp.svg' alt=''></a><a href='gestionProfil.php?id={$row['numero_licence']}'><img src='../images/modif.svg' alt=''></a><a href='profil.php?id={$row['numero_licence']}'><img src='../images/voir.svg' alt=''></a></td>\n";
                    }
                    }
                ?>
            </table>
        </div>
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