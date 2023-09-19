<?php 
session_start();

if (isset($_GET['erreur']) && $_GET['erreur'] == 1) {
    $message = "nom d'utilisateur ou mot de passe incorrect "; 
} else {
    // connexion à la base de données
    $db_username = 'root';
    $db_password = '';
    $db_name = 'musicscool';
    $db_host = 'localhost';
    $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
        or die('could not connect to database');

    if (isset($_POST['validconnexion'])) {
        // TODO : cas de la connexion

        if(isset($_POST['login']) && isset($_POST['password'])) {

            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS
            $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['login'])); 
            $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));

                if($username !== "" && $password !== "") {
                $requete = "SELECT count(*) FROM utilisateur where 
                        nom = '".$username."' and motdepasse = '".$password."' ";
                $exec_requete = mysqli_query($db,$requete);
                $reponse = mysqli_fetch_array($exec_requete);
                $count = $reponse['count(*)'];
                
                    if($count!=0) { // nom d'utilisateur et mot de passe correctes
                    $_SESSION['nom'] = $username;
                    header('Location: index.php');
                    } else {
                    header('Location: inscription.php?erreur=1'); // utilisateur ou mot de passe incorrect
                    }

                } else {
                header('Location: index.php');
                }
            mysqli_close($db); // fermer la connexion
        } else {
            echo "vide";
        }
    } else if (isset($_POST['validinscription'])) {
        // cas de l'inscription
        // on teste l'existence de nos variables. On teste également si elles ne sont pas vides
        if ((isset($_POST['nom']) && !empty($_POST['nom'])) && (isset($_POST['password']) && !empty($_POST['password'] && (isset($_POST['email']))))) {
            // on recherche si ce nom est déjà utilisé par un autre membre
            $sql = 'SELECT count(*) FROM utilisateur WHERE nom="'.mysqli_escape_string($db, $_POST['nom']).'"' ;
            $req = mysqli_query($db, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
            $data = mysqli_fetch_array($req);

            if ($data[0] == 0) {
                $sql = 'INSERT INTO utilisateur VALUES(NULL , "'.mysqli_escape_string($db, $_POST['nom']).'", "'.mysqli_escape_string($db, $_POST['password']).'", "'.mysqli_escape_string($db, $_POST['email']).'")';
                mysqli_query($db, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error());

                $_SESSION['nom'] = $_POST['nom'];
                header('Location: index.php');
                exit();
            } else {
                $erreur = 'Un membre possède déjà ce nom.';
            }
        } else {
            $erreur = 'Au moins un des champs est vide.';
        }    
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>

<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container">
        <div class="login-container">
            <input id="item-1" type="radio" name="item" class="sign-in" ><label for="item-1" class="item">connexion</label>
            <input id="item-2" type="radio" name="item" class="sign-up" checked><label for="item-2" class="item">s'inscrire</label>
            <div class="login-form">
                <form action="accueil.html" method="post">
                <div class="sign-in-htm">
                    <div class="group">
                        <input placeholder="Nom d'utilisateur" id="user" type="text" class="input">
                    </div>
                    <div class="group">
                        <input placeholder="Mot de passe" id="pass" type="password" class="input" data-type="password">
                    </div>

                    <div class="group">
                        <button type="submit" class="button"  name="validconnexion">connexion</button>
                    </div>
                    <div class="hr"></div>
                    
                </div>
                </form>
                <form action="accueil." method="post">
                <div class="sign-up-htm">
                    <div class="group">
                        <input placeholder="Nom d'utilisateur" id="user" type="text" class="input">
                    </div>

                    <div class="group">
                        <input placeholder="adresse email" id="pass" type="text" class="input">
                    </div>

                    <div class="group">
                        <input placeholder="Mot de passe" id="pass" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <button type="submit" class="button"  name="validinscription">s'inscrire</button>
                    </div>
                    <div class="hr"></div>
                    <div class="footer">
                        <label href="login.php" for="item-1">vous avez déjà un compte?</a>
                        </form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>