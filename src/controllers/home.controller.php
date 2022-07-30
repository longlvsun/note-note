<?php
namespace Ctrl;

require_once __DIR__ . '/user.controller.php';
use Ctrl;

class Home {
  static function login() {
    return Ctrl\User::login();
  }

  static function logout() {
    return Ctrl\User::logout();
  }

  static function home() {
    ob_start();
    include_once __DIR__ . '/../views/header.php';
    $content = ob_get_clean();
    ob_start();
    include_once __DIR__ . '/../views/main.php';
    $content .= ob_get_clean();
    ob_start();
    include_once __DIR__ . '/../views/footer.php';
    $content .= ob_get_clean();

    include_once __DIR__ . '/../views/layout.php';
  }
}
?>
