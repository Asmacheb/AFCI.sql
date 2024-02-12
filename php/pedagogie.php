<?php 
if(isset($_GET["page"])&& $_GET["page"]=="pedagogie"){
        $sqlpedagogie = "SELECT `id_pedagogie`, `nom_pedagogie`, `prenom_pedagogie`, `mail_pedagogie`, `num_pedagogie`, `pedagogie`.`id_role`, `nom_role`
        FROM `pedagogie`
        JOIN `role` ON `pedagogie`.`id_role` = `role`.`id_role`;
        ";
        // $requetepedagogie = $bdd->query($sqlpedagogie);
        // $resultspedagogie = $requetepedagogie->fetchAll(PDO::FETCH_ASSOC);

        // $sql = "SELECT * FROM role";
        // $requete = $bdd->query($sql);
        // $results = $requete->fetchAll(PDO::FETCH_ASSOC);

        $resultspedagogie = selectAll("pedagogie");

    

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