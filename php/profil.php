<html lang="en" id="accueil">
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
    <a href="#" class="headerLink">Matchs</a>
    <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body id="profil">
    <div id="contentContener">
        <h1>Profil</h1>
        <p> Nom :
        <input type="search" name="nom">
            <br>
            Prénom :
            <input type="search" name="prenom">
            <br>
            Date de naissance :
            <br>
            taille :
            <br>
            poids :
            <br>
            Statut :
            <br>
            Poste :
            <input type="search" name="poste">
            <br>
            Note moyenne en match :
            <br>
            commentaires :
        </p>
        <img src="../images/joueur.png" alt="photo du joueur" id="ppjoueur"> 
        <table id="tableCommentaires">
            <tr>
                <th>Date</th>
                <th>Note</th>
                <th>commentaire</th>
            </tr>
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