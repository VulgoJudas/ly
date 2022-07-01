<?php
namespace models;

class Telejornais{
    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    }

    public function getTelejornais(){
        $array=[];

        $sql=$this->pdo->query("SELECT id,nome FROM telejornais ORDER BY RAND() LIMIT 5");

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getNoticiasJornal($id){
        $array=[];

       $sql=$this->pdo->prepare("SELECT telejornais.nome,noticias.id,noticias.foto,noticias.titulo,noticias.data_noticia FROM telejornais LEFT JOIN noticias ON noticias.id_jornal=telejornais.id WHERE telejornais.id=:id LIMIT 10");
       $sql->bindValue(':id',$id);
       $sql->execute();

       if($sql->rowCount()>0){
        $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
       }


       return $array;
    }

}