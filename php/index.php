<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=$, initial-scale=1.0">
    <title>AFCI</title>
    <style>
        .navbar ul{display: flex;
            height: 5vh;
            width: 100vw;
            text-decoration: none;
            background-color: #0C2D57;
            list-style: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            justify-content: flex-end;
            
        }

        li {
            float: left;
            margin-left: 4vh;
            color: white;
           
        }
        body {
            font-family: Arial, sans-serif;
        }

        table {
            margin: 20px auto; 
    border-collapse: collapse;
    width: 100%; 
   table-layout: fixed; 
     overflow: auto; 
        
        }

        th, td {
            /* border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis; */
            
    border: 1px solid #ddd;
    padding: 8px;
    word-wrap: break-word; /* Ajouter cette propriété pour forcer le contenu à se rompre sur une nouvelle ligne lorsque la largeur de la cellule est atteinte */

       
        }

        th {
            background-color: #f2f2f2;
        }

      
        form {
            display: inline-block;
            margin-right: 5px;
        }

        button {
            background-color: red;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
       
    </style>
</head>
<body>
<?php
$host = "mysql"; // Remplacez par l'hôte de votre base de données
$port = "3306";
$dbname = "afci"; // Remplacez par le nom de votre base de données
$user = "admin"; // Remplacez par votre nom d'utilisateur
$pass = "admin"; // Remplacez par votre mot de passe


    // Création d'une nouvelle instance de la classe PDO
    $bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);

    // Configuration des options PDO
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    ?>
<header>
    <nav class="navbar">
        <ul>
           <a href="?page=roles"> <li>Rôles</li></a>
           <a href="?page=centres"> <li>Centres</li></a>
           <a href="?page=formations">  <li>Formations</li></a>
           <a href="?page=pedagogie">  <li>Pédagogie</li></a>
           <a href="?page=affecter">  <li>Affecter</li></a>
           <a href="?page=sessions">  <li>Sessions</li></a>
           <a href="?page=apprenants">  <li>Apprenants</li></a>
        </ul>
    </nav>
</header>

<?php


    // echo "Connexion réussie !";

    // Lire des données dans la BDD

    // $sql = "SELECT * FROM apprenants";
    // $requete = $bdd->query($sql);
    // $results = $requete->fetchAll(PDO::FETCH_ASSOC);
    

    // foreach( $results as $value ){
    //     foreach($value as $data){
    //         echo $data;
    //         echo "<br>";

    //     }
    //     echo "<br>";
    // }

    // foreach( $results as $value ){
    //     echo "<h2>" . $value["nom_apprenant"] . "</h2>";
    //     echo "<br>";
    // }


    // Insérer des données dans la BDD

    // PAGE ROLES


    if(isset($_GET["page"])&& $_GET["page"]=="roles"){
        $sqlrole = "SELECT * FROM role";
        $requeterole = $bdd->query($sqlrole);
        $resultatsrole = $requeterole->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <br>
        <form method="POST">
        <label>Rôle</label>
        <input type="text" name="nomRole">
        <input type="submit" name="submitRole">
    
    </form>
    <br>
    <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom du Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultatsrole as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_role'] . '</td>';
                            echo '<td>' . $value['nom_role'] . '</td>';
                            echo '<td><a href="?page=roles&action=edit&id=' . $value['id_role'] . '">Modifier</a></td>';
                            // echo '</tr>';
                            echo '<td>
                            <form method="POST" action="?page=role&type=supprimer">
                                <input type="hidden" name="id_role" value="' . $value['id_role'] . '">
                                <button type="submit">Supprimer</button>
                            </form>
                          </td>';
                    echo '</tr>';
                }
                        ?>
                    </tbody>
                </table>
                
                <!-- MODIFIER -->
                <?php
if(isset($_GET["page"]) && $_GET["page"] == "roles") {
    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
        // Récupérer l'ID du rôle à modifier
        $idRoleToEdit = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        // Récupérer les informations du rôle à modifier depuis la base de données
        $sqlEditRole = "SELECT * FROM role WHERE id_role = :idRole";
        $stmtEditRole = $bdd->prepare($sqlEditRole);
        $stmtEditRole->bindParam(':idRole', $idRoleToEdit, PDO::PARAM_INT);
        $stmtEditRole->execute();
        $roleToEdit = $stmtEditRole->fetch(PDO::FETCH_ASSOC);

        // Afficher le formulaire de modification
        if ($roleToEdit) {
            ?>
            <form method="POST">
                <input type="hidden" name="idRoleToEdit" value="<?php echo $roleToEdit['id_role']; ?>">
                <label>Nouveau nom du rôle</label>
                <input type="text" name="newNomRole" value="<?php echo $roleToEdit['nom_role']; ?>">
                <input type="submit" name="submitEditRole" value="Enregistrer">
            </form>
            <?php
        }
    }
}
?>

    <?php 
    }
  
if(isset($_POST['submitEditRole'])) {
    $idRoleToEdit = $_POST['idRoleToEdit'];
    $newNomRole = $_POST['newNomRole'];

    // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

    $sqlUpdateRole = "UPDATE role SET nom_role = :newNomRole WHERE id_role = :idRoleToEdit";
    $stmtUpdateRole = $bdd->prepare($sqlUpdateRole);
    $stmtUpdateRole->bindParam(':idRoleToEdit', $idRoleToEdit, PDO::PARAM_INT);
    $stmtUpdateRole->bindParam(':newNomRole', $newNomRole, PDO::PARAM_STR);
    $stmtUpdateRole->execute();

    echo "Rôle mis à jour avec succès.";
}
?>




<?php 
    if (isset($_POST['submitRole'])){
        $nomRole = $_POST['nomRole'];

        $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
        $bdd->query($sql);

        echo "data ajoutée dans la bdd";

    }

?>
<!-- SUPPRIMER -->
<?php 
if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
    if (isset($_POST["id_role"])) {
        $deleteIdRole = $_POST["id_role"];
        $sqlDelete = "DELETE FROM `role` WHERE id_role = $deleteIdRole";

        $bdd->query($sqlDelete);
        echo "Données supprimées";
    }
}
    ?>
