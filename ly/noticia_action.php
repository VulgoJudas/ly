<?php
require_once "config.php";
require_once "models/Noticias.php";
use models\Noticias;

$noticias=new Noticias($pdo);

$id_user=$_SESSION['login'];
$titulo=filter_input(INPUT_POST,'titulo');
$texto=filter_input(INPUT_POST,'corpo');

$texto=trim($texto);

if(isset($_FILES['foto']) && !empty($_FILES['foto']['tmp_name'])){
    $foto=$_FILES['foto'];
}

$tipo=filter_input(INPUT_POST,'tipo');
$regiao=filter_input(INPUT_POST,'regiao');
$jornal=filter_input(INPUT_POST,'jornal');


if(empty($titulo)){
    $_SESSION['msg']="A Notícia Precisa De Um Titulo!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}

if(empty($texto)){
    $_SESSION['msg']="A Notícia Precisa De Um Texto!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}

if(strlen($texto)<20){
    $_SESSION['msg']="A Notícia Precisa Ser Maior Do que 20 caracteres!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}

if(empty($foto)){
    $_SESSION['msg']="A Notícia Precisa De Uma Foto!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}

if(empty($tipo)){
    $_SESSION['msg']="A Notícia Precisa De Um Tipo!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}

if(empty($regiao)){
    $_SESSION['msg']="A Notícia Precisa De Uma Região!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}

if(empty($jornal)){
    $_SESSION['msg']="A Notícia Precisa De Um Jornal!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}

if($noticias->insertNoticia($id_user,$titulo,$texto,$foto,$tipo,$regiao,$jornal)){
    header("Location:".BASE);
    exit;
}else{
    $_SESSION['msg']="Foto Invalida!";
    header("Location:".BASE."publicar_noticia.php");
    exit;
}



