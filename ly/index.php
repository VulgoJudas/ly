<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Noticias.php";

use models\Users;
use models\Noticias;

$user=new Users($pdo); 
$noticias=new Noticias($pdo);

$noticiasRand=$noticias->getNoticiasRand(); ?>

<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>   
        <?php require_once "partes/aside.php"; ?>
        <article id="noticias_rand">
            <div class="noticia_rand">
                <?php foreach($noticiasRand as $item): ?>
                    <div class="noticia_rand_bloco">
                        <a href="<?php echo BASE; ?>noticia_ultima.php?id=<?php echo $item['id']; ?>">
                            <img src="<?php echo BASE; ?>assets/fotos/<?php echo $item['foto']; ?>" alt="Imagem Da Notícia">
                            <strong><?php echo $item['titulo']; ?></strong>
                            <p><?php echo date("d/m/Y ",strtotime($item['data_noticia'])); ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>