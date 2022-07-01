<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Regiao.php";

use models\Users;
use models\Regiao;

$r=new Regiao($pdo);
$user=new Users($pdo);

if(isset($_GET['id'])){
    $id=$_GET['id'];
    if(!empty($id) && intval($id)){
        $regiao_noticias=$r->getRegiaoNoticias($id);
    }else{
        header("Location:".BASE);exit;
    }
}else{
    header("Location:".BASE);exit;
}
 ?>


<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article id="regiao_view">
             <h2>Região - <?php echo $regiao_noticias[0]['nome']; ?></h2>
             <h5>Algumas Notícias Dessa Região</h5>
                <div class="caixinha">
                    <div class="caixinha_noticia">
                        <?php if($regiao_noticias[0]['foto']): ?>
                            <?php foreach($regiao_noticias as $item): ?>
                                <a href="<?php echo BASE;?>noticia_ultima.php?id=<?php echo $item['id']; ?>">
                                    <img src="<?php echo BASE; ?>assets/fotos/<?php echo $item['foto']; ?>" alt="Foto DA Noticia"><br>
                                    <strong><?php echo $item['titulo']; ?></strong>
                                    <p><?php echo date("d/m/Y",strtotime($item['data_noticia'])); ?></p>
                                </a><br>
                            <?php  endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
