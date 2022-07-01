<?php
namespace models;

class Users{
    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    }

    public function getInfoUserLogged($id){
        $array=array();
        $sql=$this->pdo->prepare("SELECT * FROM users WHERE id=:id");
        $sql->bindValue(':id',$id);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetch(\PDO::FETCH_ASSOC);
        }

        return $array;
    }


    public function emailExist($email){
        $array=array();
        $sql=$this->pdo->prepare("SELECT * FROM users WHERE email=:email");
        $sql->bindValue(':email',$email);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetch(\PDO::FETCH_ASSOC);
            $this->userInfo=$array;
            return $array;
        }

        return false;
    }

    public function insert($newNome,$email,$newSenha,$newData){
        $newNome=implode(' ',$newNome);
        
        $sql=$this->pdo->prepare("INSERT INTO users SET nome=:nome,email=:email,senha=:senha,data_nascimento=:data_nascimento");
        $sql->bindValue(':nome',$newNome);
        $sql->bindValue(':email',$email);
        $sql->bindValue(':senha',$newSenha);
        $sql->bindValue(':data_nascimento',$newData);
        $sql->execute();
        $id=$this->pdo->lastInsertId();

        $_SESSION['login']=$id;

        return true;
    }

    public function getInfoUserNoticia($id_user){
        $array=[];

        $sql=$this->pdo->prepare("SELECT users.nome,users.email,noticias.id,noticias.titulo,noticias.data_noticia,noticias.foto FROM users LEFT JOIN noticias ON noticias.id_user=users.id WHERE  users.id=:id ORDER BY noticias.id DESC");
        $sql->bindValue(':id',$id_user);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetch(\PDO::FETCH_ASSOC);
        }


        return $array;
    }
}