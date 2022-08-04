<?php

namespace Ctrl;

require_once __DIR__ . '/../models/note.model.php';
require_once __DIR__ . '/../config/config.php';

use Mod;
use Ctrl;
use Conf;
use Exception;

class Note {
  static function home() {
    global $cur_user;
    global $note;

    $cur_user = Ctrl\login_guard();
    $id = intval($cur_user->id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
      global $err;
      if (empty($_POST['title'])) {
        $err = 'please input title';
        goto render_home;
      }

      $title = $_POST['title'];

      if (empty($_POST['content'])) {
        $err = 'please input content';
        goto render_home;
      }

      $content = $_POST['content'];
      Mod\Note::new($id, $title, $content);
      goto render_home;
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
      $noteId = intval($_POST['id']);
      Mod\Note::load($noteId)->delete();
      goto render_home;
    }

  render_home:
    $note = Mod\Note::findByUser($id);
    Conf\render_multiple(['header', 'main']);
  }


  static function edit_note() {
    global $editedNote;
    global $err;

    $id = intval($_GET['id']);
    $editedNote = Mod\Note::load($id);

    if (!$editedNote) {
      header('Location: /');
      return 1;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      global $err;
      if (empty($_POST['title'])) {
        $err = 'please input title';
        goto render_edit_note;
      }

      $title = $_POST['title'];

      if (empty($_POST['content'])) {
        $err = 'please input content';
        goto render_edit_note;
      }

      $content = $_POST['content'];

      try {
        $editedNote->content = $content;
        $editedNote->title = $title;
        $editedNote->save();
      } catch(Exception $err) {
        goto render_edit_note;
      }

      header('Location: /');
      return 0;
    }

  render_edit_note:
    Conf\render_multiple(['header', 'editNote']);
  }
}
