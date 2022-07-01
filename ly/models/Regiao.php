<?php
namespace models;

class Regiao{
    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    }

    public function getRegiao(){
        $array=[];

        $sql=$this->pdo->query("SELECT id,nome FROM regiao");

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function getRegiaoNoticias($id){
        $array=[];

       $sql=$this->pdo->prepare("SELECT regiao.nome,noticias.id,noticias.foto,noticias.titulo,noticias.data_noticia FROM regiao LEFT JOIN noticias ON noticias.id_estado=regiao.id WHERE regiao.id=:id LIMIT 10");
       $sql->bindValue(':id',$id);
       $sql->execute();

       if($sql->rowCount()>0){
        $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
       }


       return $array;
    }

    

}