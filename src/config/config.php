<?php
namespace Conf;

define('DB_SERVER', 'note-note-mysql-db-1');
define('DB_USERNAME', 'noob');
define('DB_PASSWORD', 'noob');
define('DB_NAME', 'noob');

function DbConn() {
  static $dbconn;
  $dbconn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

  if ($dbconn === false) {
    die('ERROR: could not connect. ' . mysqli_connect_error());
  }

  return $dbconn;
}
?>
