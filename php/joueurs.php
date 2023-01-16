<html lang="en" id="accueil">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='../css/styles.css' rel='stylesheet' type='text/css'>
    <title>Teamzy-Joueurs</title>
    <link rel="icon" href="../images/logo_teamzy.png">
</head>
<header>
    <a href="accueil.php" id="lg"><img src="../images/logo_teamzy+text.png" alt="logo haut de page"></a>
    <a href="joueurs.php" class="headerLink">Joueurs</a>
    <a href="#" class="headerLink">Matchs</a>
    <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body id="pageJoueur">
    <div id="contentContener">
        <div id="head">
            <h1>Joueurs</h1>
            <a id="btnAdd" href="../php/gestionProfil.php">Ajouter un joueur</a>
        </div>
        
        <form id="recherche">
            <form method="post" action="recherche.php" >
                <input type="search" name="search" placeholder="Rechercher ...">
                <input type="submit" value="Rechercher">
        </form>	
        <table id="tablejoueur">
            <thead>
                <tr>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Poste</th>
                </tr>
            </thead>
            <?PHP
                ///Connexion au serveur MySQL
                $bdd = new PDO("mysql:host=localhost;dbname=testprojet", 'root', '');
                if(isset($_POST['search'])){
                    
                    $keyword = $_POST['search'];
                    /* 
                    $res = $bdd->prepare("SELECT * FROM contact ");
                    $res->execute();
                    
                    $data = $res->fetchAll();
                    print_r($data);
                    */
                    
                    $res = $bdd->prepare("SELECT j.* FROM joueur as j WHERE concat(nom,prenom,poste_prefere,numero_licence) LIKE '?'");
                    $res->execute(array($keyword));
                }else{
                    $res = $bdd->prepare("SELECT joueur.* FROM joueur");
                    $res->execute();
                    foreach ($res as $row){
                    echo"<tr><td>{$row['prenom']}</td><td>{$row['nom']}</td><td>{$row['poste_prefere']}</td><td><a href='gestionProfil.php?id={$row['numero_licence']}'><img src='../images/modif.svg' alt=''></a></td>\n";
                }
                }

                // while ($row = $res->fetch()) {
                //     echo"<tr><td>{$row['nom']}</td><td>{$row['prenom']}</td><td>{$row['adresse']}
                //     </td><td>{$row['codepostal']}</td><td>{$row['ville']}</td><td>{$row['telephone']}</td>\n";
                // }
                foreach ($res as $row){
                    echo"<tr><td>{$row['prenom']}</td><td>{$row['nom']}</td><td>{$row['poste_prefere']}</td><td><a href='gestionProfil.php?id={$row['numero_licence']}'><img src='../images/modif.svg' alt=''></a></td>\n";
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