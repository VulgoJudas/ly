<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Noticias.php";

use models\Users;
use models\Noticias;

$user=new Users($pdo);
$noticias=new Noticias($pdo);

if(isset($_GET['id'])){
    $id_noticia=$_GET['id'];
    if(empty($id_noticia) || !intval($id_noticia)){
        header("Location:".BASE);
        exit;
    }
}

$noticia_ultima=$noticias->getNoticia($id_noticia);

?>

<link rel="stylesheet" href="<?php echo BASE; ?>assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article id="ultima_noticia">
            <a href="<?php echo BASE; ?>ultimas_noticias.php">Voltar</a>
            <div class="ultima_notica_um">
                <img src="<?php echo BASE; ?>assets/fotos/<?php echo $noticia_ultima['foto']; ?>" alt="Foto Da Noticia"><br>
                <strong><?php echo $noticia_ultima['titulo']; ?></strong>
                <p><?php echo $noticia_ultima['corpo']; ?></p>
                <p><?php echo date("d/m/Y",strtotime($noticia_ultima['data_noticia'])); ?></p>
                <strong>Tipo: <?php echo $noticia_ultima['name']; ?></strong><br><br>
                <strong>Autor: <?php echo $noticia_ultima['nome_user']; ?></strong>
            </div>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>