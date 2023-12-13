<?php

class ControllerInscription
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
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->create();
                }
                break;

            case 'connexion':
                $this->includeView('connexion');
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

    private function create()
    {
        // Logique de création
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
        $numVoie = isset($_POST['numVoie']) ? $_POST['numVoie'] : '';
        $adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
        $codePostal = isset($_POST['codePostal']) ? $_POST['codePostal'] : '';
        $ville = isset($_POST['ville']) ? $_POST['ville'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $password2 = isset($_POST['password2']) ? $_POST['password'] : '';

        // Validation des données (ajoutez vos propres règles de validation)
        $this->saveUserToDatabase($nom, $prenom, $email, $telephone, $numVoie, $adresse,
        $codePostal, $ville, $password);
    }

    private function saveUserToDatabase($nom, $prenom, $email, $telephone, $numVoie, $adresse,
    $codePostal, $ville, $password)
    {
        if(isset($_POST['submit']))
        {
            if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['numVoie']) && !empty($_POST['adresse']) && !empty($_POST['ville']) && !empty($_POST['codePostal']) && !empty($_POST['telephone'])) //vérifie si le formulaire n'est pas vide et récupère toutes les informations saisies par l'utilisateur dans le formulaire
            {
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                $numVoie = $_POST['numVoie'];
                $adresse = $_POST['adresse'];
                $ville = $_POST['ville'];
                $codePostal = $_POST['codePostal'];
                $telephone = $_POST['telephone'];
                    if($password == $password2){ //vérifie que le mdp saisi ets le même que celui de confirmation
                        if(strlen($password) >= 10){ //vérifie la longueur du mdp
                            $password = md5($password); //crypte le mdp
                            $statement = $pdo->prepare("SELECT * FROM user WHERE mail = :email"); //récupère les infos de l'utiisateur qui a créée un compte avec cette adresse mail pour vérifier si elle est dejà utilisée ou non
                            $statement->bindValue(':email', $email, PDO::PARAM_STR);
                            $statement->execute();
                            $result = $statement->fetch(PDO::FETCH_ASSOC);
                            if(!$result){
                                $statement = $pdo->prepare("INSERT INTO user VALUES (null,:nom,:prenom,:email,:telephone,:password,:numVoie,:ville,:codePostal,null,0)"); // si l'adresse mail n'est pas utilisé, requêt qui permet d'insérer les données saisies dans la bdd
                                $statement->execute([
                                    ':nom' => $nom,
                                    ':prenom' => $prenom,
                                    ':email' => $email,
                                    ':telephone' => $telephone,
                                    ':password' => $password,
                                    ':numVoie' => $numVoie,
                                    ':adresse' => $adresse,
                                    ':ville' => $ville,
                                    ':codePostal' => $codePostal
                                ]);
                                session_start();
                                $_SESSION['inscription'] = "ok";
                            header("location:connexion.php");
                            }else{
                                $error = "Cet email est déjà utilisé";
                            }
                        }else{
                            $error = "Le mot de passe doit contenir au moins 10 caractères";
                        }

                    }else{
                        $error = "Les mots de passe ne correspondent pas";
                    }
                }else{
                    $error = "Tous les champs doivent être remplis";
                }
        }
    }

}

// Instanciation de la classe Controller
$controllerInscription = new ControllerInscription();

?>

