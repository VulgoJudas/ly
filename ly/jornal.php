<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Jornal.php";


use models\Users;
use models\Jornal;

$user=new Users($pdo);
$jornal=new Jornal($pdo); ?>

<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>

        <article id="jornal_article">
           <?php if(isset($_SESSION['login']) && !empty($_SESSION['login'])): ?>
                <strong>Criar Um jornal para Você:</strong>
                <form action="<?php echo BASE; ?>auth/jornal_action.php" method="post">
                    <?php if(!empty($_SESSION['msg'])): ?>
                        <div class="erro"><?php echo $_SESSION['msg']; ?></div>
                        <?php unset($_SESSION['msg']); ?>
                    <?php endif; ?>
                    <input type="text" name="jornalName" id="jornalName"><br>
                    <input type="submit" value="Criar">
                </form>
            
                <strong>Jornais Que Você é o Dono:</strong>
                <table>
                    <thead>
                        <tr>
                            <th>Nome Jornal</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($jornal->getJornaisMy() as $item): ?>
                            <tr>
                                <td><?php echo $item['nome']; ?></td>
                                <td><a href="<?php echo BASE; ?>visualizar_grupo.php?id=<?php echo $item['id']; ?>">Visualizar</a><a href="<?php echo BASE; ?>auth/jornal_action.php?id=<?php echo $item['id']; ?>">Deletar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <strong>Jornais que Você participa:</strong>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome Jornal</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($jornal->getJornaisMembro() as $item): ?>
                                <tr>
                                    <td><?php echo $item['nome']; ?></td>
                                    <td><a href="<?php echo BASE; ?>auth/jornal_action.php?id_sair=<?php echo $item['id_jornal']; ?>">Sair</a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <strong>Jornais que Você Enviou Solicitação e ainda Não Foram Aprovadas</strong>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome Jornal</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($jornal->jornaisSolicitar() as $item): ?>
                                <tr>
                                    <td><?php echo $item[0]['nome']; ?></td>
                                    <td><a href="<?php echo BASE; ?>auth/jornal_action.php?cancelarSolicitacao=<?php echo $item[0]['id']; ?>">Cancelar Solicitação</a></td>
                                
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <strong>Jornais que Você Pode Pedir para Entrar</strong>
                    <table>
                        <thead>
                            <tr>
                                <th>Nome Jornal</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($jornal->jornaisEnviarSolicitacao() as $item): ?>
                                <?php foreach($item as $itemk=>$itemv): ?>
                                    <tr>
                                        <td><?php echo $itemv['nome']; ?></td>
                                        <td><a href="<?php echo BASE; ?>auth/jornal_action.php?pedirParaEntrar=<?php echo $itemv['id']; ?>">Enviar Solicitação</a></td>
                                
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
            <?php else: ?>
                <span class="jornal_info">Você Precisa Está Logado para acessar está Página. <a href="<?=BASE;?>login.php">Fazer Login</a></span>
            <?php endif; ?>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
