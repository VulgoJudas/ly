<?php
require_once "../db/config.php";
require_once "../models/Users.php";
use models\Users;

$user=new Users($pdo);

$email=filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
$senha=filter_input(INPUT_POST,'senha');

if($userInfo=$user->emailExist($email)){
    
    if(password_verify($senha,$userInfo['senha'])){
        $_SESSION['login']=$userInfo['id'];
        header("Location:".BASE);
        exit;
    }else{
        $_SESSION['msg']='Senha Incorreta!';
        header("Location:".BASE."login.php");
        exit;
    }

}else{
    $_SESSION['msg']='E-mail não existe no banco de dados!';
    header("Location:".BASE."login.php");
    exit;
}