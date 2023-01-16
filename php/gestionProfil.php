<?PHP
    $bdd = new PDO("mysql:host=localhost;dbname=testprojet", 'root', '');
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $req = $bdd->prepare("SELECT * from joueur where numero_licence = ?");
        $req->execute(array($id));
        $data = $req->fetch(PDO::FETCH_NUM);
        $poste ="$data[8]";
        $statu = "$data[7]";
    }
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    echo isset($_FILES['avatar']);
    $bdd = new PDO("mysql:host=localhost;dbname=testprojet", 'root', '');
    if(isset($_FILES['avatar']))
    { 
        $dossier = '../images/pp/';
        $fichier = basename($_FILES['avatar']['name']);
        if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
            $ajout = $bdd->prepare('UPDATE joueur SET photo_link = :picname WHERE numero_licence = :id');
            $ajout->execute(array('picname' => $fichier,'id' => $id));
        }
        $req = $bdd->prepare("SELECT * from joueur where numero_licence = ?");
        $req->execute(array($id));
        $data = $req->fetch(PDO::FETCH_NUM);
        $poste ="$data[8]";
        $statu = "$data[7]";
    }
    if(isset($_POST['nom'])){
        $ajout = $bdd->prepare('UPDATE joueur SET nom = :nom,prenom = :prenom,taille=:taille,poids=:poid WHERE numero_licence = :id');
        echo $_GET['nom'].$_GET['prenom'].$_GET['taille'].$_GET['poid'].$id;
        $ajout->execute(array('nom' => $_GET['nom'],
                            'prenom'=> $_GET['prenom'],
                            'taille'=> $_GET['taille'],
                            'poid'=> $_GET['poid']
                            ,'id' => $id));
        $req = $bdd->prepare("SELECT * from joueur where numero_licence = ?");
        $req->execute(array($id));
        $data = $req->fetch(PDO::FETCH_NUM);
        $poste ="$data[8]";
        $statu = "$data[7]";
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
    <a href="#" class="headerLink">Matchs</a>
    <img src="../images/user-icon.png" alt="votre compte" id="iconUser">
</header>
<body id="profil">
    <div id="contentContener">
        <h1>Profil</h1>
        <form action="GestionProfil.php" method="POST" enctype="multipart/form-data" id="pic">
            <input type="hidden" name="id" value="<?php echo $data[0] ?>">
            <div>
                <img src="../images/pp/<?php echo  $data[3] ?>" alt="">
                <input name="avatar" type="file" accept="image/png, image/gif, image/jpeg"/>
            </div>
            <input type="submit" value="Enregistrer la nouvelle photo" class="btn">
        </form>

        
        <!-- The data encoding type, enctype, MUST be specified as below -->
        
        <form  method="GET" action="gestionProfil.php" id="info">
            <div class="form-elements">
            <input type="hidden" name="id" value="<?php echo  $data[0]?>">
                <label for="nom"> Nom :</label>
                <input type="text" name="nom" value="<?php echo $data[1] ?>">
                <label for="prenom"> Prénom :</label>
                <input type="text" name="prenom" value="<?php echo  $data[2] ?>">
            </div>
            <div class="form-elements">
                <label for="date"> Date de naissance :</label>
                <input type="date" name="date" value="<?php echo  $data[4] ?>">
                <label for="taille"> Taille (cm) :</label>
                <input type="number" name="taille" min="0" max="250" value="<?php echo  $data[5] ?>">
            </div>
            <div class="form-elements">
                <label for="poid"> Poids (Kg):</label>
                <input type="number" name="poid" min="0" max="250" value="<?php echo  $data[6]  ?>">
            </div>
            <div class="form-elements">
                <label for="statut">Statut :</label>   
                <select name="statut">
                    <option value=""
                    <?php
                        if(!isset($_GET['id'])){
                            echo "selected";
                        }
                    ?>
                    >--Please choose an option--</option>
                    <option value="titu"
                    <?php
                        if(strcmp($statu,"Titulaire") == 0 ){
                            echo "selected";
                        }
                    ?>
                    >Titulaire</option>
                    <option value="remp"
                    <?php
                        if(strcmp($statu,"Remplaçant") == 0 ){
                            echo "selected";
                        }
                    ?>
                    >Remplaçant</option>
                    <option value="reser"
                    <?php
                        if(strcmp($statu,"Reserviste") == 0 ){
                            echo "selected";
                        }
                    ?>
                    >Reserviste</option>
                </select>
                <label for="poste">Poste :</label>
                <select name="poste" >
                    <option value=""
                    <?php
                        if(!isset($_GET['id'])){
                            echo "selected";
                        }
                    ?>
                    >--Please choose an option--</option>
                    <option value="al"
                    <?php
                        if(strcmp($poste,"arrière latéral") == 0 ){
                            echo "selected";
                        }
                    ?>
                    >arrière latéral</option>
                    <option value="md"  
                    <?php
                        if(strcmp($poste,"milieu défensif") == 0 ){
                            echo "selected";
                        }
                    ?>
                        >milieu défensif</option>
                    <option value="mo"
                    <?php
                        if(strcmp($poste,"milieu offensif") == 0 ){
                            echo "selected";
                        }
                    ?>
                    >milieu offensif</option>
                    <option value="at"
                    <?php
                        if(strcmp($poste,"attaquant") == 0 ){
                            echo "selected";
                        }
                    ?>
                    >attaquant</option>
                    <option value="gk"
                    <?php
                        if(strcmp($poste,"gardien de but") == 0 ){
                            echo "selected";
                        }
                    ?>
                    >gardien de but</option>
                </select> 
            </div>
            <input type="submit" class="btn" value="Enregistrer les modifiactions" class="form-elements">
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