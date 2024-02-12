
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