<?php

// Liste des pages autorisées et leurs fichiers correspondants
$pages = [
    'accueil' => 'accueil.php',
    'connexion' => 'connexion.php',
    'inscription' => 'inscription.php',
    // Ajoutez d'autres pages au besoin
];


// Récupère le paramètre 'page' depuis l'URL, par exemple, localhost/router.php?page=connexion
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Vérifie si la page demandée existe dans la liste, sinon redirige vers la page d'accueil
if (array_key_exists($page, $pages)) {
    include($pages[$page]);
} else {
    include($pages['accueil']);
}
?>

<?php 


class Router  {

    public function Roue()
    {
        return $this->executeQuery("SELECT * FROM `pages`"); 
    }
        
    public function calculeSolde()
    {
        $depenses = $this->executeQuery("SELECT * FROM `pages`");
        $total = 0;

        if($depenses){
            foreach($depenses as $depense){
                if($depense['debite'] == 1){
                    $total -= $depense['prix'];
                }else{
                    $total += $depense['prix'];
                }
            }
        }
        $total = intval($total);
        return $total;
    }

