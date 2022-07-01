<?php
require_once "db/config.php";
unset($_SESSION['login']);
header("Location:".BASE);
exit;