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
    <a href="matchs.php" class="headerLink">Matchs</a>
    <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body id="pageModifMatch">
    <div id="contentContener">
        <div id="head">
            <h1>Nouveau Match</h1>
        </div>
            <form id="formModifMatch" method="get" action="matchs.php">
                <div class="dateTimeForm">
                    <label for="date">Date</label>  
                    <input type="date" name="date">
                    <label for="time">Heure</label>  
                    <input type="time" name="time">
                </div>
                <div class="nomEquipeAdverseForm">
                    <label for="nomEquipeAdverse">Nom de l'équipe adverse</label>
                    <input type="text" name="nomEquipeAdverse" placeholder="PSG">
                </div>
                <div class="lieuForm">
                    <label for="lieu">Lieu du match</label>
                    <input type="text" name="lieu" placeholder="Paris">
                </div>
                <div class="buttonForm">
                    <input type="submit" value="Enregistrer le match" id="btn">
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