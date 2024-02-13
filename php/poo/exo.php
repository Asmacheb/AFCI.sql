
<!-- EXERCICE -->

<!-- Créer une classe de personnage avec comme attributs une taille, sexe, couleur de cheveux.

Créer plusieurs classe qui vont extendre de la classe personnage. Ce seront des enfants. Créer une classe Mecanicien, Developpeur, Pilote d'avion.

Chacun de ces classes enfants auront des particularités
Classe Mécanien :
function qui va affiche "Mon rôle est de réparer des voitures"

Classe Développeur :
function qui va afficher "je suis développeur fullstack"

Classe Pilote : 
Tous les pilotes sont chauves. Il faudra donc remplacer le résultat de la variable de couleur de cheveux


Et ensuite, 2 nouvelles classes vont venir extends la classe développeur :

Une classe développeur Front end qui va remplacer la function qui afficher "je suis développeur fullstack" par "je suis développeur frontend"


Une classe développeur Backend end qui va remplacer la function qui affiche "je suis développeur fullstack" par "j'aime la base de données" 

-->

<?php

class Personnage{
    // Attributs
    public $taille;
    public $sexe;
    public $couleurCheveux;
 
    public function __construct($taille,$sexe,$couleurCheveux){
        $this->taille = $taille;
        $this->sexe = $sexe;
        $this->couleurCheveux = $couleurCheveux;  
}

     // Getters
     public function getTaille(){
        return $this->taille;
    }
    public function getSexe(){
        return $this->sexe;
    }
    public function getCouleurCheveux(){
        return $this->couleurCheveux;
    }

     // Setters

    public function setTaille(){
        return $this->taille;
    }
    public function setSexe(){
        return $this->sexe;
    }
    public function setCouleurCheveux(){
        return $this->couleurCheveux;
    }
}

class Mecanicien extends Personnage{
    public function role() {
        echo "Mon rôle est de réparer des voitures"; 
    }

}
$mecanicien = new Mecanicien(1.87, "homme", "brun");
echo $mecanicien->role(); 
echo "<br>";


class Developper extends Personnage{
    public function role() {
        echo "Je suis développeur fullstack";
    }
}

$developper = new Developper(1.77, "femme", "blonde");
echo $developper->role(); 
echo "<br>";


class Pilote extends Personnage{
    public function __construct($taille, $sexe) {
        // Tous les pilotes sont chauves
        parent::__construct($taille, $sexe, "chauve");
    }
}

$pilote = new Pilote(1.57, "homme");
echo "Taille: " . $pilote->taille . ", Sexe: " . $pilote->sexe . ", Couleur des cheveux: " . $pilote->couleurCheveux; 
echo "<br>";

class DevelopperFrontend extends Developper{

    public function role() {
        echo "Je suis développeur frontend";
    }
}

$developperFrontend = new DevelopperFrontend(1.77, "femme", "blonde");
echo $developperFrontend->role();
echo "<br>";

  
class DevelopperBackend extends Developper{

    public function role() {
        echo "j'aime la base de données";
    }
}
echo $developperBackend->role();
echo "<br>";
?>