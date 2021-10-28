

<?php  require_once 'config/init.conf.php';
       require_once 'config/bdd.conf.php';

       if(isset($_POST['submit'])){
       
           $utilisateurs = new utilisateurs();
           $utilisateurs->hydrate($_POST);
       
           $utilisateursManager = new utilisateursManager($bdd);
           $utilisateursEnBdd = $utilisateursManager->getByEmail($utilisateurs->getEmail());
       
           $isConnect = password_verify($utilisateurs->getMdp(), $utilisateursEnBdd->getMdp());
       
           if ($isConnect == true){
               $sid = md5($utilisateurs->getEmail() . time());
               setCookie('sid', $sid, time() + 86400);
               $utilisateurs->setSid($sid);
               $utilisateursManager->updateByEmail($utilisateurs);
           }
       
            $pass1 = $utilisateurs->getMdp();
            $pass2 = $utilisateursEnBdd->getMdp();
            if($pass1==$pass2) {
                $_SESSION['notification']['result'] = 'success';
                $_SESSION['notification']['message'] = 'Vous êtes connecté.';
                 header("Location: index.php");
            } else {
                $_SESSION['notification']['result'] = 'danger';
                $_SESSION['notification']['message'] = 'Une erreur est survenue';
                header("Location: form.connection.php");
           }
       
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
  
<form enctype = "multipart/form-data" action="form.connection.php" method="post">
    <h1> Connectez-vous ! </h1>
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
    <button id="submit" type="submit" name="submit" class="btn btn-primary">Connection</button>

</form>
  
</body>
</html>