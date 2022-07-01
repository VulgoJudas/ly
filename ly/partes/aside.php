<?php 
    $ativo=$_SERVER['REQUEST_URI'];
    $ativo=explode('/',$ativo);
    $ativo='\''.$ativo[2].'\'';
?>


<link rel="stylesheet" href="assets/css/aside.css">
<aside>
    <ul>
        <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
            <a class="<?php echo($ativo =='\'perfil.php\'')?'activo':''; ?>" href="<?=BASE; ?>perfil.php"><li><?php echo ucfirst($user->getInfoUserLogged($_SESSION['login'])['nome']); ?></li></a>
        <?php endif; ?>
        <a class="<?php echo($ativo =='\'\'')?'activo':''; ?>" href="<?=BASE; ?>"><li>Inicio</li></a>
        <?php if(empty($_SESSION['login'])): ?>
            <a class="<?php echo($ativo =='\'login.php\'')?'activo':''; ?>" href="<?=BASE; ?>login.php"><li>Entrar</li></a>
        <?php endif; ?>
        <a class="<?php echo($ativo =='\'publicar_noticia.php\'')?'activo':''; ?>" href="<?php echo BASE; ?>publicar_noticia.php"><li>Publicar Notícias</li></a>
        <a class="<?php echo($ativo =='\'problema.php\'')?'activo':''; ?>" href="<?php echo BASE; ?>problema.php"><li>Relatar Algum Problema</li></a>
        <a class="<?php echo($ativo =='\'jornal.php\'')?'activo':''; ?>" href="<?php echo BASE; ?>jornal.php"><li>Fazer Parte De Um Jornal</li></a>
        <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
            <a href="<?=BASE; ?>logout.php"><li>Sair</li></a>
        <?php endif; ?>
    </ul>
</aside>