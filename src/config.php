<?php
define('DB_SERVER', 'note-note-mysql-db-1');
define('DB_USERNAME', 'noob');
define('DB_PASSWORD', 'noob');
define('DB_NAME', 'noob');

$dbconn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($dbconn === false) {
  die('ERROR: could not connect. ' . mysqli_connect_error());
}

function json_resp($code = 200, $data = null, $msg = null) {
  $resp['stt'] = $code >= 200 && $code < 300 ? 'ok': 'err';
  isset($data) && $resp['data'] = $data;
  isset($msg) && $resp['msg'] = $msg;

  http_response_code($code);
  header('Content-Type: application/json; charset=utf-8');
  print json_encode($resp);
}
?>
