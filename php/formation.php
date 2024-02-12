
<?php 
    if(isset($_GET["page"])&& $_GET["page"]=="formations"){
        $resultatsformation = selectAll("formations");
        // $sqlformation= "SELECT * FROM formations";
        // $requeteformation = $bdd->query($sqlformation);
        // $resultatsformation = $requeteformation->fetchAll(PDO::FETCH_ASSOC);
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
