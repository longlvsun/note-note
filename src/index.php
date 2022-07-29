<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/login/guard.php';

print json_encode($cur_user);
?>
