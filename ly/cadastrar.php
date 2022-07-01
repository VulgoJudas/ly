<?php 
require_once "db/config.php";
require_once "partes/header.php";


if(isset($_SESSION['login']) && !empty($_SESSION['login'])){
    header("Location:".BASE);exit;
}
    ?>
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/aside.css">
<link rel="stylesheet" href="assets/css/header.css">
<link rel="stylesheet" href="assets/css/footer.css">
    <section> 
        <?php require_once "partes/aside.php"; ?>
        <article>
            <h1 class="h1_login">Criar Conta</h1>
            <form class="form" action="<?=BASE;?>auth/cadastrar_action.php" method="post">
                <?php if(!empty($_SESSION['msg'])): ?>
                    <div class="erro"><?php echo $_SESSION['msg']; ?></div>
                    <?php unset($_SESSION['msg']); ?>
                <?php endif; ?>
                <span>Nome Completo:</span><br>
                <input type="text" name="nome" id="nome"><br><br>
                <span>E-mail:</span><br>
                <input type="email" name="email" id="email"><br><br>
                <span>Senha:</span><br>
                <input type="password" name="senha" id="senha"><br><br>
                <span>Data Nascimento:</span><br>
                <input type="text" name="data" id="data"><br><br>
                <input type="submit" value="Cadastrar">
            </form>
            <span class="cadastrar">Já Tem Uma Conta <a href="<?=BASE;?>login.php">Faça Login</a></span>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
<script src="https://unpkg.com/imask"></script>
<script>
    IMask(document.getElementById('data'),{mask:'00/00/0000'});
</script>
