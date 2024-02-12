<?php
function selectAll($table) {
        global $bdd;
      $sql = "SELECT * FROM $table";
      $query = $bdd->query($sql);
      return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // PAGE ROLES


    if(isset($_GET["page"])&& $_GET["page"]=="roles"){
        $resultatsrole = selectAll("role");
        
        // $sqlrole = "SELECT * FROM role";
        // $requeterole = $bdd->query($sqlrole);
        // $resultatsrole = $requeterole->fetchAll(PDO::FETCH_ASSOC);

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
