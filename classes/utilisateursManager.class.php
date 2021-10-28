<?php

class utilisateursManager {

    //DECLARATIONS ET INSTANCIATIONS    
    private $bdd;  //Instance de PDO
    private $_result;
    private $_message;
    private $_utilisateurs; //Instance de utilisateurs 
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
    function get_utilisateurs() {
        return $this->_utilisateurs;
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
    function set_utilisateurs($_utilisateurs) {
        $this->_utilisateurs = $_utilisateurs;
    }
    function set_getLastInsertId($_getLastInsertId) {
        $this->_getLastInsertId = $_getLastInsertId;
    }

    public function get($id) {
        //Prépare une requête de type SELECT avec une clause WHERE

        $sql = 'SELECT * FROM utilisateurs WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //Execution de la requête avec attribution des valeurs 
        $req->bindValue( ':id', $id, PDO::PARAM_INT);
        $req->execute();

        //On stocke les données obetnues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
        //print_r2($utilisateurs);
        return $utilisateurs;

    }
    public function countutilisateursPublie() {
        $sql = "SELECT COUNT(*) as total FROM utilisateurs";
        $req = $this->bdd->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }
    
    public function getList($id){
        $sql = 'SELECT * FROM utilisateurs WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //Exécution de la requête avec attribution des valeurs aux
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        //On stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
        return $utilisateurs;
    }

    public function add (utilisateurs $utilisateurs) {
        $sql = 'INSERT INTO utilisateurs'.'(nom, prenom, email, mdp)'.'VALUES (:nom, :prenom, :email, :mdp)';
                    $req = $this->bdd->prepare($sql);

                    $req->bindValue(':nom', $utilisateurs->getNom(), PDO::PARAM_STR);
                    $req->bindValue(':prenom', $utilisateurs->getPrenom(), PDO::PARAM_STR);
                    $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
                    $req->bindValue(':mdp', $utilisateurs->getMdp(), PDO::PARAM_STR);


                    $req->execute();
                    if ($req->errorCode() == 00000) {
                        $this->_result = true;
                        $this->_getLastInsertId = $this->bdd->lastInsertId();
                    } else {
                        $this->_result = false;
                    }
                    return $this;
    }

    public function getByEmail($email){
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);

        return $utilisateurs;
    }

    public function getBySid($sid){
        $sql = "SELECT * FROM utilisateurs WHERE sid = :sid";
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':sid', $sid, PDO::PARAM_STR);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);

        return $utilisateurs;
    }

    public function updateByEmail(utilisateurs $utilisateurs){
        $sql = "UPDATE utilisateurs SET sid = :sid WHERE email = :email";
        $req = $this->bdd->prepare($sql);

        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue('sid', $utilisateurs->getSid(), PDO::PARAM_STR);

        $req->execute();
        if ($req->errorCode() == 00000){
            $this->_result = true;
        }else{
            $this->_result = false;
        }
        return $this;
    }




}