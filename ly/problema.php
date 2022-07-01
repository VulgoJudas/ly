<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Problemas.php"; 

use models\Users;
use models\Problemas;

$user=new Users($pdo);
$p=new Problemas($pdo); ?>


<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        
        <article id="problema">
           <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
                <h2>Reclame Aqui</h2>
                <form action="<?=BASE;?>auth/problema_action.php" method="post">
                <?php if(!empty($_SESSION['msg'])): ?>
                        <div class="erro"><?php echo $_SESSION['msg']; ?></div>
                        <?php unset($_SESSION['msg']); ?>
                    <?php endif; ?>
                   <span>Mensagem:</span>
                    <textarea name="msg" id="msg"></textarea>
                    <input type="submit" value="Enviar Mensagem">
                </form>
                    
                    <h3>Algumas Reclamações:</h3>
                    <?php foreach($p->getReclamações() as $item): ?>
                        <div class="reclamacao">
                            <span>Nome Do Usuário:</span>
                            <p><?=$item['nomeUser']; ?></p>
                            
                            <span>Mensagem:</span><p><?=$item['msg']; ?></p>
                            <p><?php echo date("d/m/Y H:i:s",strtotime($item['data'])); ?></p>
                            
                        </div>
                    <?php endforeach; ?>
            <?php else: ?>
                <span class="jornal_info">Você Precisa Está Logado para acessar está Página. <a href="<?=BASE;?>login.php">Fazer Login</a></span>
            <?php endif; ?>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>