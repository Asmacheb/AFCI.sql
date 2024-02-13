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
