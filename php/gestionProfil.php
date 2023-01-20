<?PHP
    $bdd = new PDO("mysql:host=localhost;dbname= id20110031_teamzydb", 'root', '');
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
        

        
        <!-- The data encoding type, enctype, MUST be specified as below -->

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
                    >--Please choose an option--</option>
                    <option value="Titulaire"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($statu,"Titulaire") == 0 ){
                                    echo "selected";
                                }
                            }
                        }   
                    ?>
                    >Titulaire</option>
                    <option value="Remplaçant"
                    <?php
                    if(isset($id)){
                        if(!strcmp($id,"add") == 0){
                            if(strcmp($statu,"Remplaçant") == 0 ){
                                echo "selected";
                            }
                        }
                    }
                        
                        
                    ?>
                    >Remplaçant</option>
                    <option value="Reserviste"
                    <?php
                        if(isset($id)){
                            if(isset($id) || !strcmp($id,"add") == 0){
                                if(strcmp($statu,"Reserviste") == 0 ){
                                    echo "selected";
                                }
                            }
                        }    
                    ?>
                    >Reserviste</option>
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
                    >--Please choose an option--</option>
                    <option value="arrière latéral"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"arrière latéral") == 0 ){
                                    echo "selected";
                                }
                            }
                        }    
                    ?>
                    >arrière latéral</option>
                    <option value="milieu défensif"  
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"milieu défensif") == 0 ){
                                    echo "selected";
                                }
                            }
                        }    
                    ?>
                        >milieu défensif</option>
                    <option value="milieu offensif"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"milieu offensif") == 0 ){
                                    echo "selected";
                                }   
                            }
                        }    
                    ?>
                    >milieu offensif</option>
                    <option value="attaquant"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"attaquant") == 0 ){
                                    echo "selected";
                                }    
                            }
                        }   
                    ?>
                    >attaquant</option>
                    <option value="gardien de but"
                    <?php
                        if(isset($id)){
                            if(!strcmp($id,"add") == 0){
                                if(strcmp($poste,"gardien de but") == 0 ){
                                    echo "selected";
                                }     
                        }
                        }    
                    ?>
                    >gardien de but</option>
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