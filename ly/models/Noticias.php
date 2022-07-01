<?php
namespace models;

class Noticias{
    private $pdo;

    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    }

    public function getTipos(){
        $array=[];
        $sql=$this->pdo->query("SELECT * FROM tipos_noticias");

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getRegiao(){
        $array=[];
        $sql=$this->pdo->query("SELECT * FROM regiao");

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getJornais($id_user){
        $array=[];
        $info=[];

        $sql=$this->pdo->prepare("SELECT id_jornal FROM jornal_membro WHERE id_user=:id_user AND situacao=1");
        $sql->bindValue(':id_user',$id_user);
        $sql->execute();

        if($sql->rowCount()>0){
            $info=$sql->fetchAll(\PDO::FETCH_ASSOC);

            foreach($info as $id){
                $sql=$this->pdo->prepare("SELECT id,nome FROM telejornais WHERE id=:id");
                $sql->bindValue(':id',$id['id_jornal']);
                $sql->execute();
                
                if($sql->rowCount()>0){
                    $array[]=$sql->fetchAll(\PDO::FETCH_ASSOC);
                }
                
            }

            $sql=$this->pdo->prepare("SELECT id,nome FROM telejornais WHERE id_dono_jornal=:id_dono_jornal");
            $sql->bindValue(':id_dono_jornal',$id_user);
            $sql->execute();

            if($sql->rowCount()>0){
                $array[]=$sql->fetchAll(\PDO::FETCH_ASSOC);
            }
            
        }else{
            $sql=$this->pdo->prepare("SELECT id,nome FROM telejornais WHERE id_dono_jornal=:id_dono_jornal");
            $sql->bindValue(':id_dono_jornal',$id_user);
            $sql->execute();

            if($sql->rowCount()>0){
                $array[]=$sql->fetchAll(\PDO::FETCH_ASSOC);
            }
        }
        

        

        return $array;
    }

    public function insertNoticia($id_user,$titulo,$texto,$foto,$tipo,$regiao,$jornal){
        $arrayTipos=['image/jpeg','image/jpg','image/png'];

        if(in_array($foto['type'],$arrayTipos)){
            
            $newNome=md5(time().rand(0,999));

            switch($foto['type']){
                case 'image/jpeg':
                    $newNome=$newNome.'.jpeg';
                break;
                case 'image/jpg':
                    $newNome=$newNome.'.jpg';
                break;
                case 'image/png':
                    $newNome=$newNome.'.png';
                break;
            }

            move_uploaded_file($foto['tmp_name'],"../assets/fotos/".$newNome);

            $sql=$this->pdo->prepare("INSERT INTO noticias SET id_user=:id_user,titulo=:titulo,corpo=:corpo,data_noticia=NOW(),id_tipo=:id_tipo,id_jornal=:id_jornal,foto=:foto,id_estado=:id_estado");
            $sql->bindValue(':id_user',$id_user);
            $sql->bindValue(':titulo',$titulo);
            $sql->bindValue(':corpo',$texto);
            $sql->bindValue(':id_tipo',$tipo);
            $sql->bindValue(':id_jornal',$jornal);
            $sql->bindValue(':foto',$newNome);
            $sql->bindValue(':id_estado',$regiao);
            $sql->execute();

            return true;



        }else{
            return false;
        }
    }

    public function getUltimasNoticias(){
        $array=[];

        $sql=$this->pdo->query("SELECT * FROM noticias ORDER BY id DESC LIMIT 10");
        
        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getNoticia($id_noticia){
        $array=[];

        $sql=$this->pdo->prepare("SELECT noticias.titulo,noticias.corpo,noticias.foto,noticias.data_noticia,tipos_noticias.name,(select users.nome from users where users.id=noticias.id_user) as nome_user FROM noticias LEFT JOIN tipos_noticias ON tipos_noticias.id=noticias.id_tipo WHERE noticias.id=:id");
        $sql->bindValue(':id',$id_noticia);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetch(\PDO::FETCH_ASSOC);
        }


        return $array;
    }

    public function getNoticiasRand(){
        $array=[];

        $sql=$this->pdo->query("SELECT id,titulo,foto,data_noticia FROM noticias ORDER BY RAND() LIMIT 10");

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }
}