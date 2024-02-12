<?php
if(isset($_GET["page"])&& $_GET["page"]=="connexion"){
?>
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
}
    ?>