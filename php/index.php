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






  <!-- PAGE ROLES -->
  <?php
 include "role.php";
   

//  <!-- PAGE CENTRES -->


 include "centre.php";

// - PAGE FORMATIONS -->


 include "formation.php";


//  <!-- PAGE PEDAGOGIE -->

 
 include "pedagogie.php";


// PAGE SESSIONS -->


 include "session.php";

// <!-- PAGE APPRENANTS -->

 include "apprenant.php";

// <!-- JOINTURE AFFECTER -->

 include "affecter.php";
    

    // <!-- PAGE USERS -->
   
 include "connexion.php";
 ?>
</body>
</html>



