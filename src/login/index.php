<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once $_SERVER['DOCUMENT_ROOT'] .'/config.php';

  $json = file_get_contents('php://input');
  $json = json_decode($json);

  if (empty($_POST['username']) && empty($json->username)) {
    json_resp(422, null, 'missing username field');
    exit();
  }

  $username = isset($_POST['username']) ? $_POST['username'] : $json->username;

  if (empty($_POST['password']) && empty($json->password)) {
    json_resp(422, null, 'missing password field');
    exit();
  }

  $password = isset($_POST['password']) ? $_POST['password'] : $json->password;
  $remember = isset($_POST['remember']) ? true : $json->remember;

  $res = mysqli_query($dbconn,
   'select * from users where username = \'' .
    mysqli_real_escape_string($dbconn, $username) .
    '\';'
  );

  $res = $res->fetch_assoc();

  if (!$res || !password_verify($password, $res['hash_passwd'])) {
    json_resp(403, null, 'username or password not matched');
    exit();
  }

  session_start();
  $_SESSION['uid'] = $res['id'];
  if ($remember) {
    setcookie(
      'remb',
      $res['id'] . '|' . hash('sha256', 'remb' . $res['id'] . 'remb'),
      time() + 3600 * 24 * 30,
      '/'
    );
  }

  json_resp(200);

  exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/login/guard.php';

?>
