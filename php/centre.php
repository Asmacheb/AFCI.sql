
<?php 
    if(isset($_GET["page"])&& $_GET["page"]=="centres"){
        $resultatscentre = selectAll("centres");
        // $sqlcentre = "SELECT * FROM centres";
        // $requetecentre = $bdd->query($sqlcentre);
        // $resultatscentre = $requetecentre->fetchAll(PDO::FETCH_ASSOC);
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