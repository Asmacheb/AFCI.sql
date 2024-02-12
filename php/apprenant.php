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

    $resultsrole= selectAll('role');
    // $sqlrole = "SELECT * FROM role";
    // $requeterole = $bdd->query($sqlrole);
    // $resultsrole = $requeterole->fetchAll(PDO::FETCH_ASSOC);

    $resultssession= selectAll('session');
    // $sqlsession = "SELECT * FROM session";
    // $requetesession = $bdd->query($sqlsession);
    // $resultssession = $requetesession->fetchAll(PDO::FETCH_ASSOC);
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