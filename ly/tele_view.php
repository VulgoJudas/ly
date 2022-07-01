<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Telejornais.php";

use models\Users;
use models\Telejornais;

$tele=new Telejornais($pdo);
$user=new Users($pdo);

if(isset($_GET['id'])){
    $id=$_GET['id'];
    if(!empty($id) && intval($id)){
        $jornal_noticia=$tele->getNoticiasJornal($id);
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
        <article id="tele_view">
             <h2>Jornal - <?php echo $jornal_noticia[0]['nome']; ?></h2>
             <h5>Algumas Notícias Deste Jornal</h5>
             <div class="caixinha">
                <div class="caixinha_noticia">
                    <?php if($jornal_noticia[0]['foto']): ?>
                    <?php foreach($jornal_noticia as $item): ?>
                        <a href="<?php echo BASE;?>noticia_ultima.php?id=<?php echo $item['id']; ?>">
                            <img width="250px" src="<?php echo BASE; ?>assets/fotos/<?php echo $item['foto']; ?>" alt="Foto DA Noticia"><br>
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