<?php 
// PAGE CENTRES
    if(isset($_GET["page"])&& $_GET["page"]=="centres"){
        $sqlcentre = "SELECT * FROM centres";
        $requetecentre = $bdd->query($sqlcentre);
        $resultatscentre = $requetecentre->fetchAll(PDO::FETCH_ASSOC);
        ?> 

        <br>
        <form method="POST">
         <h1>Ajout Centre</h1>
        <label>Ville</label>
        <input type="text" name="villeCentre" >
        <label>Adresse</label>
        <input type="text" name="adresseCentre">
        <label>Code Postal</label>
        <input type="text" name="cpCentre">
        <input type="submit" name="submitCentre">
    </form>
    <br>
    <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ville</th>
                            <th>Adresse</th>
                            <th>Code Postal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultatscentre as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_centre'] . '</td>';
                            echo '<td>' . $value['ville_centre'] . '</td>';
                            echo '<td>' . $value['adresse_centre'] . '</td>';
                            echo '<td>' . $value['code_postal_centre'] . '</td>';
                            echo '<td><a href="?page=centres&action=edit&id=' . $value['id_centre'] . '">Modifier</a></td>';
                            echo '<td>
                            <form method="POST" action="?page=centres&type=supprimer">
                                <input type="hidden" name="id_centre" value="' . $value['id_centre'] . '">
                                <button type="submit">Supprimer</button>
                            </form>
                          </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>

    <?php 
        }
    ?>
<?php 
    if(isset($_POST['submitCentre'])) {
        $villeCentre = $_POST['villeCentre'];
        $adresseCentre = $_POST['adresseCentre'];
        $cpCentre = $_POST['cpCentre'];

        // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

        $sqlcentre = "INSERT INTO `centres`(`ville_centre`, `adresse_centre`, `code_postal_centre`) VALUES (:villeCentre, :adresseCentre, :cpCentre)";

        $stmt = $bdd->prepare($sqlcentre);
        $stmt->bindParam(':villeCentre', $villeCentre);
        $stmt->bindParam(':adresseCentre', $adresseCentre);
        $stmt->bindParam(':cpCentre', $cpCentre);
    
        if($stmt->execute()) {
            echo "Données ajoutées dans la base de données";
        } else {
            echo "Erreur lors de l'insertion des données";
        }
    }
    
?>
<?php
if(isset($_GET["page"]) && $_GET["page"] == "centres") {
    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
        // Récupérer l'ID du rôle à modifier
        $idCentreToEdit = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        // Récupérer les informations du rôle à modifier depuis la base de données
        $sqlEditCentre = "SELECT * FROM centres WHERE id_centre = :idCentre";
        $stmtEditCentre= $bdd->prepare($sqlEditCentre);
        $stmtEditCentre->bindParam(':idCentre', $idCentreToEdit, PDO::PARAM_INT);
        $stmtEditCentre->execute();
        $centreToEdit = $stmtEditCentre->fetch(PDO::FETCH_ASSOC);

        // Afficher le formulaire de modification
        if ($centreToEdit) {
            ?>
            <form method="POST">
                <input type="hidden" name="idCentreToEdit" value="<?php echo $centreToEdit['id_centre']; ?>">
                <label>Nouveau nom du Centre</label>
                <input type="text" name="newNomCentre" value="<?php echo $centreToEdit['ville_centre']; ?>">
                <input type="text" name="newAdresseCentre" value="<?php echo $centreToEdit['adresse_centre']; ?>">
                <input type="text" name="newCpCentre" value="<?php echo$centreToEdit['code_postal_centre']; ?>">
                <input type="submit" name="submitEditCentre" value="Enregistrer">
            </form>
            <?php
        }
    }
}
?>
<?php
if(isset($_POST['submitEditCentre'])) {
    $idCentreToEdit = $_POST['idCentreToEdit'];
    $newNomCentre = $_POST['newNomCentre'];
    $newAdresseCentre = $_POST['newAdresseCentre'];
    $newCpCentre = $_POST['newCpCentre'];

    // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

    $sqlUpdateCentre= "UPDATE centres SET ville_centre = :newNomCentre, adresse_centre = :newAdresseCentre, code_postal_centre = :newCpCentre WHERE id_centre = :idCentreToEdit";
    $stmtUpdateCentre = $bdd->prepare($sqlUpdateCentre);
    $stmtUpdateCentre->bindParam(':idCentreToEdit', $idCentreToEdit, PDO::PARAM_INT);
    $stmtUpdateCentre->bindParam(':newNomCentre', $newNomCentre, PDO::PARAM_STR);
    $stmtUpdateCentre->bindParam(':newAdresseCentre', $newAdresseCentre, PDO::PARAM_STR);
    $stmtUpdateCentre->bindParam(':newCpCentre',$newCpCentre, PDO::PARAM_STR);
    $stmtUpdateCentre->execute();

    echo "Centre mis à jour avec succès.";
}
?>

