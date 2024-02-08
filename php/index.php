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
    word-wrap: break-word; 
       
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

use function PHPSTORM_META\sql_injection_subst;

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
        <a href="?page=connexion"> <li>Connexion</li></a>
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



// if(isset($_POST['submitRole'])){
//     $nomRole = htmlspecialchars($_POST['nomRole']);
//     $sql = "INSERT INTO `role`(`nom_role`) VALUES ('$nomRole')";
//     $bdd->query($sql);
//     echo "Données ajoutées dans la BDD";
// }

    // PAGE ROLES


    if(isset($_GET["page"])&& $_GET["page"]=="roles"){
        $sqlrole = "SELECT * FROM role";
        $requeterole = $bdd->query($sqlrole);
        $resultatsrole = $requeterole->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <br>
        <form method="POST">
        <label>Rôle</label>
        <input type="text" name="<?php echo htmlspecialchars('nomRole'); ?>">
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
                            echo '<td>' . htmlspecialchars($value['id_role']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['nom_role']) . '</td>';
                            echo '<td><a href="'. htmlspecialchars('?page=roles&action=edit&id=' . $value['id_role']) . '">Modifier</a></td>';
                            echo '<td>
                                    <form method="POST" action="'. htmlspecialchars('?page=role&type=supprimer') .'">
                                        <input type="hidden" name="id_role" value="'. htmlspecialchars($value['id_role']) .'">
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
    <input type="text" name="<?php echo htmlspecialchars('villeCentre'); ?>" >
    <label>Adresse</label>
    <input type="text" name="<?php echo htmlspecialchars('adresseCentre'); ?>">
    <label>Code Postal</label>
    <input type="text" name="<?php echo htmlspecialchars('cpCentre'); ?>">
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
                            echo '<td>' . htmlspecialchars($value['id_centre']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['ville_centre']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['adresse_centre']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['code_postal_centre']) . '</td>';
                            echo '<td><a href="'. htmlspecialchars('?page=centres&action=edit&id=' . $value['id_centre']) . '">Modifier</a></td>';
                            echo '<td>
                                    <form method="POST" action="'. htmlspecialchars('?page=centres&type=supprimer') .'">
                                        <input type="hidden" name="id_centre" value="'. htmlspecialchars($value['id_centre']) .'">
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
    $villeCentre = htmlspecialchars($_POST['villeCentre']);
    $adresseCentre = htmlspecialchars($_POST['adresseCentre']);
    $cpCentre = htmlspecialchars($_POST['cpCentre']);


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
                <input type="hidden" name="idCentreToEdit" value="<?php echo htmlspecialchars($centreToEdit['id_centre']); ?>">
                <label>Nouveau nom du Centre</label>
                <input type="text" name="newNomCentre" value="<?php echo htmlspecialchars($centreToEdit['ville_centre']); ?>">
                <input type="text" name="newAdresseCentre" value="<?php echo htmlspecialchars($centreToEdit['adresse_centre']); ?>">
                <input type="text" name="newCpCentre" value="<?php echo htmlspecialchars($centreToEdit['code_postal_centre']); ?>">
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
    $newNomCentre = htmlspecialchars($_POST['newNomCentre']);
    $newAdresseCentre = htmlspecialchars($_POST['newAdresseCentre']);
    $newCpCentre = htmlspecialchars($_POST['newCpCentre']);


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
        $deleteIdcentre = htmlspecialchars($_POST["id_centre"]);
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
                            echo '<td>' . htmlspecialchars($value['id_formation']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['nom_formation']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['duree_formation']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['niveau_sortie_formation']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['description']) . '</td>';
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
        $nomFormation = htmlspecialchars($_POST['nomFormation']);
        $dureeFormation = htmlspecialchars($_POST['dureeFormation']);
        $niveauFormation = htmlspecialchars($_POST['niveauFormation']);
        $descriptionFormation = htmlspecialchars($_POST['descriptionFormation']);
    
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
        $deleteIdFormation = htmlspecialchars($_POST["id_formation"]);
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
                        echo '<td>' . htmlspecialchars($value['id_pedagogie']) . '</td>';
                        echo '<td>' . htmlspecialchars($value['nom_pedagogie']) . '</td>';
                        echo '<td>' . htmlspecialchars($value['prenom_pedagogie']) . '</td>';
                        echo '<td>' . htmlspecialchars($value['mail_pedagogie']) . '</td>';
                        echo '<td>' . htmlspecialchars($value['num_pedagogie']) . '</td>';
                        echo '<td>' . htmlspecialchars($value['id_role']) . ' - ' . htmlspecialchars($value['nom_role']) . '</td>';
                        echo '<td><a href="?page=pedagogie&action=edit&id=' . htmlspecialchars($value['id_pedagogie']) . '">Modifier</a></td>';
                        echo '<td>
                        <form method="POST" action="?page=pedagogie&type=supprimer">
                            <input type="hidden" name="id_pedagogie" value="' . htmlspecialchars($value['id_pedagogie']) . '">
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
        $nomPedagogie = htmlspecialchars($_POST['nomPedagogie']);
    $prenomPedagogie = htmlspecialchars($_POST['prenomPedagogie']);
    $mailPedagogie = htmlspecialchars($_POST['mailPedagogie']);
    $numPedagogie = htmlspecialchars($_POST['numPedagogie']);
    $idPedagogie = htmlspecialchars($_POST['idPedagogie']);

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
    $idFormationToEdit = htmlspecialchars($_POST['idPedagogieToEdit']);
    $newNomPedagogie = htmlspecialchars($_POST['newNomPedagogie']);
    $newPrenomPedagogie = htmlspecialchars($_POST['newPrenomPedagogie']);
    $newMailPedagogie = htmlspecialchars($_POST['newMailPedagogie']);
    $newNumPedagogie = htmlspecialchars($_POST['newNumPedagogie']);

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
        $deleteIdPedagogie = htmlspecialchars($_POST["id_pedagogie"]);
        $sqlDeletePedagogie = "DELETE FROM `pedagogie` WHERE id_pedagogie = $deleteIdPedagogie";

        $bdd->query($sqlDeletePedagogie);
        echo "Données supprimées";
    }
}
?>

