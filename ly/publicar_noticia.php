<?php 
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Noticias.php";

use models\Users;
use models\Noticias;


$user=new Users($pdo);
$noticias=new Noticias($pdo);


$tipos=$noticias->getTipos();
$regiao=$noticias->getRegiao();


if(!isset($_SESSION['login']) || (isset($_SESSION['login']) && empty($_SESSION['login']))){
    $_SESSION['msg']="Precisa Está Logado!";
    header("Location:".BASE.'login.php');exit;
}
$jornais=$noticias->getJornais($_SESSION['login']); ?>


<link rel="stylesheet" href="assets/css/article.css">

<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article id="publicar_noticias">
            <div class="publicar">
                <h1>Publicar Uma Notícia:</h1>
                <form action="auth/noticia_action.php" method="post" enctype="multipart/form-data">

                    <?php if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
                        echo $_SESSION['msg'].'<br>';
                        $_SESSION['msg']='';
                    } ?>

                    <p>Titulo Da Notícia:</p>
                    <input type="text" name="titulo" id="titulo">

                    <p>Digite A Notícia:</p>
                    <textarea name="corpo" id="corpo" ></textarea>

                    <p>Foto Da Notícia:</p>
                    <input type="file" name="foto" id="foto">

                    <p>Tipo Da Notícia:</p>
                    <select name="tipo" id="tipo">
                        <?php foreach($tipos as $item): ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <p>De que Região é esta Notícia:</p>
                    <select name="regiao" id="regiao">
                        <?php foreach($regiao as $item): ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <p>Em que Jornal Você Irá Publicar está Notícia?</p>
                    <select name="jornal" id="jornal">
                        <?php foreach($jornais as $item): ?>
                            <?php foreach($item as $info): ?>
                                <option value="<?php echo $info['id']; ?>"><?php echo $info['nome']; ?></option>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </select><br>

                    <input type="submit" value="Publicar">
                </form>
            </div>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
