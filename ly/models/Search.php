<?php
namespace models;

class Search{
    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    }

    public function getSearch($dados){
        $array=array();

        $sql=$this->pdo->prepare("SELECT id,titulo,foto FROM noticias WHERE titulo LIKE :titulo LIMIT 10");
        $sql->bindValue(':titulo','%'.$dados.'%');
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

}