<!-- SUPPRIMER -->
<?php 
if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
    if (isset($_POST["id_centre"])) {
        $deleteIdcentre = $_POST["id_centre"];
        $sqlDelete = "DELETE FROM `centres` WHERE id_centre = $deleteIdcentre";

        $bdd->query($sqlDelete);
        echo "Données supprimées";
    }
}
?>
<?php 
// PAGE FORMATIONS
    if(isset($_GET["page"])&& $_GET["page"]=="formations"){
        $sqlformation= "SELECT * FROM formations";
        $requeteformation = $bdd->query($sqlformation);
        $resultatsformation = $requeteformation->fetchAll(PDO::FETCH_ASSOC);
        ?> 


        <form method="POST">
        <h1>Ajout Formation</h1>
        <label>Nom</label>
        <input type="text" name="nomFormation">
        <label>Durée</label>
        <input type="text" name="dureeFormation">
        <label>Niveau sortie Formation</label>
        <input type="text" name="niveauFormation">
        <label>Description</label>
        <input type="text" name="descriptionFormation">
        <input type="submit" name="submitFormation">
    
    </form>
    <br>
    <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Durée</th>
                            <th>Niveau Sortie formation</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultatsformation as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_formation'] . '</td>';
                            echo '<td>' . $value['nom_formation'] . '</td>';
                            echo '<td>' . $value['duree_formation'] . '</td>';
                            echo '<td>' . $value['niveau_sortie_formation'] . '</td>';
                            echo '<td>' . $value['description'] . '</td>';
                            echo '<td><a href="?page=formations&action=edit&id=' . $value['id_formation'] . '">Modifier</a></td>';
                            echo '<td>
                            <form method="POST" action="?page=formations&type=supprimer">
                                <input type="hidden" name="id_formation" value="' . $value['id_formation'] . '">
                                <button type="submit">Supprimer</button>
                            </form>
                          </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
    <?php 
    }
    if(isset($_POST['submitFormation'])) {
        $nomFormation = $_POST['nomFormation'];
        $dureeFormation = $_POST['dureeFormation'];
        $niveauFormation = $_POST['niveauFormation'];
        $descriptionFormation = $_POST['descriptionFormation'];

        // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

        $sql = "INSERT INTO `formations`(`nom_formation`, `duree_formation`, `niveau_sortie_formation`, `description`) VALUES ('$nomFormation','$dureeFormation','$niveauFormation','$descriptionFormation')";
        $bdd->query($sql);

        echo "Données ajoutées dans la base de données";
    }
    
    
?>
                <?php
if(isset($_GET["page"]) && $_GET["page"] == "formations") {
    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
        // Récupérer l'ID du rôle à modifier
        $idFormationToEdit = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        // Récupérer les informations du rôle à modifier depuis la base de données
        $sqlEditFormation = "SELECT * FROM formations WHERE id_formation = :idFormation";

        $sqlEditFormation= $bdd->prepare($sqlEditFormation);
        $sqlEditFormation->bindParam(':idFormation', $idFormationToEdit, PDO::PARAM_INT);
        $sqlEditFormation->execute();
        $formationToEdit = $sqlEditFormation->fetch(PDO::FETCH_ASSOC);

        // Afficher le formulaire de modification
        if ($formationToEdit) {
            ?>
            <form method="POST">
                <input type="hidden" name="idFormationToEdit" value="<?php echo $formationToEdit['id_formation']; ?>">
                <label>Nouveau nom de la Formation</label>
                <input type="text" name="newNomFormation" value="<?php echo $formationToEdit['nom_formation']; ?>">
                <input type="text" name="newDureeFormation" value="<?php echo $formationToEdit['duree_formation']; ?>">
                <input type="text" name="newNiveauFormation" value="<?php echo $formationToEdit['niveau_sortie_formation']; ?>">
                <input type="text" name="newDescriptionFormation" value="<?php echo $formationToEdit['description']; ?>">
                <input type="submit" name="submitEditFormation" value="Enregistrer">
            </form>
            <?php
        }
    }
}
?>

    <?php 
  
  
if(isset($_POST['submitEditFormation'])) {
    $idFormationToEdit = $_POST['idFormationToEdit'];
    $newNomFormation = $_POST['newNomFormation'];
    $newDureeFormation = $_POST['newDureeFormation'];
    $newNiveauFormation = $_POST['newNiveauFormation'];
    $newDescriptionFormation = $_POST['newDescriptionFormation'];

    // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

    $sqlUpdateFormation= "UPDATE formations SET nom_formation = :newNomFormation, duree_formation = :newDureeFormation, niveau_sortie_formation = :newNiveauFormation, description = :newDescriptionFormation  WHERE id_formation = :idFormationToEdit";
    $sqlUpdateFormation = $bdd->prepare($sqlUpdateFormation);
    $sqlUpdateFormation->bindParam(':idFormationToEdit', $idFormationToEdit, PDO::PARAM_INT);
    $sqlUpdateFormation->bindParam(':newNomFormation', $newNomFormation, PDO::PARAM_STR);
    $sqlUpdateFormation->bindParam(':newDureeFormation', $newDureeFormation, PDO::PARAM_STR);
    $sqlUpdateFormation->bindParam(':newNiveauFormation', $newNiveauFormation, PDO::PARAM_STR);
    $sqlUpdateFormation->bindParam(':newDescriptionFormation', $newDescriptionFormation, PDO::PARAM_STR);
    $sqlUpdateFormation->execute();

    echo "Formation mis à jour avec succès.";
}
?>

<!-- SUPPRIMER -->
<?php 
if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
    if (isset($_POST["id_formation"])) {
        $deleteIdFormation = $_POST["id_formation"];
        $sqlDeleteFormation = "DELETE FROM `formations` WHERE id_formation = $deleteIdFormation";

        $bdd->query($sqlDeleteFormation);
        echo "Données supprimées";
    }
}
?>