<?php 
// PAGE SESSIONS
if(isset($_GET["page"]) && $_GET["page"] == "sessions") {
    // Récupération des données pour affichage
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

    ?> 
    <form method="POST">
        <h1>Ajout sessions</h1>
        <label>Nom Session</label>
        <input type="text" name="nomSession">
        <label>Date Début</label>
        <input type="text" name="dateDebut">
        <label>Pédagogie</label>
        <select name="idPedagogie" id="">
            <?php 
            foreach($resultspedagogie as $value) {             
                echo '<option value="' . htmlspecialchars($value['id_pedagogie']) . '">' . htmlspecialchars($value['id_pedagogie']) . ' - ' . htmlspecialchars($value['nom_pedagogie']) . ' ' . htmlspecialchars($value['prenom_pedagogie']) . '</option>';   
            }
            ?>
        </select>
        <label>Formation</label>
        <select name="idFormation" id="">
            <?php 
            foreach($resultsformation as $value) {             
                echo '<option value="' . htmlspecialchars($value['id_formation']) . '">' . htmlspecialchars($value['id_formation']) . ' - ' . htmlspecialchars($value['nom_formation']) . '</option>';   
            }
            ?>
        </select>
        <label>Centre</label>
        <select name="idCentre" id="">
            <?php 
            foreach($resultscentre as $value) {             
                echo '<option value="' . htmlspecialchars($value['id_centre']) . '">' . htmlspecialchars($value['id_centre']) . ' - ' . htmlspecialchars($value['ville_centre']) . '</option>';   
            }
            ?>
        </select>
        <input type="submit" name="submitSession">
    </form>

    <br>
    <table border="1">
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
                echo '<td>' . htmlspecialchars($value['id_session']) . '</td>';
                echo '<td>' . htmlspecialchars($value['nom_session']) . '</td>';
                echo '<td>' . htmlspecialchars($value['date_debut']) . '</td>';
                echo '<td>' . htmlspecialchars($value['id_pedagogie']) . ' - ' . htmlspecialchars($value['nom_pedagogie']) . ' ' . htmlspecialchars($value['prenom_pedagogie']) . '</td>';
                echo '<td>' . htmlspecialchars($value['id_formation']) . ' - ' . htmlspecialchars($value['nom_formation']) . '</td>';
                echo '<td>' . htmlspecialchars($value['id_centre']) . ' - ' . htmlspecialchars($value['ville_centre']) . '</td>';
                echo '<td><a href="?page=session&action=edit&id=' . htmlspecialchars($value['id_session']) . '">Modifier</a></td>';
                echo '<td>
                    <form method="POST" action="?page=session&type=supprimer">
                        <input type="hidden" name="id_session" value="' . htmlspecialchars($value['id_session']) . '">
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
// Gestion de l'ajout d'une session
if (isset($_POST['submitSession'])) {
    $dateDebut = htmlspecialchars($_POST['dateDebut']);
    $nomSession = htmlspecialchars($_POST['nomSession']);
    $idPedagogie = htmlspecialchars($_POST['idPedagogie']);
    $idFormation = htmlspecialchars($_POST['idFormation']);
    $idCentre = htmlspecialchars($_POST['idCentre']);

    $sql = "INSERT INTO `session`(`nom_session`, `date_debut`, `id_pedagogie`, `id_formation`, `id_centre`) VALUES ('$nomSession','$dateDebut','$idPedagogie','$idFormation','$idCentre')";
    $bdd->query($sql);

    echo "Données ajoutées dans la base de données";
}
?>

<?php
// Gestion de la modification d'une session
if(isset($_GET["page"]) && $_GET["page"] == "session") {
    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
        // Récupération des informations de la session à modifier
        $idSessionToEdit = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

        $sqlEditSession = "SELECT * FROM session WHERE id_session = :idSession";
        $sqlEditSession = $bdd->prepare($sqlEditSession);
        $sqlEditSession->bindParam(':idSession', $idSessionToEdit, PDO::PARAM_INT);
        $sqlEditSession->execute();
        $sessionToEdit = $sqlEditSession->fetch(PDO::FETCH_ASSOC);

        // Affichage du formulaire de modification prérempli
        if ($sessionToEdit) {
            ?>
            <form method="POST">
                <h1>Modification de session</h1>
                <input type="hidden" name="idSessionToEdit" value="<?php echo htmlspecialchars($sessionToEdit['id_session']); ?>">
                <label>Nouveau Nom Session</label>
                <input type="text" name="nomSession" value="<?php echo htmlspecialchars($sessionToEdit['nom_session']); ?>">
                <label>Nouvelle Date Début</label>
                <input type="text" name="dateDebut" value="<?php echo htmlspecialchars($sessionToEdit['date_debut']); ?>">
                <label>Nouvelle Pédagogie</label>
                <select name="idPedagogie" id="">
                    <?php 
                    foreach($resultspedagogie as $value) { 
                        $selected = ($value['id_pedagogie'] == $sessionToEdit['id_pedagogie']) ? 'selected' : '';             
                        echo '<option value="' . htmlspecialchars($value['id_pedagogie']) . '" '.$selected.'>' . htmlspecialchars($value['id_pedagogie']) . ' - ' . htmlspecialchars($value['nom_pedagogie']) . ' ' . htmlspecialchars($value['prenom_pedagogie']) . '</option>';   
                    }
                    ?>
                </select>
                <label>Nouvelle Formation</label>
                <select name="idFormation" id="">
                    <?php 
                    foreach($resultsformation as $value) { 
                        $selected = ($value['id_formation'] == $sessionToEdit['id_formation']) ? 'selected' : '';             
                        echo '<option value="' . htmlspecialchars($value['id_formation']) . '" '.$selected.'>' . htmlspecialchars($value['id_formation']) . ' - ' . htmlspecialchars($value['nom_formation']) . '</option>';   
                    }
                    ?>
                </select>
                <label>Nouveau Centre</label>
                <select name="idCentre" id="">
                    <?php 
                    foreach($resultscentre as $value) { 
                        $selected = ($value['id_centre'] == $sessionToEdit['id_centre']) ? 'selected' : '';             
                        echo '<option value="' . htmlspecialchars($value['id_centre']) . '" '.$selected.'>' . htmlspecialchars($value['id_centre']) . ' - ' . htmlspecialchars($value['ville_centre']) . '</option>';   
                    }
                    ?>
                </select>
                <input type="submit" name="submitEditSession">
            </form>
            <?php
        } else {
            echo "Session non trouvée.";
        }
    }
}

