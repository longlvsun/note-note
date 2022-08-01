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

function render($file_name) {
  global $content;
  ob_start();
  include_once __DIR__ . "/../views/$file_name.php";
  $content = ob_get_clean();

  include_once __DIR__ . '/../views/layout.php';
}

function render_multiple($file_names) {
  global $content;
  $content = join(array_map(function($fn) {
    ob_start();
    include_once __DIR__ . "/../views/$fn.php";
    return ob_get_clean();
  }, $file_names));

  include_once __DIR__ . '/../views/layout.php';
}
?>
