<?php
require_once "config.php";
require_once "models/Problemas.php";
use models\Problemas;

$p=new Problemas($pdo);

$msg=filter_input(INPUT_POST,'msg');
$msg=trim($msg);

if(strlen($msg)<10){
    $_SESSION['msg']="Digite Alguma mensagem";
    header("Location:".BASE."problema.php");exit;
}

$p->insertMensage($_SESSION['login'],$msg);
header("Location:".BASE."problema.php");exit;