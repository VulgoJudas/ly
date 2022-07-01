<?php
namespace models;

class Jornal{
    private $pdo;
    public function __construct(\PDO $pdo){
        $this->pdo=$pdo;
    } 
    
    
    
    public function jornalExist($jornalName){
        $array=array();
        $sql=$this->pdo->prepare("SELECT * FROM telejornais WHERE nome=:nome");
        $sql->bindValue(':nome',$jornalName);
        $sql->execute();

        if($sql->rowCount()>0){

            return  true;
        }

        return false;
    }

    public function insert($jornalName){
        $id_user=$_SESSION['login'];
        $sql=$this->pdo->prepare("INSERT INTO telejornais SET nome=:nome,id_dono_jornal=:id_dono_jornal");
        $sql->bindValue(':nome',$jornalName);
        $sql->bindValue(':id_dono_jornal',$id_user);
        $sql->execute();

        return true;
    }

    public function getJornaisMy(){
        $array=array();
        $id_user=$_SESSION['login'];
        $sql=$this->pdo->prepare("SELECT * FROM telejornais WHERE id_dono_jornal=:id_dono_jornal");
        $sql->bindValue(':id_dono_jornal',$id_user);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetchAll();
        }

        return $array;
    }

    public function getJornaisMembro(){
        $id_user=$_SESSION['login'];
        $array=array();

        $sql=$this->pdo->prepare("SELECT jornal_membro.*,(select nome from telejornais where id=id_jornal) as nome FROM jornal_membro WHERE id_user=:id_user AND situacao=1");
        $sql->bindValue(':id_user',$id_user);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetchAll();
        }

        return $array;

    }

    public function deleteJornal($id_jornal){
        $id_user=$_SESSION['login'];

        $sql=$this->pdo->prepare("DELETE FROM jornal_membro WHERE id_jornal=:id_jornal");
        $sql->bindValue(':id_jornal',$id_jornal);
        $sql->execute();

        $sql=$this->pdo->prepare("DELETE FROM telejornais WHERE id=:id AND id_dono_jornal=:id_dono_jornal");
        $sql->bindValue(':id',$id_jornal);
        $sql->bindValue(':id_dono_jornal',$id_user);
        $sql->execute();


        return true;
    }

    public function sairDoJornal($id_sair){
        $id_user=$_SESSION['login'];

        $sql=$this->pdo->prepare("DELETE FROM jornal_membro WHERE id_user=:id_user AND id_jornal=:id_jornal");
        $sql->bindValue(':id_user',$id_user);
        $sql->bindValue(':id_jornal',$id_sair);
        $sql->execute();


        return true;
    }

    public function jornaisSolicitar(){
        $id_user=$_SESSION['login'];
        $array=[];
        
        $sql=$this->pdo->query("SELECT id FROM telejornais WHERE id_dono_jornal!='$id_user'");
        if($sql->rowCount()>0){
            $item=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        
        foreach($item as $itemk=>$itemv){
            $sql=$this->pdo->prepare("SELECT jornal_membro.id_jornal,telejornais.id,telejornais.nome FROM jornal_membro LEFT JOIN telejornais ON telejornais.id=jornal_membro.id_jornal WHERE jornal_membro.id_user=:id_user AND jornal_membro.id_jornal=:id_jornal AND jornal_membro.situacao=0");
            $sql->bindValue(':id_user',$id_user);
            $sql->bindValue(':id_jornal',$itemv['id']);
            $sql->execute();

            if($sql->rowCount()>0){
                $array[]=$sql->fetchAll(\PDO::FETCH_ASSOC);
            }else{
                unset($item[$itemk]);
            }
        }


        return $array;
    }

    public function jornaisEnviarSolicitacao(){
        $id_user=$_SESSION['login'];
        $array=[];
        $info=[];

       $sql=$this->pdo->query("SELECT id FROM telejornais WHERE id_dono_jornal !='$id_user'");

       if($sql->rowCount()>0){
            $item=$sql->fetchAll(\PDO::FETCH_ASSOC);
            foreach($item as $ik=>$iv){
                $valor=$iv;
                $sql=$this->pdo->prepare("SELECT * FROM jornal_membro WHERE id_user=:id_user AND id_jornal=:id_jornal");
                $sql->bindValue(':id_user',$id_user);
                $sql->bindValue(':id_jornal',$valor['id']);
                $sql->execute();

                if($sql->rowCount()>0){
                    unset($item[$ik]);
                }
                
            }
            
            foreach($item as $itemk=>$itemv){
                $valor=$itemv;
                $sql=$this->pdo->prepare("SELECT id,nome FROM telejornais WHERE id=:id");
                $sql->bindValue(':id',$valor['id']);
                $sql->execute();

                if($sql->rowCount()>0){
                    $info[]=$sql->fetch(\PDO::FETCH_ASSOC);
                }
                

            }
            
            
        }
        if(count($info)>0){
            $array[]=$info;
        }

       

        return $array;
    }

    public function cancelarSolicitacao($cancelarSolicitacao){
        $id_user=$_SESSION['login'];
        $sql=$this->pdo->prepare("DELETE FROM jornal_membro WHERE id_user=:id_user AND id_jornal=:id_jornal AND situacao=0");
        $sql->bindValue(':id_user',$id_user);
        $sql->bindValue(':id_jornal',$cancelarSolicitacao);
        $sql->execute();

        return true;

    }

    public function pedirParaEntrar($pedirParaEntrar){
        $id_user=$_SESSION['login'];
        $sql=$this->pdo->prepare("INSERT INTO jornal_membro SET id_user=:id_user,id_jornal=:id_jornal,situacao=0");
        $sql->bindValue(':id_user',$id_user);
        $sql->bindValue(':id_jornal',$pedirParaEntrar);
        $sql->execute();

        return true;
    }

    public function getInfoJornal($id){
        $id_user=$_SESSION['login'];
        $info=[];

        if(!empty($id) && intval($id)){
            if($info=$this->jornalIsMy($id_user,$id)){
                $info[]=$this->getMembrosJornal($info['id']);
                $info[]=$this->getSolicitações($info['id']);
               
                return $info;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function id_aceitarMembro($id_aceitarMembro,$id_grupo){
        $sql=$this->pdo->prepare("UPDATE jornal_membro SET situacao=1 WHERE id_user=:id_user AND id_jornal=:id_jornal");
        $sql->bindValue(':id_user',$id_aceitarMembro);
        $sql->bindValue(':id_jornal',$id_grupo);
        $sql->execute();

        return true;
    }

    public function id_expulsarMembro($id_expulsarMembro,$id_grupo){
        $sql=$this->pdo->prepare("DELETE FROM jornal_membro WHERE id_user=:id_user AND id_jornal=:id_jornal");
        $sql->bindValue(':id_user',$id_expulsarMembro);
        $sql->bindValue(':id_jornal',$id_grupo);
        $sql->execute();

        return true;
    }

    private function jornalIsMy($id_user,$id_jornal){
        $array=[];
        $sql=$this->pdo->prepare("SELECT id,nome FROM telejornais WHERE id=:id AND id_dono_jornal=:id_dono_jornal");
        $sql->bindValue(':id',$id_jornal);
        $sql->bindValue(':id_dono_jornal',$id_user);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetch(\PDO::FETCH_ASSOC);

            return $array;
        }else{
            return false;
        }
    }

    private function getMembrosJornal($id_jornal){
        $array=[];

        $sql=$this->pdo->prepare("SELECT jornal_membro.situacao,users.id,users.nome,users.email FROM jornal_membro LEFT JOIN users ON users.id=jornal_membro.id_user WHERE jornal_membro.id_jornal=:id_jornal AND jornal_membro.situacao=1");
        $sql->bindValue(':id_jornal',$id_jornal);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

    private function getSolicitações($id_jornal){
        $array=[];

        $sql=$this->pdo->prepare("SELECT jornal_membro.situacao,users.id,users.nome,users.email FROM jornal_membro LEFT JOIN users ON users.id=jornal_membro.id_user WHERE jornal_membro.id_jornal=:id_jornal AND jornal_membro.situacao=0");
        $sql->bindValue(':id_jornal',$id_jornal);
        $sql->execute();

        if($sql->rowCount()>0){
            $array=$sql->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $array;
    }

}