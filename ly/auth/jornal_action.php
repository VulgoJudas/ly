<?php
require_once "../db/config.php";
require_once "../models/Jornal.php";
use models\Jornal;

$jornal=new Jornal($pdo);

$jornalNome=filter_input(INPUT_POST,'jornalName');


if(!empty($_GET['id_grupo']) && !empty($_GET['id_expulsarMembro'])){
    $id_expulsarMembro=$_GET['id_expulsarMembro'];
    $id_grupo=$_GET['id_grupo'];
    
    if(intval($id_expulsarMembro) && intval($id_grupo)){
        $jornal->id_expulsarMembro($id_expulsarMembro,$id_grupo);
        
        header("Location:".BASE."visualizar_grupo.php?id=".$id_grupo);
        exit; 
    }else{
        header("Location:".BASE."jornal.php");
        exit; 
    }
}

if(!empty($_GET['id_grupo']) && !empty($_GET['id_aceitarMembro'])){
    $id_aceitarMembro=$_GET['id_aceitarMembro'];
    $id_grupo=$_GET['id_grupo'];
    
    if(intval($id_aceitarMembro) && intval($id_grupo)){
        $jornal->id_aceitarMembro($id_aceitarMembro,$id_grupo);
        
        header("Location:".BASE."visualizar_grupo.php?id=".$id_grupo);
        exit; 
    }else{
        header("Location:".BASE."jornal.php");
        exit; 
    }
}



if(isset($_GET['pedirParaEntrar']) && !empty($_GET['pedirParaEntrar'])){
    $pedirParaEntrar=$_GET['pedirParaEntrar'];
    if(intval($pedirParaEntrar)){
        $jornal->pedirParaEntrar($pedirParaEntrar);
        
        header("Location:".BASE."jornal.php");
        exit; 
    }else{
        header("Location:".BASE."jornal.php");
        exit; 
    }
}

if(isset($_GET['cancelarSolicitacao']) && !empty($_GET['cancelarSolicitacao'])){
    $cancelarSolicitacao=$_GET['cancelarSolicitacao'];
    if(intval($cancelarSolicitacao)){
        $jornal->cancelarSolicitacao($cancelarSolicitacao);
        
        header("Location:".BASE."jornal.php");
        exit; 
    }else{
        header("Location:".BASE."jornal.php");
        exit; 
    }
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id=$_GET['id'];
    if(intval($id)){
        $jornal->deleteJornal($id);
        header("Location:".BASE."jornal.php");
        exit; 
    }else{
        header("Location:".BASE."jornal.php");
        exit; 
    }
}


if(isset($_GET['id_sair']) && !empty($_GET['id_sair'])){
    $id_sair=$_GET['id_sair'];
    if(intval($id_sair)){
        $jornal->sairDoJornal($id_sair);
        
        header("Location:".BASE."jornal.php");
        exit; 
    }else{
        header("Location:".BASE."jornal.php");
        exit; 
    }
}


if(empty($jornalNome) || strlen($jornalNome)<3){
    $_SESSION['msg']='Digite um Nome Com mais de 3 caracteres!';
    header("Location:".BASE."jornal.php");
    exit;
}

if(!$jornal->jornalExist($jornalNome)){
    $jornal->insert($jornalNome);
    header("Location:".BASE."jornal.php");
    exit;
}else{
    $_SESSION['msg']="Jornal já existe!";
    header("Location:".BASE."jornal.php");
    exit;
}

