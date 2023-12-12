<?php



// Récupère le paramètre 'page' depuis l'URL, par exemple, localhost/router.php?page=connexion
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Inclut les fichiers nécessaires en fonction de la page demandée
switch ($page) {
    case 'connexion':
        include('connexion.php');
        break;

    case 'inscription':
        include('inscription.php');
        break;

    default:
        // Redirection vers la page d'accueil si le paramètre 'page' est inconnu
        include('accueil.php');
        break;
}
?>