<?php 
// PAGE PEDAGOGIE
    if(isset($_GET["page"])&& $_GET["page"]=="pedagogie"){
        $sqlpedagogie = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `pedagogie`.`id_role`, `nom_role`
        FROM `pedagogie`
        JOIN `role` ON `pedagogie`.`id_role` = `role`.`id_role`;
        ";
        $requetepedagogie = $bdd->query($sqlpedagogie);
        $resultspedagogie = $requetepedagogie->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM role";
        $requete = $bdd->query($sql);
        $results = $requete->fetchAll(PDO::FETCH_ASSOC);

    

        ?> <form method="POST">
        <h1>Ajout Pédagogie</h1>
        <label>Nom</label>
        <input type="text" name="nomPedagogie">
        <label>Prénom</label>
        <input type="text" name="prenomPedagogie">
        <label>Mail</label>
        <input type="text" name="mailPedagogie">
        <label>Numéro</label>
        <input type="text" name="numPedagogie">
        <label>Rôle</label>
        <select name="idPedagogie" id="">
                <!-- <option value="idrole">id - nom role</option> -->
                <?php 
                
                foreach( $results as $value ){             
                        echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                }
                ?>
            </select>
        <input type="submit" name="submitPeda">
    
    </form>
    <br>
    <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Mail</th>
                            <th>Numéro</th>
                            <th>Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultspedagogie as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_pedagogie'] . '</td>';
                            echo '<td>' . $value['nom_pedagogie'] . '</td>';
                            echo '<td>' . $value['prenom_pedagogie'] . '</td>';
                            echo '<td>' . $value['mail_pedagogie'] . '</td>';
                            echo '<td>' . $value['num_pedagogie'] . '</td>';
                            echo '<td>' . $value['id_role'] . ' - ' . $value['nom_role'] . '</td>';
                            echo '<td><a href="?page=pedagogie&action=edit&id=' . $value['id_pedagogie'] . '">Modifier</a></td>';
                            echo '<td>
                            <form method="POST" action="?page=pedagogie&type=supprimer">
                                <input type="hidden" name="id_pedagogie" value="' . $value['id_pedagogie'] . '">
                                <button type="submit">Supprimer</button>
                            </form>
                          </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
    <?php 
    }
?>
<?php 
    if(isset($_POST['submitPeda'])) {
        $nomPedagogie = $_POST['nomPedagogie'];
        $prenomPedagogie = $_POST['prenomPedagogie'];
        $mailPedagogie = $_POST['mailPedagogie'];
        $numPedagogie = $_POST['numPedagogie'];
        $idPedagogie = $_POST['idPedagogie'];

        // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

        $sql = "INSERT INTO `pedagogie`( `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `id_role`) VALUES ('$nomPedagogie','$prenomPedagogie','$mailPedagogie','$numPedagogie','$idPedagogie')";
        $bdd->query($sql);

        echo "Données ajoutées dans la base de données";
    }

?>
 <?php
if(isset($_GET["page"]) && $_GET["page"] == "pedagogie") {
    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
        // Récupérer l'ID du rôle à modifier
        $idPedagogieToEdit = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        // Récupérer les informations du rôle à modifier depuis la base de données
        $sqlEditPedagogie = "SELECT * FROM pedagogie WHERE id_Pedagogie = :idPedagogie";
        $sqlEditPedagogie= $bdd->prepare($sqlEditPedagogie);
        $sqlEditPedagogie->bindParam(':idPedagogie', $idPedagogieToEdit, PDO::PARAM_INT);
        $sqlEditPedagogie->execute();
        $pedagogieToEdit = $sqlEditPedagogie->fetch(PDO::FETCH_ASSOC);

        // Afficher le formulaire de modification
        if ($pedagogieToEdit) {
            ?>
            <form method="POST">
                <input type="hidden" name="idPedagogieToEdit" value="<?php echo $formationToEdit['id_formation']; ?>">
                <label>Nouveau</label>
                <input type="text" name="newNomPedagogie" value="<?php echo $pedagogieToEdit['nom_pedagogie']; ?>">
                <input type="text" name="newPrenomPedagogie" value="<?php echo $pedagogieToEdit['prenom_pedagogie']; ?>">
                <input type="text" name="newMailPedagogie" value="<?php echo $pedagogieToEdit['mail_pedagogie']; ?>">
                <input type="text" name="newNumPedagogie" value="<?php echo $pedagogieToEdit['num_pedagogie']; ?>">
                <input type="submit" name="submitEditPedagogie" value="Enregistrer">
            </form>
            <?php
        }
    }
}
?>

    <?php 

  
if(isset($_POST['submitEditPedagogie'])) {
    $idFormationToEdit = $_POST['idPedagogieToEdit'];
    $newNomPedagogie = $_POST['newNomPedagogie'];
    $newPrenomPedagogie = $_POST['newPrenomPedagogie'];
    $newMailPedagogie = $_POST['newMailPedagogie'];
    $newNumPedagogie = $_POST['newNumPedagogie'];

    // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

    $sqlUpdatePedagogie= "UPDATE pedagogie SET nom_pedagogie = :newNomPedagogie, prenom_pedagogie = :newPrenomPedagogie, mail_pedagogie = :newMailPedagogie,  num_pedagogie = :newNumPedagogie WHERE id_pedagogie = :idPedagogieToEdit";
    $sqlUpdatePedagogie = $bdd->prepare($sqlUpdatePedagogie); 
    $sqlUpdatePedagogie->bindParam(':idPedagogieToEdit', $idPedagogieToEdit, PDO::PARAM_INT);
    $sqlUpdatePedagogie->bindParam(':newNomPedagogie', $newNomPedagogie, PDO::PARAM_STR);
    $sqlUpdatePedagogie->bindParam(':newPrenomPedagogie', $newPrenomPedagogie, PDO::PARAM_STR);
    $sqlUpdatePedagogie->bindParam(':newMailPedagogie', $newMailPedagogie, PDO::PARAM_STR);
    $sqlUpdatePedagogie->bindParam(':newNumPedagogie', $newNumPedagogie, PDO::PARAM_STR);
    $sqlUpdatePedagogie->execute();

    echo "Pédagogie mis à jour avec succès.";
}
?>
<!-- SUPPRIMER -->
<?php 
if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
    if (isset($_POST["id_pedagogie"])) {
        $deleteIdPedagogie = $_POST["id_pedagogie"];
        $sqlDeletePedagogie = "DELETE FROM `pedagogie` WHERE id_pedagogie = $deleteIdPedagogie";

        $bdd->query($sqlDeletePedagogie);
        echo "Données supprimées";
    }
}
?>

