<?php
session_start();
session_destroy();
setcookie('remb', '', time() - 3600);
header('Location: /login/');
?>
