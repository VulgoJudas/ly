<?php
require_once "config.php";
require_once "models/Users.php";
use models\Users;

$user=new Users($pdo);

$nomeCompleto=filter_input(INPUT_POST,'nome');
$email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
$senha=filter_input(INPUT_POST,'senha');
$dataNascimento=filter_input(INPUT_POST,'data');

$nomeCompleto=trim($nomeCompleto);
$newNome=explode(' ',$nomeCompleto);

if(count($newNome) < 2){
    $_SESSION['msg']='Digite Seu Nome Completo!';
    header("Location:".BASE."cadastrar.php");
    exit;
    
}


if(strlen($newNome[0]) < 4){
    $_SESSION['msg']='Digite Seu Nome Completo!';
    header("Location:".BASE."cadastrar.php");
    exit;
    
}
if(empty($email)){
    $_SESSION['msg']='Digite Um E-mail!';
    header("Location:".BASE."cadastrar.php");
    exit;
}

if(!empty($senha)){
    $newSenha=password_hash($senha,PASSWORD_DEFAULT);
}else{
    $_SESSION['msg']='Digite Uma Senha!';
    header("Location:".BASE."cadastrar.php");
    exit;
}

$newData=explode('/',$dataNascimento);

if(count($newData)!=3){
    $_SESSION['msg']='Data Invalida!';
    header("Location:".BASE."cadastrar.php");
    exit;
}

$newData=$newData[2].'-'.$newData[1].'-'.$newData[0];
if(strtotime($newData)===false){
    $_SESSION['msg']='Data Invalida!';
    header("Location:".BASE."cadastrar.php");
    exit;
}

if(!$user->emailExist($email)){
    $user->insert($newNome,$email,$newSenha,$newData);
    header("Location:".BASE);
    exit;
}else{
    $_SESSION['msg']='E-mail Já existe!';
    header("Location:".BASE."cadastrar.php");
    exit;
}
