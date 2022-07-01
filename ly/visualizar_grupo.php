<?php
require_once "db/config.php";
require_once "models/Users.php";
require_once "models/Jornal.php";

use models\Users;
use models\Jornal;

$user=new Users($pdo);
$jornal=new Jornal($pdo); ?>

<?php $id=filter_input(INPUT_GET,'id');
if(!$jornal->getInfoJornal($id)){
    header('Location:'.BASE.'jornal.php');exit;
}

$array=[];
foreach($jornal->getInfoJornal($id) as $item){
    $array[]=$item;
}

?>


<link rel="stylesheet" href="assets/css/article.css">
<?php require_once "partes/header.php"; ?>
    <section>
        <?php require_once "partes/aside.php"; ?>
        <article id="jornal_article">
           <h1><?php echo $array[1]; ?></h1><a href="<?php echo BASE; ?>jornal.php">Voltar</a>
           <hr>
           <strong>Membros Do Jornal</strong>
           <table >
                <thead>
                    <tr>
                        <th>Nome Do Membro</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($array[2] as $item): ?>
                            <tr>
                                <td><?php echo $item['nome']; ?></td>
                                <td><a href="<?php echo BASE; ?>auth/jornal_action.php?id_expulsarMembro=<?php echo $item['id']; ?>&id_grupo=<?php echo $array[0]; ?>">Expulsar Membro</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>
           <hr>
           <strong>Pedidos Para Fazer Parte Do Seu jornal</strong>
           <table >
                <thead>
                    <tr>
                        <th>Nome Do Membro</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($array[3] as $item): ?>
                            <tr>
                                <td><?php echo $item['nome']; ?></td>
                                <td><a href="<?php echo BASE; ?>auth/jornal_action.php?id_aceitarMembro=<?php echo $item['id']; ?>&id_grupo=<?php echo $array[0]; ?>">Aceitar Membro</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>
        </article>
    </section>
<?php require_once "partes/footer.php"; ?>
