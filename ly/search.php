<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Search.php";

use models\Users;
use models\Search;

$user=new Users($pdo);
$s=new Search($pdo);



if(isset($_GET['busca']) && !empty($_GET['busca'])){
    $dados=addslashes($_GET['busca']);

    $search=$s->getSearch($dados);
}

?>

<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article id="search">
             <h1>Resultados Da Busca</h1>
             <?php if(!empty($search)): ?>
                <?php foreach($search as $item): ?>
                    <a href="<?php echo BASE; ?>noticia_ultima.php?id=<?php echo $item['id']; ?>">
                        <div class="resultado">
                            <img src="<?php echo BASE; ?>assets/fotos/<?php echo $item['foto']; ?>" alt="Foto Da noticia">
                            <span><?php echo $item['titulo']; ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
             <?php endif; ?>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
