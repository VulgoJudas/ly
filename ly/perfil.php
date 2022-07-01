<?php
require_once "db/config.php";
require_once "models/Users.php";

use models\Users;

$user=new Users($pdo);

if(!isset($_SESSION['login']) || (isset($_SESSION['login']) && empty($_SESSION['login']))){
    header("Location:".BASE."login.php");exit;
} 

$infoUser=$user->getInfoUserNoticia($_SESSION['login'])?>

<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article id="perfil">
             <strong>Nome Usuario</strong>
             <p><?php echo $infoUser['nome']; ?></p>
             <strong>E-mail:</strong>
             <p><?php echo $infoUser['email']; ?></p>
             <?php if($infoUser['id']): ?>
             <strong>Ultima Noticia Que Você Publicou</strong>
             <a href="noticia_ultima.php?id=<?php echo $infoUser['id']; ?>">
                <img src="<?php echo BASE; ?>assets/fotos/<?php echo $infoUser['foto']; ?>" alt="Foto Da Notícia"><br>
                <strong>Titulo</strong>
                <p><?php echo $infoUser['titulo']; ?></p>
                <strong>Data:</strong>
                <p><?php echo date("d/m/Y",strtotime($infoUser['data_noticia'])); ?></p>
             </a>
             <?php endif; ?>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