<?php 
// PAGE SESSIONS
    if(isset($_GET["page"])&& $_GET["page"]=="sessions"){
        $sqlsession = "SELECT
        `session`.`id_session`,
        `session`.`nom_session`,
        `session`.`date_debut`,
        `session`.`id_pedagogie`,
        `pedagogie`.`nom_pedagogie`,
        `pedagogie`.`prenom_pedagogie`,
        `session`.`id_formation`,
        `formations`.`nom_formation`,
        `session`.`id_centre`,
        `centres`.`ville_centre`
    FROM
        `session`
    LEFT JOIN
        `formations` ON `session`.`id_formation` = `formations`.`id_formation`
    LEFT JOIN
        `pedagogie` ON `session`.`id_pedagogie` = `pedagogie`.`id_pedagogie`
    LEFT JOIN
        `centres` ON `session`.`id_centre` = `centres`.`id_centre`;";
        $requetesession = $bdd->query($sqlsession);
        $resultssession = $requetesession->fetchAll(PDO::FETCH_ASSOC);

        $sqlpedagogie = "SELECT * FROM pedagogie";
        $requetepegagogie = $bdd->query($sqlpedagogie); 
        $resultspedagogie = $requetepegagogie->fetchAll(PDO::FETCH_ASSOC); 
       
        $sqlformation = "SELECT * FROM formations";
        $requeteformation = $bdd->query($sqlformation);
        $resultsformation = $requeteformation->fetchAll(PDO::FETCH_ASSOC);

        $sqlcentre = "SELECT * FROM centres";
        $requetecentre = $bdd->query($sqlcentre);
        $resultscentre = $requetecentre->fetchAll(PDO::FETCH_ASSOC);

        ?> <form method="POST">
        <h1> Ajout sessions</h1>
        <label>Nom Session</label>
        <input type="text" name="nomSession" >
        <label>Date Début</label>
        <input type="text" name="dateDebut" >
        <label>Pédagogie</label>
        
        <select name="idPedagogie" id="">
                <!-- <option value="idrole">id - nom role</option> -->
                <?php 
                
                foreach( $resultspedagogie as $value ){             
                        echo '<option value="' . $value['id_pedagogie'] .  '">' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] .  $value['prenom_pedagogie']. '</option>';   
                }
                ?>
            </select>
        <label>Formation</label>
   
        <select name="idFormation" id="">
                <!-- <option value="idrole">id - nom role</option> -->
                <?php 
                
                foreach( $resultsformation as $value ){             
                        echo '<option value="' . $value['id_formation'] .  '">' . $value['id_formation'] . ' - ' . $value['nom_formation'] . '</option>';   
                }
                ?>
            </select>

            <label>Centre</label>
   
        <select name="idCentre" id="">
                <!-- <option value="idrole">id - nom role</option> -->
                <?php 
                
                foreach( $resultscentre as $value ){             
                        echo '<option value="' . $value['id_centre'] .  '">' . $value['id_centre'] . ' - ' . $value['nom_centre'] . '</option>';   
                }
                ?>
            </select>
        <input type="submit" name="submitSession">
    
    </form>

    <br>
    <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Date Début</th>
                            <th>Pédagogie</th>
                            <th>Formation</th>
                            <th>Centre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultssession as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_session'] . '</td>';
                            echo '<td>' . $value['nom_session'] . '</td>';
                            echo '<td>' . $value['date_debut'] . '</td>';
                            echo '<td>' . $value['id_pedagogie'] . ' - ' . $value['nom_pedagogie'] .  ' - ' . $value['prenom_pedagogie'] .'</td>';
                            echo '<td>' . $value['id_formation'] .  ' - ' . $value['nom_formation'] . '</td>';
                            echo '<td>' . $value['id_centre'] .  ' - ' . $value['ville_centre'] . '</td>';
                            echo '<td><a href="?page=session&action=edit&id=' . $value['id_session'] . '">Modifier</a></td>';
                            echo '<td>
                            <form method="POST" action="?page=session&type=supprimer">
                                <input type="hidden" name="id_session" value="' . $value['id_session'] . '">
                                <button type="submit">Supprimer</button>
                            </form>
                          </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>

    <?php 
    }
?>

<?php 
    if (isset($_POST['submitSession'])){
        $dateDebut = $_POST['dateDebut'];
        $nomSession = $_POST['nomSession'];
        $idPedagogie = $_POST['idPedagogie'];
        $idFormation = $_POST['idFormation'];
        $idCentre = $_POST['idCentre'];

        $sql= "INSERT INTO `session`( `nom_session`, `date_debut`, `id_pedagogie`, `id_formation`, `id_centre`) VALUES ('$nomSession','$dateDebut','$idPedagogie','$idFormation','$idCentre')";
        $bdd->query($sql);

        echo "data ajoutée dans la bdd";

    }

?>

<?php
if(isset($_GET["page"]) && $_GET["page"] == "session") {
    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
        // Récupérer l'ID du rôle à modifier
        $idSessionToEdit = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        // Récupérer les informations du rôle à modifier depuis la base de données
        $sqlEditSession = "SELECT * FROM session WHERE id_session = :idSession";
        $sqlEditSession= $bdd->prepare($sqlEditSession);
        $sqlEditSession->bindParam(':idSession', $idSessionToEdit, PDO::PARAM_INT);
        $sqlEditSession->execute();
        $sessionToEdit = $sqlEditSession->fetch(PDO::FETCH_ASSOC);

        // Afficher le formulaire de modification
        if ($sessionToEdit) {
            ?>
            <form method="POST">
                <input type="hidden" name="idSessionToEdit" value="<?php echo $sessionToEdit['id_session']; ?>">
                <label>Nouveau</label>
                <input type="text" name="newNomSession" value="<?php echo $sessionToEdit['nom_session']; ?>">
                <input type="text" name="newDateDebut" value="<?php echo $sessionToEdit['date_debut']; ?>">
               
                <input type="submit" name="submitEditSession" value="Enregistrer">
            </form>
            <?php
        }
    }
}
?>

    <?php 

  
