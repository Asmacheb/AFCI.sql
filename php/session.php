
<?php 
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
    
    $resultspedagogie= selectAll('pedagogie');

    // $sqlpedagogie = "SELECT * FROM pedagogie";
    // $requetepegagogie = $bdd->query($sqlpedagogie); 
    // $resultspedagogie = $requetepegagogie->fetchAll(PDO::FETCH_ASSOC); 

    $resultsformation = selectAll('formations');

    // $sqlformation = "SELECT * FROM formations";
    // $requeteformation = $bdd->query($sqlformation);
    // $resultsformation = $requeteformation->fetchAll(PDO::FETCH_ASSOC);

    $resultscentre = selectAll('centres');
    // $sqlcentre = "SELECT * FROM centres";
    // $requetecentre = $bdd->query($sqlcentre);
    // $resultscentre = $requetecentre->fetchAll(PDO::FETCH_ASSOC);

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