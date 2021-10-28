<?php  require_once 'config/init.conf.php'   ?>

<?php

                //print_r($_GET['id']);

                if(isset($_GET['id']))
                {
                    $idArticle=($_GET['id']);
                    $articlesManager = new articlesManager($bdd);
                    $a = $articlesManager->get($idArticle);
                }
                else{
                    echo "";
                }

                if (isset($_POST['submit'])) {

                
                $article = new articles();
                $article->hydrate($_POST);

                $article->setDate(date('Y-m-d'));


                $publie = $article->getPublie() === 'on' ? 1: 0;


                $article->setPublie($publie);
                
                
                $articlesManager = new articlesManager($bdd);
                if(empty($_POST['id'])){
                    $articlesManager->add($article);
                }else{
                    $articlesManager->update($article);
                }

                if ($_FILES["image"]['error'] == 0) {
                    $fileInfos = pathinfo($_FILES['image']['name']);
                    move_uploaded_file($_FILES['image']['tmp_name'], 'img/' .$articlesManager->get_getLastInsertId() . '.' . $fileInfos['extension']);
                }

                if ($articlesManager->get_result() == true) {
                    $_SESSION['notification']['result'] = 'success' ;
                    $_SESSION['notification']['message'] = 'Votre article a été ajouté' ;
                } else {
                    $_SESSION['notification']['result'] = 'danger' ;
                    $_SESSION['notification']['message'] = 'Une erreur est survenue ' ;
                }

                header("Location: index.php");
                exit();
               
            }else{

            

                ?>





<!DOCTYPE html>
<html lang="en">

    <?php include 'includes/header.inc.php';?>
    <body>
        <!-- Responsive navbar-->
        <?php include 'includes/nav.inc.php';?>
        <!-- Page Content-->
        <div class="container px-4 px-lg-5">
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">
                <div class="col-12">
                    <h1 class="font-weight-light"><?php echo "hello world" ?> </h1>
                    <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                    
                </div>
            </div>
            
            <!-- Formulaire -->
            
        <form enctype = "multipart/form-data" action="article.php" method="post">
            <div class="form-group">
                <?php if(isset($a)){?>
                    <label for="Titre">Titre</label>
                    <input type="text" name ="titre" class="form-control" id="Titre" aria-describedby="emailHelp" placeholder="Entrez un titre" value="<?= $a->getTitre()?>">
                <?php }else{ ?>
                    <label for="Titre">Titre</label>
                    <input type="text" name ="titre" class="form-control" id="Titre" aria-describedby="emailHelp" placeholder="Entrez un titre">  
                <?php } ?>
            </div>
            <div class="form-group">
                <?php if(isset($a)){?>
                    <label for="Texte">Texte</label>
                    <textarea class="form-control" name ="texte" id="Texte" rows="10" placeholder="Entrez un texte" ><?= $a->getTexte()?></textarea>
                <?php }else{ ?>
                    <label for="Texte">Texte</label>
                    <textarea class="form-control" name ="texte" id="Texte" rows="10" placeholder="Entrez un texte"></textarea>
                <?php } ?>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="Publie">
                <label class="form-check-label" name ="publie" for="Publie">Publier l'article ?</label>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Inserer une image</label>
                <input type="file" name ="image"class="form-control-file" id="exampleFormControlFile1">
            </div>
                <button type="submit" name="submit" class="btn btn-primary">Envoyer</button>
                <?php if(isset($a)){?>
                <input type="hidden" name="id" value="<?= $a->getId()?>">
                <?php }else{}?>
            </form>

            










        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2021</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>

<?php 

                } 

                ?>