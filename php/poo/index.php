<?php 
class Vehicule{
    // ATTRIBUT
    public $nombreDeRoues;
    public $couleur;
    public $annee;
    public $marque;

    public function __construct($nombreDeRoues,$couleur,$annee,$marque){
        $this->nombreDeRoues = $nombreDeRoues;
        $this->couleur = $couleur;
        $this->annee = $annee;
        $this->marque = $marque;
    }
    // Getters
    public function getnombreDeRoues(){
        return $this->nombreDeRoues;
    }
    public function getCouleur(){
        return $this->couleur;
    }
    public function getAnnee(){
        return $this->annee;
    }
    public function getMarque(){
        return $this->marque;
    }

    // Setters
    public function setnombreDeRoues($nombreDeRoues){
        return $this->nombreDeRoues = $nombreDeRoues;
    }
    public function setCouleur($couleur){
        return $this->couleur = $couleur;
    }
    public function setAnnee($annee){
        return $this->annee = $annee;
    }
    public function setMarque($marque){
        return $this->marque = $marque;
    }
  

    //METHOD

    public function concatenation() {
       "Nombre de roues: " . $this->nombreDeRoues . ", Couleur: " . $this->couleur . ", Année: " . $this->annee . ", Marque: " . $this->marque ;
    }
}
?>

<h1>Voiture</h1><br>
<?php 

$voiture = new Vehicule(4, "violet", 2009, "Renault");
echo $voiture->annee . "<br>";
$voiture->annee = $voiture->annee + 22;
echo $voiture->getAnnee() . "<br>";
echo $voiture->marque . "<br>";
echo $voiture->couleur . "<br>";
echo $voiture-> nombreDeRoues . "<br>";
echo $voiture->concatenation() . "<br>";

?>
<h1>Moto</h1><br>
<?php 
$moto= new Vehicule(2, "jaune", 2023, "Yamaha");
echo $moto->annee . "<br>";
echo $moto->marque . "<br>";
$moto->marque = $moto->marque .'/Honda';
echo $moto->getMarque() . "<br>";
echo $moto->couleur . "<br>";
echo $moto-> nombreDeRoues . "<br>";


?>

<!-- //CORRECTION -->

<?php

class Vehicul{
    // Attributs
    public $nombreDeRoues;
    public $couleur;
    public $annee;
    public $marque;

    // Constructor

    public function __construct($nombreDeRoues, $couleur, $annee, $marque) {
        $this->nombreDeRoues = $nombreDeRoues;
        $this->couleur = $couleur;
        $this->annee = $annee;
        $this->marque = $marque;
    }

    // Getters
    public function getNombreDeRoues(){
        return $this->nombreDeRoues;
    }
    public function getCouleur(){
        return $this->couleur;
    }
    public function getAnnee(){
        return $this->annee;
    }
    public function getMarque(){
        return $this->marque;
    }
    // Setters
    public function setNombreDeRoues($nombreDeRoues){
        $this->nombreDeRoues = $nombreDeRoues;
    }
    public function setCouleur($couleur){
        return $this->couleur = $couleur;
    }
    public function setAnnee($annee){
        return $this->annee = $annee;
    }
    public function setMarque($marque){
        return $this->marque = $marque;
    }
    
    // Méthode

    public function conc(){
        return "Nombre de roues : " . $this->nombreDeRoues . ". Couleur : " . $this->getCouleur() . ". Année : " . $this->getAnnee() . ". Marque : " . $this->getMarque() . ".";
    }
}


$voiture = new Vehicul(4, "violet", 2009, "Renault");
$voiture->setAnnee(2022);
echo $voiture->getAnnee() . "<br>";
echo $voiture->conc() . "<br>";

// $voiture = new Vehicule(4, "violet", 2009, "Renault");
// $voiture->setAnnee($voiture->getAnnee() + 22);
// echo $voiture->getAnnee();

// $moto = new Vehicule(2, "jaune", 2023, "Yahama");
// $moto->setMarque("Yahama / Honda");
// echo $moto->getMarque();

$moto = new Vehicul(2, "jaune", 2023, "Yahama");
$moto->setMarque($moto->getMarque() . "/ Honda");
echo $moto->getMarque() . "<br>";
echo $moto->conc() . "<br>";
echo "<br>";
?>

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