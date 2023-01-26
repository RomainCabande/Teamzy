<?php
    $idJ = $_GET['idJ'];
    $idM = $_GET['idM'];
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
    $req = $bdd->prepare("SELECT jouer.titulaire, jouer.note_joueur,jouer.commentaire,joueur.*  FROM `joueur`,jouer WHERE jouer.numero_licence = joueur.numero_licence AND joueur.numero_licence = ? AND jouer.id_match = ?;");
    $req->execute(array($idJ,$idM));
    $data = $req->fetch(PDO::FETCH_NUM);
    if($data[0] == 1){
        $isRemplaçant = $data[0];
    }else if($data[0] == 0){
        $isRemplaçant = $data[0];
    }
    if($data[1] != 0){
        $note = $data[1];
    }
    
?>
<html lang="en" id="feuilleMatch">
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
        <h1>Feuille de match de <?PHP echo $data[4]." ".$data[5] ?></h1>
        <form action="VueMatch.php" method="GET">
            <div class="part">
                <input type="hidden" name="idJ" value="<?PHP echo $data[3] ?>">
                <input type="hidden" name="id" value="<?PHP echo $idM ?>">
                <div>
                   <label for="note">Note du match</label> 
                </div>
                <div class="rating">
                    <input type="radio" name="rating" value="1" id="1" 
                    <?php 
                    if(isset($note)){
                        if($note == 1){
                            echo " checked='checked' ";
                        }
                    } 
                    ?>
                    ><label for="1">☆</label>
                    <input type="radio" name="rating" value="2" id="2"
                    <?php 
                    if(isset($note)){
                        if($note == 2){
                            echo " checked='checked' ";
                        }
                    } 
                    ?>
                    ><label for="2">☆</label>
                    <input type="radio" name="rating" value="3" id="3"
                    <?php 
                    if(isset($note)){
                        if($note == 3){
                            echo " checked='checked' ";
                        }
                    } 
                    ?>
                    ><label for="3">☆</label>
                    <input type="radio" name="rating" value="4" id="4"
                    <?php 
                    if(isset($note)){
                        if($note == 4){
                            echo " checked='checked' ";
                        }
                    } 
                    ?>
                    ><label for="4">☆</label>
                    <input type="radio" name="rating" value="5" id="5"
                    <?php 
                    if(isset($note)){
                        if($note == 5){
                            echo " checked='checked' ";
                        }
                    } 
                    ?>
                    ><label for="5">☆</label>
                </div>
                <label for="statut">Statut :</label>
                <select name="statut">
                    <option value=""
                    <?php
                        if(!isset($isRemplaçant)){
                            echo "selected";
                        }
                    ?>
                    >--Choisissez un statut--</option>
                    <option value="1"
                    <?php
                        if(isset($isRemplaçant)){
                                if($isRemplaçant == 1 ){
                                    echo "selected";
                                }
                        }   
                    ?>
                    >Titulaire</option>
                    <option value="0"
                    <?php
                    if(isset($isRemplaçant)){
                        if($isRemplaçant == 0 ){
                            echo "selected";
                        }
                    }
                        
                        
                    ?>
                    >Remplaçant</option>
                </select>
            </div>
            <div class="part">
                <div>
                   <label for="com">Commentaire</label> 
                </div>
                
                <textarea name="com" rows="5" cols="33"  
                ><?php 
                    if(isset($data[2])){
                            echo $data[2];
                    } 
                ?>
                </textarea>
            </div>
            <div>
                <input type="submit" value="valider la feuille">
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