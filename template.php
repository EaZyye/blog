<?php  

    require_once 'config/init.conf.php';
    require_once 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('templates/');
    $twig = new \Twig\Environnement($loader, ['debug'=>true]);

    $users = [['username' => 'momo']];
    echo $twig->render('template.html.twig',['prenom' => 'morgan', 'go' => 'here', 'users' => $users]);