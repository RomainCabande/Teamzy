<?PHP
    $id = $_GET['id'];
    $bdd = new PDO("mysql:host=localhost;dbname=testprojet", 'root', '');
    $req = $bdd->prepare("SELECT * from joueur where numero_licence = ".$id);
    $req->execute();
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
    <a href="#" class="headerLink">Matchs</a>
    <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body id="profil">
    <div id="contentContener">
        <h1>Profil</h1>
        
        
        <form action="profil.php">
            <img src="../images/<?php echo $data[3] ?>" alt="">
           
            <input type="file" accept="image/png, image/gif, image/jpeg">
            
            <div class="form-elements">
                <label for="nom"> Nom :</label>
                <input type="text" name="nom" value="<?php echo $data[1] ?>">
                <label for="prenom"> Prénom :</label>
                <input type="text" name="prenom" value="<?php echo $data[2] ?>">
            </div>
            <div class="form-elements">
                <label for="date"> Date de naissance :</label>
                <input type="date" name="date" value="<?php echo $data[4] ?>">
                <label for="taille"> Taille (cm) :</label>
                <input type="number" name="taille" min="0" max="250" value="<?php echo $data[5] ?>">
            </div>
            <div class="form-elements">
                <label for="poid"> Poids (Kg):</label>
                <input type="number" name="poid" min="0" max="250" value="<?php echo $data[6] ?>">
            </div>
            <div class="form-elements">
                <label for="statut">Statut :</label>   
                <select name="statut">
                    <option value="">--Please choose an option--</option>
                    <option value="titu">Titulaire</option>
                    <option value="remp">Remplaçant</option>
                    <option value="reser">Reserviste</option>
                </select>
                <label for="poste">Poste :</label>
                <select name="poste">
                    <option value="">--Please choose an option--</option>
                    <option value="al">arrière latéral</option>
                    <option value="md">milieu défensif</option>
                    <option value="mo">milieu offensif</option>
                    <option value="at">attaquant</option>
                    <option value="gk">gardien de but</option>
                </select>
                
            </div>
            <input type="submit">
            <p class="form-elements">Note moyenne en match :</p>
        </form>   
            <p>commentaires :</p> 
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