// Gestion de la modification des données d'une session
if(isset($_POST['submitEditSession'])) {
    $idSessionToEdit = htmlspecialchars($_POST['idSessionToEdit']);
    $dateDebut = htmlspecialchars($_POST['dateDebut']);
    $nomSession = htmlspecialchars($_POST['nomSession']);
    $idPedagogie = htmlspecialchars($_POST['idPedagogie']);
    $idFormation = htmlspecialchars($_POST['idFormation']);
    $idCentre = htmlspecialchars($_POST['idCentre']);

    $sql = "UPDATE `session` SET `nom_session`='$nomSession',`date_debut`='$dateDebut',`id_pedagogie`='$idPedagogie',`id_formation`='$idFormation',`id_centre`='$idCentre' WHERE id_session = $idSessionToEdit";
    $bdd->query($sql);

    echo "Données mises à jour dans la base de données";
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
                    echo '<option value="' . htmlspecialchars($value['id_role']) .  '">' . htmlspecialchars($value['id_role']) . ' - ' . htmlspecialchars($value['nom_role']) . '</option>';   
            }
            ?>
        </select>
    <label>Session</label>
  
    <select name="idSession" id="">
            <!-- <option value="idrole">id - nom role</option> -->
            <?php 
            
            foreach( $resultssession as $value ){             
                    echo '<option value="' . htmlspecialchars($value['id_session']) .  '">' . htmlspecialchars($value['id_session']) . ' - ' . htmlspecialchars($value['nom_session']) . '</option>';   
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
                            echo '<td>' . htmlspecialchars($value['id_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['nom_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['prenom_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['mail_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['adresse_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['ville_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['code_postal_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['tel_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['date_naissance_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['niveau_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['num_PE_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['num_secu_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['rib_apprenant']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['id_role']) . ' - ' . htmlspecialchars($value['nom_role']) . '</td>';
                            echo '<td>' . htmlspecialchars($value['id_session']) . ' - ' . htmlspecialchars($value['nom_session']) .'</td>';
                            echo '<td><a href="?page=apprenants&action=edit&id=' . htmlspecialchars($value['id_apprenant']) . '">Modifier</a></td>';
                            echo '<td>
                            <form method="POST" action="?page=apprenats&type=supprimer">
                                <input type="hidden" name="id_apprenant" value="' . htmlspecialchars($value['id_apprenant']) . '">
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
        $nomApprenant = htmlspecialchars($_POST['nomApprenant']);
        $prenomApprenant = htmlspecialchars($_POST['prenomApprenant']);
        $mailApprenant = htmlspecialchars($_POST['mailApprenant']);
        $adresseApprenant = htmlspecialchars($_POST['adresseApprenant']);
        $villeApprenant = htmlspecialchars($_POST['villeApprenant']);
        $cpApprenant = htmlspecialchars($_POST['cpApprenant']);
        $numApprenant = htmlspecialchars($_POST['numApprenant']);
        $naissanceApprenant = htmlspecialchars($_POST['naissanceApprenant']);
        $niveauApprenant = htmlspecialchars($_POST['niveauApprenant']);
        $peApprenant = htmlspecialchars($_POST['peApprenant']);
        $secuApprenant= htmlspecialchars($_POST['secuApprenant']);
        $ribApprenant = htmlspecialchars($_POST['ribApprenant']);
        $idRole = htmlspecialchars($_POST['idRole']);
        $idSession = htmlspecialchars($_POST['idSession']);

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
    $idApprenantToEdit = htmlspecialchars($_POST['idApprenantToEdit']);
    $newNomApprenant = htmlspecialchars($_POST['newNomApprenant']);
    $newPrenomApprenant = htmlspecialchars($_POST['newPrenomApprenant']);
    $newMailApprenant = htmlspecialchars($_POST['newMailApprenant']);
    $newAdresseApprenant = htmlspecialchars($_POST['newAdresseApprenant']);
    $newVilleApprenant = htmlspecialchars($_POST['newVilleApprenant']);
    $newCpApprenant = htmlspecialchars($_POST['newCpApprenant']);
    $newNumApprenant = htmlspecialchars($_POST['newNumApprenant']);
    $newNaissanceApprenant = htmlspecialchars($_POST['newNaissanceApprenant']);
    $newNiveauApprenant = htmlspecialchars($_POST['newNiveauApprenant']);
    $newPeApprenant = htmlspecialchars($_POST['newPeApprenant']);
    $newSecuApprenant = htmlspecialchars($_POST['newSecuApprenant']);
    $newRibApprenant = htmlspecialchars($_POST['newRibApprenant']);
  
 
  

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
        $deleteIdApprenant = htmlspecialchars($_POST["id_apprenant"]);
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
                echo '<td>' . htmlspecialchars($value['id_centre']) . '</td>';
                echo '<td>' . htmlspecialchars($value['id_pedagogie']) . '</td>';
               
                echo '<td>
                <form method="POST" action="?page=affecter&type=supprimer">
                    <input type="hidden" name="id_centre" value="' . htmlspecialchars($value['id_centre']) . '">
                    <input type="hidden" name="id_pedagogie" value="' . htmlspecialchars($value['id_pedagogie']) . '">
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
            echo '<option value="' . htmlspecialchars($centre['id_centre']) . '">' . htmlspecialchars($centre['ville_centre']) . '</option>';
        }
        ?>
    </select>

    <label>Membre Pédagogique</label>
    <select name="id_pedagogie">
        <?php
        foreach ($pedagogie as $ped) {
            echo '<option value="' . htmlspecialchars($ped['id_pedagogie']) . '">' . htmlspecialchars($ped['nom_pedagogie']) . ' ' . htmlspecialchars($ped['prenom_pedagogie']) . '</option>';
        }
            ?>
        </select>
    

        <input type="submit" name="submitAffecter">
    
    </form>

    <?php
    // Traitement du formulaire d'affectation
    if(isset($_POST['submitAffecter'])) {
        $id_centre = htmlspecialchars($_POST["id_centre"]);
    $id_pedagogie = htmlspecialchars($_POST["id_pedagogie"]);

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
            $deleteIdAffecter = htmlspecialchars($_POST["id_centre"]);htmlspecialchars($_POST["id_pedagogie"]);
            $sqlDeleteAffecter = "DELETE FROM `affecter` WHERE id_centre = $deleteIdCentre and id_pedagogie = $deleteIdPedagogie";

            $bdd->query($sqlDeleteCentre)($sqlDeletePedagogie);
            echo "Données supprimées";
        }
    }  }
    ?>

    <!-- PAGE USERS -->

<h2>Créer un Identifiant</h2>
    <form method="POST">
        <label for="">Identifiant</label>
        <input type="text" name="identifiant">
        <label for="">Password</label>
        <input type="text" name="password">
        <input type="submit" name="submit">
    </form>

    <h2>Se connecter</h2>
    <form method="POST">
        <label for="">Identifiant</label>
        <input type="text" name="identifiantLogin">
        <label for="">Password</label>
        <input type="text" name="passwordLogin">
        <input type="submit" name="submitLogin">
    </form>
<?php
    if(isset($_POST['submit'])){
        $identifiant = htmlspecialchars($_POST['identifiant']);
        $password = htmlspecialchars($_POST['password']);
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

       
     
        $sql = "INSERT INTO `Users`(`identifiant`, `password`) VALUES (:identifiant, :password)";

        $stmt = $bdd->prepare($sql);
        $stmt->bindParam(':identifiant', $identifiant, PDO::PARAM_INT);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_INT);
        $stmt->execute();
        echo"enregistré";
    }

    if(isset($_POST['submitLogin'])){
        $identifiantLogin = htmlspecialchars($_POST['identifiantLogin']);
        $passwordLogin = htmlspecialchars ($_POST['passwordLogin']);

        
        
        $sqlLog = "SELECT * FROM `Users` WHERE identifiant = :identifiantLogin";
        $stmtLog = $bdd->prepare($sqlLog);
        $stmtLog->bindParam(':identifiantLogin', $identifiantLogin, PDO::PARAM_INT);
        $stmtLog->execute();
        $data = $stmtLog->fetch(PDO::FETCH_ASSOC);

        if($data){
            if(password_verify($passwordLogin,$data['password'])){
                echo"connexion réussi";
            }
            else{
                echo"password incorrect";
            } 

            
        }
        else {
            echo"identifiant incorrect";
           } 
    }
    ?>
</body>
</html>



