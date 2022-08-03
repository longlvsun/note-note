<?php
namespace Ctrl;

require_once __DIR__ . '/../models/note.model.php';
use Mod;
use Ctrl;

class Note {
  static function home() {
    global $cur_user;
    $cur_user = Ctrl\login_guard();
    $note = Mod\Note::load(5);
    print json_encode($note);
  }
}
?>
