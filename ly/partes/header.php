<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LY</title>
    <link rel="stylesheet" href="assets/css/header.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <a href="<?php echo BASE; ?>regiao.php"><li>Regiões</li></a>
                <a href="<?php echo BASE; ?>telejornais.php"><li>Telejornais</li></a>
            </ul>
        </nav>
        <div class="logo">
            <a href="<?=BASE;?>"><h1>LY</h1></a>
        </div>
        <div class="search">
            <form action="<?php echo BASE; ?>search.php">
                <input type="text" name="busca" id="busca" placeholder="Buscar"><br>
                <input type="submit" value="Pesquisar">
            </form>
        </div>
    </header>