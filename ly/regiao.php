<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Regiao.php";

use models\Users;
use models\Regiao;

$r=new Regiao($pdo);
$user=new Users($pdo);

$regiao=$r->getRegiao(); ?>


<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php  require_once "partes/aside.php"; ?>
        <article id="regiao">
             <h2>Regiões:</h2>
             <?php foreach($regiao as $item): ?>
                <a href="<?php echo BASE;?>regiao_view.php?id=<?php echo $item['id']; ?>"><?php echo $item['nome']; ?></a><br>
            <?php  endforeach; ?>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
