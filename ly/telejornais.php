<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Telejornais.php";

use models\Users;
use models\Telejornais;

$tele=new Telejornais($pdo);
$user=new Users($pdo);

$teleInfo=$tele->getTelejornais(); ?>


<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article id="telejornais">
             <h2>Alguns Telejornais:</h2>
             <?php foreach($teleInfo as $item): ?>
                <a href="<?php echo BASE;?>tele_view.php?id=<?php echo $item['id']; ?>"><?php echo $item['nome']; ?></a><br>
            <?php  endforeach; ?>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
