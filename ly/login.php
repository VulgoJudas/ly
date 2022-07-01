<?php 
require_once "db/config.php"; 
require_once "partes/header.php";
 
if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
    header("Location:".BASE);exit;
}  ?>


<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/aside.css">
<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" href="assets/css/footer.css">
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article>
            <h1 class="h1_login">Entrar</h1>
            <form class="form" action="<?=BASE;?>auth/login_action.php" method="post">
                <?php if(!empty($_SESSION['msg'])): ?>
                    <div class="erro"><?php echo $_SESSION['msg']; ?></div>
                    <?php unset($_SESSION['msg']); ?>
                <?php endif; ?>
                <span>E-mail:</span><br>
                <input type="email" name="email" id="email"><br><br>
                <span>Senha:</span><br>
                <input type="password" name="senha" id="senha"><br><br>
                <input type="submit" value="Entrar">
            </form>
            <span class="cadastrar">Não Tem Uma Conta Ainda?<a href="<?=BASE;?>cadastrar.php">Cadastre-se</a></span>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>