if(isset($_POST['submitEditSession'])) {
    $idSessionToEdit = $_POST['idSessionToEdit'];
    $newNomSession = $_POST['newNomSession'];
    $newDateDebut = $_POST['newDateDebut'];
  

    // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

    $sqlUpdateSession= "UPDATE session SET nom_session = :newNomSession, date_debut = :newDateDebut WHERE id_session = :idSessionToEdit";
    $sqlUpdateSession = $bdd->prepare($sqlUpdateSession);
    $sqlUpdateSession->bindParam(':idSessionToEdit', $idSessionToEdit, PDO::PARAM_INT);
    $sqlUpdateSession->bindParam(':newNomSession', $newNomSession, PDO::PARAM_STR);
    $sqlUpdateSession->bindParam(':newDateDebut', $newDateDebut, PDO::PARAM_STR);
    $sqlUpdateSession->execute();

    echo "Pédagogie mis à jour avec succès.";
}
?>
<!-- SUPPRIMER -->
<?php 
if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
    if (isset($_POST["id_session"])) {
        $deleteIdSession = $_POST["id_session"];
        $sqlDeleteSession = "DELETE FROM `session` WHERE id_session = $deleteIdSession";

        $bdd->query($sqlDeleteSession);
        echo "Données supprimées";
    }
}
?>
<!-- PAGE APPRENANTS -->
<?php 
if(isset($_GET["page"])&& $_GET["page"]=="apprenants"){

    $sqlapprenants = "SELECT
    `apprenants`.`id_apprenant`,
    `apprenants`.`nom_apprenant`,
    `apprenants`.`prenom_apprenant`,
    `apprenants`.`mail_apprenant`,
    `apprenants`.`adresse_apprenant`,
    `apprenants`.`ville_apprenant`,
    `apprenants`.`code_postal_apprenant`,
    `apprenants`.`tel_apprenant`,
    `apprenants`.`date_naissance_apprenant`,
    `apprenants`.`niveau_apprenant`,
    `apprenants`.`num_PE_apprenant`,
    `apprenants`.`num_secu_apprenant`,
    `apprenants`.`rib_apprenant`,
    `apprenants`.`num_PE_apprenant`,
    `apprenants`.`id_role`,
    `apprenants`.`id_session`,
    `role`.`id_role`, 
    `role`.`nom_role`,
    `session`.`id_session`,
    `session`.`nom_session`
FROM
    `apprenants`
LEFT JOIN
    `role` ON `apprenants`.`id_role` = `role`.`id_role`
LEFT JOIN
    `session` ON `apprenants`.`id_session` = `session`.`id_session`;";
    $requeteapprenants = $bdd->query($sqlapprenants);
    $resultsapprenants = $requeteapprenants->fetchAll(PDO::FETCH_ASSOC);


    $sqlrole = "SELECT * FROM role";
    $requeterole = $bdd->query($sqlrole);
    $resultsrole = $requeterole->fetchAll(PDO::FETCH_ASSOC);

    $sqlsession = "SELECT * FROM session";
    $requetesession = $bdd->query($sqlsession);
    $resultssession = $requetesession->fetchAll(PDO::FETCH_ASSOC);
    ?><form method="POST">
        <h1>Ajout Apprenant</h1>
        <label>Nom</label>
        <input type="text" name="nomApprenant">
        <label>Prénom</label>
        <input type="text" name="prenomApprenant">
        <label>Mail</label>
        <input type="text" name="mailApprenant">
        <label>Adresse</label>
        <input type="text" name="adresseApprenant">
        <label>Ville</label>
        <input type="text" name="villeApprenant">
        <label>Code Postal</label>
        <input type="text" name="cpApprenant">
        <label>Numéro</label>
        <input type="text" name="numApprenant">
        <label>Date de Naissance</label>
        <input type="text" name="naissanceApprenant" placeholder="YYYY-MM-DD">
        <label>Niveau</label>
        <input type="text" name="niveauApprenant">
        <label>Pôle emploie</label>
        <input type="text" name="peApprenant">
        <label>Sécu</label>
        <input type="text" name="secuApprenant">
        <label>RIB</label>
        <input type="text" name="ribApprenant">
        <label>Rôle</label>
        <select name="idRole" id="">
                <!-- <option value="idrole">id - nom role</option> -->
                <?php 
                
                foreach( $resultsrole as $value ){             
                        echo '<option value="' . $value['id_role'] .  '">' . $value['id_role'] . ' - ' . $value['nom_role'] . '</option>';   
                }
                ?>
            </select>
        <label>Session</label>
      
        <select name="idSession" id="">
                <!-- <option value="idrole">id - nom role</option> -->
                <?php 
                
                foreach( $resultssession as $value ){             
                        echo '<option value="' . $value['id_session'] .  '">' . $value['id_session'] . ' - ' . $value['nom_session'] . '</option>';   
                }
                ?>
            </select>
        <input type="submit" name="submitApprenant">
    
    </form>
    <br>
    <table border ="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Mail</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Code Postal</th>
                            <th>Numéro</th>
                            <th>Date de naissance</th>
                            <th>Niveau</th>
                            <th>Pôle Emploie</th>
                            <th>Sécu</th>
                            <th>RIB</th>
                            <th>Rôle</th>
                            <th>Session</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($resultsapprenants as $value) {
                            echo '<tr>';
                            echo '<td>' . $value['id_apprenant'] . '</td>';
                            echo '<td>' . $value['nom_apprenant'] . '</td>';
                            echo '<td>' . $value['prenom_apprenant'] . '</td>';
                            echo '<td>' . $value['mail_apprenant'] . '</td>';
                            echo '<td>' . $value['adresse_apprenant'] . '</td>';
                            echo '<td>' . $value['ville_apprenant'] . '</td>';
                            echo '<td>' . $value['code_postal_apprenant'] . '</td>';
                            echo '<td>' . $value['tel_apprenant'] . '</td>';
                            echo '<td>' . $value['date_naissance_apprenant'] . '</td>';
                            echo '<td>' . $value['niveau_apprenant'] . '</td>';
                            echo '<td>' . $value['num_PE_apprenant'] . '</td>';
                            echo '<td>' . $value['num_secu_apprenant'] . '</td>';
                            echo '<td>' . $value['rib_apprenant'] . '</td>';
                            echo '<td>' . $value['id_role'] . ' - ' . $value['nom_role'] . '</td>';
                            echo '<td>' . $value['id_session'] . ' - ' . $value['nom_session'] .'</td>';
                            echo '<td><a href="?page=apprenants&action=edit&id=' . $value['id_apprenant'] . '">Modifier</a></td>';
                            echo '<td>
                            <form method="POST" action="?page=apprenats&type=supprimer">
                                <input type="hidden" name="id_apprenant" value="' . $value['id_apprenant'] . '">
                                <button type="submit" style="max-width: 60px;" >Supprimer</button>
                            </form>
                          </td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
    <?php 
    }
?>
<?php 
    if(isset($_POST['submitApprenant'])) {
        $nomApprenant = $_POST['nomApprenant'];
        $prenomApprenant = $_POST['prenomApprenant'];
        $mailApprenant = $_POST['mailApprenant'];
        $adresseApprenant = $_POST['adresseApprenant'];
        $villeApprenant = $_POST['villeApprenant'];
        $cpApprenant = $_POST['cpApprenant'];
        $numApprenant = $_POST['numApprenant'];
        $naissanceApprenant = $_POST['naissanceApprenant'];
        $niveauApprenant = $_POST['niveauApprenant'];
        $peApprenant = $_POST['peApprenant'];
        $secuApprenant= $_POST['secuApprenant'];
        $ribApprenant = $_POST['ribApprenant'];
        $idRole = $_POST['idRole'];
        $idSession =$_POST['idSession'];

        // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

        $sql = "INSERT INTO `apprenants`(`nom_apprenant`, `prenom_apprenant`,
         `mail_apprenant`, `adresse_apprenant`, `ville_apprenant`, `code_postal_apprenant`,
          `tel_apprenant`, `date_naissance_apprenant`, `niveau_apprenant`, 
          `num_PE_apprenant`, `num_secu_apprenant`, `rib_apprenant`, `id_role`, `id_session`)
           VALUES ('$nomApprenant','$prenomApprenant','$mailApprenant','$adresseApprenant','$villeApprenant','$cpApprenant','$numApprenant','$naissanceApprenant','$niveauApprenant','$peApprenant','$secuApprenant','$ribApprenant','$idRole','$idSession')";
         

        $bdd->query($sql);

        echo "Données ajoutées dans la base de données";  
    }
   
