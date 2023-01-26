<?php
    //DB connexion
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');

    //update match for id
    if(isset($_GET['date'])) {
        if(isset($_GET['time'])) { 
            if(isset($_GET['nomEquipeAdverse'])) {
                if(isset($_GET['lieu'])) {
                    $update = $bdd->prepare("UPDATE matchs SET date_match=:date_match, heure=:heure, nom_equipe_adverse=:nomEquipeAdverse, lieu=:lieu WHERE id_match = :id");
                    $update->execute(array('date_match' => $_GET['date'],
                                            'heure'=> $_GET['time'],
                                            'nomEquipeAdverse'=> $_GET['nomEquipeAdverse'],
                                            'lieu'=> $_GET['lieu'],
                                            'id' => $_GET['id']));
                }
            }
        }    
    }
    if(isset($_GET['player_id_supp'])){
        $req = $bdd->prepare("DELETE FROM `jouer` WHERE `jouer`.`numero_licence` = :numero_licence AND `jouer`.`id_match` = :id_match");
        $req->execute(array('numero_licence' => $_GET['player_id_supp'],
                            'id_match' => $_GET['id']
                            ));
    }
    //select matchs data for id
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = $bdd->prepare("SELECT * from matchs where id_match = ?");
        $req->execute(array($id));
        $data = $req->fetch(PDO::FETCH_NUM); 
    }

    //insert players into match team
    if(isset($_GET['id']) and isset($_GET['player_id'])) {
        $req = $bdd->prepare("INSERT INTO `jouer` (`numero_licence`, `id_match`) VALUES (:numero_licence, :id_match)");
        $req->execute(array('numero_licence' => $_GET['player_id'],
                            'id_match' => $_GET['id']
                            ));
    }
 
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
                    //players display
                    $res = $bdd->prepare("SELECT joueur.* FROM joueur, jouer WHERE joueur.numero_licence = jouer.numero_licence and jouer.id_match = ?");
                    $res->execute(array($_GET['id']));
                    foreach ($res as $row){
                        echo"<tr>
                                <td>{$row['prenom']}</td>
                                <td>{$row['nom']}</td>
                                <td>{$row['poste_prefere']}</td>
                                <td>
                                    <a href='profil.php?id={$row['numero_licence']}'><img src='../images/voir.svg' alt=''></a>
                                    <a href='modifierMatch.php?player_id_supp={$row['numero_licence']}&id={$_GET['id']}'><img src='../images/minus.svg' alt=''></a>
                                </td>\n";
                    }
                ?>
            </table>
        <div id="head">
            <h1>Tous les joueurs</h1>
        </div>
        <form id="recherche" method="GET" action="modifierMatch.php" >
            <input type="search" name="search" placeholder="Rechercher ...">
            <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
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
                    //players display with keyword filter
                    if(isset($_GET['search'])){
                        $keyword = $_GET['search'];
                        $res = $bdd->prepare("SELECT joueur.* FROM joueur WHERE UPPER(concat(nom,prenom,poste_prefere,numero_licence)) LIKE UPPER('%$keyword%');");
                        $res->execute();
                        foreach ($res as $row){
                            echo "  <tr> 
                                        <td>{$row['prenom']}</td>
                                        <td>{$row['nom']}</td>
                                        <td>{$row['poste_prefere']}</td>
                                        <td>
                                            <a href='profil.php?id={$row['numero_licence']}'><img src='../images/voir.svg' alt=''></a>
                                            <a href='modifierMatch.php?player_id={$row['numero_licence']}&id={$_GET['id']}'><img src='../images/add.png' alt=''></a>
                                        </td>
                                    <tr>\n";
                        }
                    //players display no keyword
                    }else{
                        $res = $bdd->prepare("SELECT DISTINCT joueur.* FROM Jouer,joueur Where joueur.numero_licence NOT IN (Select jouer.numero_licence FROM jouer WHERE jouer.id_match = ?);");
                        $res->execute(array($_GET['id']));
                        foreach ($res as $row){
                            echo "  <tr> 
                                        <td>{$row['prenom']}</td>
                                        <td>{$row['nom']}</td>
                                        <td>{$row['poste_prefere']}</td>
                                        <td>
                                            <a href='profil.php?id={$row['numero_licence']}'><img src='../images/voir.svg' alt=''></a>
                                            <a href='modifierMatch.php?player_id={$row['numero_licence']}&id={$_GET['id']}'><img src='../images/add.svg' alt=''></a>
                                        </td>
                                    <tr>\n";
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