
<?php  require_once 'config/init.conf.php';
       require_once 'config/bdd.conf.php';

                if (isset($_POST['submit'])) {

                
                $utilisateurs = new utilisateurs();
                $utilisateurs->hydrate($_POST);

                $utilisateursManager = new utilisateursManager($bdd);

    $utilisateursManager->add($utilisateurs);

    if($utilisateursManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Votre compte a été ajouté.';
    } else {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = 'Une erreur est survenue';
    }

    header("Location: index.php");

    }else {
        $utilisateurs = new utilisateurs();
        $action = 'ajouter';
    }
?>


<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Formulaire de Création d'Utilisateurs</title>
  <link rel="stylesheet" href="css/styleform.css">
  <script src="script.js"></script>
</head>
<body>
  
<form enctype = "multipart/form-data" action="form.connect.php" method="post">
    <h1> Creation de votre compte ! </h1>
    <div>
        <label for="name">NOM :</label>
        <input type="text" id="name" name="nom">
    </div>
    <br>
    <div>
        <label for="Prenom">PRÉNOM :</label>
        <input type="text" id="prenom" name="prenom">
    </div>
    <br>
    <div>
        <label for="mail">E-MAIL :</label>
        <input type="email" id="mail" name="email">
    </div>
    <br>
    <div>
        <label for="mdp">MOT DE PASSE :</label>
        <input type="password" id="mdp" name="mdp">
    </div>
    <br>
    <button id="submit" type="submit" name="submit" class="btn btn-primary">Créer mon compte utilisateur</button>

</form>
  
</body>
</html>