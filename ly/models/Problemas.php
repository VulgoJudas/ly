<?php
namespace models;

class Problemas{
    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    }

    public function insertMensage($id_user,$msg){
        $sql=$this->pdo->prepare("INSERT INTO problemas SET id_user=:id_user,msg=:msg,data=NOW()");
        $sql->bindValue(':id_user',$id_user);
        $sql->bindValue(':msg',$msg);
        $sql->execute();

        return true;
    }

    public function getReclamações(){
        $array=array();

        $sql=$this->pdo->query("SELECT problemas.msg,problemas.data,(select nome from users where users.id=problemas.id_user) as nomeUser FROM problemas ORDER BY data DESC LIMIT 3");

        if($sql->rowCount()>0){
            $array=$sql->fetchAll();
        }

        return $array;
    }
}