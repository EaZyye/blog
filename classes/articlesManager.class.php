<?php

class articlesManager {

    //DECLARATIONS ET INSTANCIATIONS    
    private $bdd;  //Instance de PDO
    private $_result;
    private $_message;
    private $_article; //Instance de article 
    private $_getLastInsertId;
    
    public function __construct (PDO $bdd){
        $this->setBdd($bdd);
    }

    function getBdd() {
        return $this->bdd;
    }
    function get_result() {
        return $this->_result;
    }
    function get_message() {
        return $this->_message;
    }
    function get_article() {
        return $this->_article;
    }
    function get_getLastInsertId() {
        return $this->_getLastInsertId;
    }
    function setBdd($bdd) {
        $this->bdd = $bdd;
    }
    function set_result($_result) {
        $this->_result = $_result;
    }
    function set_message($_message) {
        $this->_message = $_message;
    }
    function set_article($_article) {
        $this->_article = $_article;
    }
    function set_getLastInsertId($_getLastInsertId) {
        $this->_getLastInsertId = $_getLastInsertId;
    }

    public function get($id) {
        //Prépare une requête de type SELECT avec une clause WHERE

        $sql = 'SELECT * FROM articles WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //Execution de la requête avec attribution des valeurs 
        $req->bindValue( ':id', $id, PDO::PARAM_INT);
        $req->execute();

        //On stocke les données obetnues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $articles = new articles();
        $articles->hydrate($donnees);
        //print_r2($article);
        return $articles;

    }
    public function countArticlesPublie() {
        $sql = "SELECT COUNT(*) as total FROM articles";
        $req = $this->bdd->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }
    
    public function getList($depart, $limit) {

        $listArticle = [];
        //Prépare une requête de type SELECT avec une clause WHERE

        $sql = 'SELECT id, ' .'titre, ' .'texte, ' .'publie, '.'DATE_FORMAT(date, "%d/%m/%Y") as date ' .'FROM articles' .' LIMIT :depart, :limit';
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);

        //Execution de la requête avec attribution des valeurs 
        $req->execute();
        //On stocke les données obetnues dans un tableau
        
        //On stocke les données obtenues dans un tableau 
        while ($donnees = $req->fetch (PDO::FETCH_ASSOC)){
            //on créé des objets avec les données issues 
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }
        
        //print_r2($listArticle);
        return $listArticle;

    }

    public function add (articles $articles) {
        $sql = 'INSERT INTO articles'.'(titre, texte, publie, date)'.'VALUES (:titre, :texte, :publie, :date)';
                    $req = $this->bdd->prepare($sql);

                    $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
                    $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
                    $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_INT);
                    $req->bindValue(':date', $articles->getDate(), PDO::PARAM_STR);


                    $req->execute();
                    if ($req->errorCode() == 00000) {
                        $this->_result = true;
                        $this->_getLastInsertId = $this->bdd->lastInsertId();
                    } else {
                        $this->_result = false;
                    }
                    return $this;
    }

    public function update(articles $articles) {
        $sql = "UPDATE articles SET " . "titre = :titre," . "texte = :texte," . "publie = :publie" . " WHERE id = :id";
        $req = $this->bdd->prepare($sql);

        // Sécurisation des variables
        $req->bindValue(':titre', $articles->getTitre(), PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte(), PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie(), PDO::PARAM_STR);
        $req->bindValue(':id', $articles->getId(), PDO::PARAM_STR);

        // Exécution de la requête
        $req->execute();
        if($req->errorCode()== 00000) {
            $this->_result = true;
        }

        else {
            $this->_result = false;
        }
        return $this;
    }






}