?>



?>

<?php
if(isset($_GET["page"]) && $_GET["page"] == "apprenants") {
    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
        // Récupérer l'ID du rôle à modifier
        $idApprenantToEdit = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        // Récupérer les informations du rôle à modifier depuis la base de données
        $sqlEditApprenant = "SELECT * FROM apprenants WHERE id_apprenant = :idApprenant";
        $sqlEditApprenant= $bdd->prepare($sqlEditApprenant);
        $sqlEditApprenant->bindParam(':idApprenant', $idApprenantToEdit, PDO::PARAM_INT);
        $sqlEditApprenant->execute();
        $apprenantToEdit = $sqlEditApprenant->fetch(PDO::FETCH_ASSOC);

        // Afficher le formulaire de modification
        if ($apprenantToEdit) {
            ?>
            <form method="POST">
                <input type="hidden" name="idApprenantToEdit" value="<?php echo $apprenantToEdit['id_apprenant']; ?>">
                <label>Nouveau</label>
                <input type="text" name="newNomApprenant" value="<?php echo $apprenantToEdit['nom_apprenant']; ?>">
                <input type="text" name="newPrenomApprenant" value="<?php echo $apprenantToEdit['prenom_apprenant']; ?>">
                <input type="text" name="newMailApprenant" value="<?php echo $apprenantToEdit['mail_apprenant']; ?>">    
                <input type="text" name="newAdresseApprenant" value="<?php echo $apprenantToEdit['adresse_apprenant']; ?>">        
                <input type="text" name="newVilleApprenant" value="<?php echo $apprenantToEdit['ville_apprenant']; ?>">                  
                <input type="text" name="newCpApprenant" value="<?php echo $apprenantToEdit['code_postal_apprenant']; ?>">             
                <input type="text" name="newNumApprenant" value="<?php echo $apprenantToEdit['tel_apprenant']; ?>">
               <input type="text" name="newNaissanceApprenant" value="<?php echo $apprenantToEdit['date_naissance_apprenant']; ?>">
                <input type="text" name="newNiveauApprenant" value="<?php echo $apprenantToEdit['niveau_apprenant']; ?>">
                <input type="text" name="newPeApprenant" value="<?php echo $apprenantToEdit['num_PE_apprenant']; ?>">
                <input type="text" name="newSecuApprenant" value="<?php echo $apprenantToEdit['num_secu_apprenant']; ?>">
                <input type="text" name="newRibApprenant" value="<?php echo $apprenantToEdit['rib_apprenant']; ?>">
                <input type="submit" name="submitEditApprenant" value="Enregistrer">
            </form>
            <?php
        }
    }
}
?>

    <?php 

  
