<?PHP
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
    if(isset($_GET['id'])){
        if(isset($_GET['add'])){
            if(strcmp($_GET['add'],"add") == 0){
                $add = $bdd->prepare("INSERT INTO joueur(nom, prenom,taille,poids,date_naissance,statut,poste_prefere)
                VALUES(:nom, :prenom, :taille, :poid, :dn, :statut, :poste)");
                ///Exécution de la requête
                $add->execute(array('nom' => $_GET['nom'],
                                        'prenom'=> $_GET['prenom'],
                                        'taille'=> $_GET['taille'],
                                        'poid'=> $_GET['poid'],
                                        'dn' => $_GET['date'],
                                        'statut' => $_GET['statut'],
                                        'poste' => $_GET['poste']
                                        ));
                $req = $bdd->prepare("SELECT * from joueur where nom = ?");
                $req->execute(array($_GET['nom']));
                $data = $req->fetch(PDO::FETCH_NUM);
                $id = "$data[0]";
                $poste ="$data[8]";
                $statu = "$data[7]";
            }
        }elseif(!isset($_GET['add'])){
            $id = $_GET['id'];
            $req = $bdd->prepare("SELECT * from joueur where numero_licence = ?");
            $req->execute(array($id));
            $data = $req->fetch(PDO::FETCH_NUM);
            $poste ="$data[8]";
            $statu = "$data[7]";
            if(isset($_GET['nom'])){
                $ajout = $bdd->prepare('UPDATE joueur SET nom = :nom,prenom = :prenom,taille=:taille,poids=:poid,date_naissance = :dn,statut = :statut,poste_prefere = :poste WHERE numero_licence = :id');
                $ajout->execute(array('nom' => $_GET['nom'],
                                    'prenom'=> $_GET['prenom'],
                                    'taille'=> $_GET['taille'],
                                    'poid'=> $_GET['poid'],
                                    'dn' => $_GET['date'],
                                    'statut' => $_GET['statut'],
                                    'poste' => $_GET['poste']
                                    ,'id' => $id));
                $req = $bdd->prepare("SELECT * from joueur where numero_licence = ?");
                $req->execute(array($id));
                $data = $req->fetch(PDO::FETCH_NUM);
                $poste ="$data[8]";
                $statu = "$data[7]";    
            }
        }  
    }
    if(isset($_POST['id'])){
        $id = $_POST['id']; 
    }
    $bdd = new PDO("mysql:host=localhost;dbname=id20110031_teamzydb", 'root', '');
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
<body id="Gprofil">
    <div id="contentContener">
        <h1>Profil</h1>
        <?php
            if(isset($id)){
                echo '<form action="GestionProfil.php" method="POST" enctype="multipart/form-data" id="pic">
                    <input type="hidden" name="id" value="'.$data[0].'">
                    <div>
                        <img src="../images/pp/'.$data[3].'" alt="">
                        <input name="avatar" type="file" accept="image/png, image/gif, image/jpeg"/>
                    </div>
                    <input type="submit" value="Enregistrer la nouvelle photo" class="btn">
                </form>';
            }
            
        ?>

        <form  method="GET" action="gestionProfil.php" id="info">
            <div class="form-elements">
                <input type="hidden" name="id" value="<?php if(isset($id)){echo  $data[0];}?>">
                <?php
                    if(!isset($id)){
                        echo '<input type="hidden" name="add" value="'."add".'">';
                    }
                ?>
                <label for="nom"> Nom :</label>
                <input type="text" name="nom" value="<?php if(isset($id)){echo  $data[1];} ?>">
                <label for="prenom"> Prénom :</label>
                <input type="text" name="prenom" value="<?php if(isset($id)){echo  $data[2];} ?>">
            </div>
            <div class="form-elements">
                <label for="date"> Date de naissance :</label>
                <input type="date" name="date" value="<?php if(isset($id)){echo $data[4];} ?>">
                <label for="taille"> Taille (cm) :</label>
                <input type="number" name="taille" min="0" max="250" value="<?php if(isset($id)){ echo  $data[5];} ?>">
            </div>
            <div class="form-elements">
                <label for="poid"> Poids (Kg):</label>
                <input type="number" name="poid" min="0" max="250" value="<?php if(isset($id)){echo  $data[6];}  ?>">
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
                    >--Choisissez un statut--</option>
                    <option value="Actif"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($statu,"Actif") == 0 ){
                                    echo "selected";
                                }
                            }
                        }   
                    ?>
                    >Actif</option>
                    <option value="Blessé"
                    <?php
                    if(isset($id)){
                        if(!strcmp($id,"add") == 0){
                            if(strcmp($statu,"Blessé") == 0 ){
                                echo "selected";
                            }
                        }
                    }   
                    ?>
                    >Blessé</option>
                    <option value="Suspendu"
                    <?php
                        if(isset($id)){
                            if(isset($id) || !strcmp($id,"add") == 0){
                                if(strcmp($statu,"Suspendu") == 0 ){
                                    echo "selected";
                                }
                            }
                        }    
                    ?>
                    >Suspendu</option>
                    <option value="Absent"
                    <?php
                        if(isset($id)){
                            if(isset($id) || !strcmp($id,"add") == 0){
                                if(strcmp($statu,"Absent") == 0 ){
                                    echo "selected";
                                }
                            }
                        }    
                    ?>
                    >Absent</option>
                </select>
                <label for="poste">Poste :</label>
                <select name="poste" >
                    <option value=""
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                echo "selected";
                            }
                        }
                    ?>
                    >--Choisissez un poste--</option>
                    <option value="défenseur"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"défenseur") == 0 ){
                                    echo "selected";
                                }
                            }
                        }    
                    ?>
                    >défenseur</option>
                    <option value="Milieu défensif"  
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"Milieu défensif") == 0 ){
                                    echo "selected";
                                }
                            }
                        }    
                    ?>
                    >Milieu défensif</option>
                    <option value="Milieu offensif"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"Milieu offensif") == 0 ){
                                    echo "selected";
                                }   
                            }
                        }    
                    ?>
                    >Milieu offensif</option>
                    <option value="Attaquant"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"Attaquant") == 0 ){
                                    echo "selected";
                                }    
                            }
                        }   
                    ?>
                    >Attaquant</option>
                    <option value="Gardien de but"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"Gardien de but") == 0 ){
                                    echo "selected";
                                }     
                        }
                        }    
                    ?>
                    >Gardien de but</option>
                </select> 
            </div>
            <input type="submit" class="btn" value="
            <?php
                if(isset($id)){
                    echo "Enregistrer les modifiactions";    
                }else{
                    echo "Valider la création";
                }
                        
            ?>
            " class="form-elements">
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