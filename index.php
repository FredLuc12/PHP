<?php

class Router
{
    private $pages;

    public function __construct()
    {
    
        $this->pages = [
            'accueil' => 'accueil.php',
            'connexion' => 'connexion.php',
            'inscription' => 'inscription.php',
            
        ];
    }

    public function matchRoute()
    {
        // Récupère le paramètre 'page' depuis l'URL, par exemple
        $page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

        // Vérifie si la page demandée existe dans la liste, sinon redirige vers la page d'accueil
        if (array_key_exists($page, $this->pages)) {
            include($this->pages[$page]);
        } else {
            include($this->pages['accueil']);
        }
    }
}

// Instanciez la classe Router et appelez la méthode route
$router = new Router();
$router->matchRoute();
?>
