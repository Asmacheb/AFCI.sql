<!-- En souvenir du bon vieux temps, vous allez vous baser sur un ancien exercice : le jeu au tour par tour.

L'objectif est de créer des classes pour chacun de vos personnages qui en découle d'une classe de base.

Il faut que chaque personnage ait au moins une capacité spéciale et que le personnage de base aie des points de vie, une défense et des points d'attaque au minimum -->

<?php

class Personnage{

      // Attributs
      public $nom;
      public $degats;
      public $action;
     

      public function __construct($nom,$degats,$action){
        $this->nom = $nom;
        $this->degats = $degats;
        $this->action = $action;  
    }

       // Getters
    public function getNom(){
        return $this->nom;
    }
    public function getDegats(){
        return $this->degats;
    }
    public function getAction(){
        return $this->action;
    }

     // Setters

     public function setNom(){
        return $this->nom;
    }
    public function setDegats(){
        return $this->degats;
    }
    public function setAction(){
        return $this->action;
    }

}


// GUERRIER

class Guerrier extends Personnage{
    public function role() {
        echo "Mon rôle est de defoncer l'adversaire"; 
    }

}
$guerrier = new Guerrier("Guerrier", "-3 vies", "Coup");
echo $guerrier->role(); 
echo "<br>";


$guerrier = new Guerrier ("Guerrier", "-3 vies", "Coup");
echo $guerrier->getNom() . '<br>';
echo $guerrier->getDegats(). '<br>';
echo $guerrier->getAction() . '<br>';
echo "<br>";


// MAGE
class Mage extends Personnage{
    public function role() {
        echo "Mon rôle est de defoncer l'adversaire"; 
    }

}
$mage = new Mage("Mage", "-2 vies", "Coup");
echo $mage->role(); 
echo "<br>";

$mage = new Mage ("Mage", "-2 vies", "Coup");
echo $mage->getNom() . '<br>';
echo $mage->getDegats(). '<br>';
echo $mage->getAction() . '<br>';
echo "<br>";



// PRETRE
class Pretre extends Personnage{
    public function role() {
        echo "Mon rôle est de guerir l'adversaire"; 
    }

}
$pretre = new Pretre("Pretre", "+1 vie", "Guerison");
echo $pretre->role(); 
echo "<br>";


$pretre = new Pretre ("Pretre", "+1 vie", "Guerison");
echo $pretre->getNom() . '<br>';
echo $pretre->getDegats(). '<br>';
echo $pretre->getAction() . '<br>';
echo "<br>";


// ARCHER
class Archer extends Personnage{
    public function role() {
        echo "Mon rôle est de defoncer l'adversaire"; 
    }

}
$archer = new Archer("Archer", "+1 vie", "Fleche");
echo $archer->role(); 
echo "<br>";


$archer = new Archer ("Archer", "+1 vie", "Fleche");
echo $archer->getNom() . '<br>';
echo $archer->getDegats(). '<br>';
echo $archer->getAction() . '<br>';
echo "<br>";
