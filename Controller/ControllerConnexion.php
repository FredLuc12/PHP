<?php

class ControllerConnexion
{
    private $pages;

    public function __construct()
    {
        $this->pages = isset($_GET['page']) ? $_GET['page'] : 'accueil';
        $this->handleRequest();
    }

    private function handleRequest()
    {
        switch ($this->pages) {
            case 'accueil':
                $this->includeView('accueil');
                break;

            case 'inscription':
                $this->includeView('inscription');
                break;

            case 'connexion':
                $this->includeView('connexion');
                if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                    $this->connexionVerif();
                }
                break;

            default:
                $this->includeView('accueil');
                break;
        }
    }

    private function includeView($page)
    {
        include 'views/' . $page . '.php';
    }

    private function connexionVerif(){
        if(isset($_POST["submit"])){
            if(!empty($_POST["email"]) and !empty($_POST["password"])){ //vérifie que le formulaire n'est pas vide et récupère les informations saisies
                $email = $_POST["email"];
                $password = $_POST["password"];
                $password= md5($password);
                $statement = $pdo->prepare("SELECT * FROM user WHERE mail = :email AND password = :password"); // récupère les informations depuis la bdd de l'utilisateur qui a ce mail et ce mot de passe
                $statement->execute([':email' => $email, ':password' => $password]);
                $result = $statement->fetch();
                if($result){
                    session_start();
                    $_SESSION["idu"] = $result["idu"];
                    $_SESSION["nom"] = $result["nom"];
                    $_SESSION["prenom"] = $result["prenom"];
                    header("location:index.php");
                }else{
                    $error = "Email ou mot de passe incorrect";
                }
            }else{
                $error = "Tous les champs doivent être remplis";
            }
        }
    }
}

// Instanciation de la classe Controller
$controllerConnexion = new ControllerConnexion();

?>