if(isset($_POST['submitEditApprenant'])) {
    $idApprenantToEdit = $_POST['idApprenantToEdit'];
    $newNomApprenant = $_POST['newNomApprenant'];
    $newPrenomApprenant = $_POST['newPrenomApprenant'];
    $newMailApprenant = $_POST['newMailApprenant'];
    $newAdresseApprenant = $_POST['newAdresseApprenant'];
    $newVilleApprenant = $_POST['newVilleApprenant'];
    $newCpApprenant = $_POST['newCpApprenant'];
    $newNumApprenant = $_POST['newNumApprenant'];
    $newNaissanceApprenant = $_POST['newNaissanceApprenant'];
    $newNiveauApprenant = $_POST['newNiveauApprenant'];
    $newPeApprenant = $_POST['newPeApprenant'];
    $newSecuApprenant = $_POST['newSecuApprenant'];
    $newRibApprenant = $_POST['newRibApprenant'];
  
 
  

    // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

    
    $sqlUpdateApprenant = "UPDATE apprenants SET 
        nom_apprenant = :newNomApprenant,
        prenom_apprenant = :newPrenomApprenant,
        mail_apprenant = :newMailApprenant,
        adresse_apprenant = :newAdresseApprenant,
        ville_apprenant = :newVilleApprenant,
        code_postal_apprenant = :newCpApprenant,
        tel_apprenant = :newNumApprenant,
        date_naissance_apprenant = :newNaissanceApprenant,
        niveau_apprenant = :newNiveauApprenant,
        num_PE_apprenant = :newPeApprenant,
        num_secu_apprenant = :newSecuApprenant,
        rib_apprenant = :newRibApprenant
        WHERE id_apprenant = :idApprenantToEdit";

    $stmtUpdateApprenant = $bdd->prepare($sqlUpdateApprenant);
    $stmtUpdateApprenant->bindParam(':idApprenantToEdit', $idApprenantToEdit, PDO::PARAM_INT);
    $stmtUpdateApprenant->bindParam(':newNomApprenant', $newNomApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newPrenomApprenant', $newPrenomApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newMailApprenant', $newMailApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newAdresseApprenant', $newAdresseApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newVilleApprenant', $newVilleApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newCpApprenant', $newCpApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newNumApprenant', $newNumApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newNaissanceApprenant', $newNaissanceApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newNiveauApprenant', $newNiveauApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newPeApprenant', $newPeApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newSecuApprenant', $newSecuApprenant, PDO::PARAM_STR);
    $stmtUpdateApprenant->bindParam(':newRibApprenant', $newRibApprenant, PDO::PARAM_STR);

    $stmtUpdateApprenant->execute();

    echo "Apprenant mis à jour avec succès.";
}
?>

<!-- SUPPRIMER -->
<?php 
if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
    if (isset($_POST["id_apprenant"])) {
        $deleteIdApprenant = $_POST["id_apprenant"];
        $sqlDeleteApprenant = "DELETE FROM `apprenants` WHERE id_apprenant = $deleteIdApprenant";

        $bdd->query($sqlDeleteApprenant);
        echo "Données supprimées";
    }
}
?>

<!-- JOINTURE AFFECTER -->
<?php
if(isset($_GET["page"]) && $_GET["page"]=="affecter") {
    $sqlaffecter = "SELECT * FROM affecter";
    $requeteAffecter = $bdd->query($sqlaffecter);
    
    $resultatsAffecter = $requeteAffecter->fetchAll(PDO::FETCH_ASSOC);

    // Inclure votre fichier de connexion à la base de données ici

    // Récupérer la liste des centres
    $sqlCentres = "SELECT id_centre, ville_centre FROM centres";
    $requeteCentres = $bdd->query($sqlCentres);
    $centres = $requeteCentres->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer la liste des membres de l'équipe pédagogique
    $sqlPedagogie = "SELECT id_pedagogie, nom_pedagogie, prenom_pedagogie FROM pedagogie";
    $requetePedagogie = $bdd->query($sqlPedagogie);
    $pedagogie = $requetePedagogie->fetchAll(PDO::FETCH_ASSOC);

    $resultsaffecter = $resultatsAffecter;
?>
    <h1>Affecter Membre Pédagogique à un Centre</h1>

    <br>
 
    <table border="1">
        <thead>
            <tr>
                <th>ID Centre</th>
                <th>ID Pédagogie</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($resultsaffecter as $value) {
                echo '<tr>';
                echo '<td>' . $value['id_centre'] . '</td>';
                echo '<td>' . $value['id_pedagogie'] . '</td>';
               
                echo '<td>
                        <form method="POST" action="?page=affecter&type=supprimer">
                            <input type="hidden" name="id_centre" value="' . $value['id_centre'] . '">
                            <input type="hidden" name="id_pedagogie" value="' . $value['id_pedagogie'] . '">
                            <button type="submit">Supprimer</button>
                        </form>
                      </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <form method="POST">
        <label>Centre</label>
        
        <select name="id_centre">
            <?php
            foreach ($centres as $centre) {
                echo '<option value="' . $centre['id_centre'] . '">' . $centre['ville_centre'] . '</option>';
            }
            ?>
        </select>

        <label>Membre Pédagogique</label>
        <select name="id_pedagogie">
            <?php
            foreach ($pedagogie as $pedagogie) {
                echo '<option value="' . $pedagogie['id_pedagogie'] . '">' . $pedagogie['nom_pedagogie'] . ' ' . $pedagogie['prenom_pedagogie'] . '</option>';
            }
           
            ?>
        </select>
    

        <input type="submit" name="submitAffecter">
    
    </form>

    <?php
    // Traitement du formulaire d'affectation
    if(isset($_POST['submitAffecter'])) {
        $id_centre = $_POST['id_centre'];
        $id_pedagogie = $_POST['id_pedagogie'];

        // Assurez-vous de sécuriser votre code contre les attaques par injection SQL

        $sqlAffecter = "INSERT INTO `affecter`(`id_centre`, `id_pedagogie`) VALUES (:id_centre, :id_pedagogie)";

        $stmtAffecter = $bdd->prepare($sqlAffecter);
        $stmtAffecter->bindParam(':id_centre', $id_centre, PDO::PARAM_INT);
        $stmtAffecter->bindParam(':id_pedagogie', $id_pedagogie, PDO::PARAM_INT);

        if($stmtAffecter->execute()) {
            echo "Membre affecté avec succès.";
        } else {
            echo "Erreur lors de l'affectation.";
        }
    }
    ?>

    <!-- SUPPRIMER -->
    <?php 
    if (isset($_GET['type']) && $_GET['type'] == "supprimer") {
        if (isset($_POST["id_centre"])) {
            $deleteIdAffecter = $_POST["id_centre"];$_POST["id_pedagogie"];
            $sqlDeleteAffecter = "DELETE FROM `affecter` WHERE id_centre = $deleteIdCentre and id_pedagogie = $deleteIdPedagogie";

            $bdd->query($sqlDeleteCentre)($sqlDeletePedagogie);
            echo "Données supprimées";
        }
    }  }
    ?>
</body>
</html>




