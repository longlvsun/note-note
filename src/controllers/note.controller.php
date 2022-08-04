<?php

namespace Ctrl;

require_once __DIR__ . '/../models/note.model.php';

use Mod;
use Ctrl;
use Conf;


class Note
{
  static function home()
  {
    global $cur_user;
    $cur_user = Ctrl\login_guard();
    $id = intval($cur_user->id);
    $note = Mod\Note::findByUser($id);
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
      $newNote = Mod\Note::createNewNote($id, $title, $content);
      header('Location: /');
      // $note = Mod\Note::findByUser($id);
      // goto render_home;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
      $noteId = intval($_POST['id']);
      $deletedNote = Mod\Note::deleteNoteById($noteId);
      header('Location: /');
      // $note = Mod\Note::findByUser($id);
      // goto render_home;
    }

    render_home:
    include_once __DIR__ . '/../views/header.php';
    include_once __DIR__ . '/../views/main.php';
    include_once __DIR__ . '/../views/layout.php';
  }


  static function editNote()
  {
    $id = intval($_GET['id']);
    $editedNote = Mod\Note::findById($id);

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
      // $note = Mod\Note::update();
      $updatedNote = Mod\Note::_update($id, $content, $title);
      header('Location: /');
    }
    render_edit_note:
    include_once __DIR__ . '/../views/header.php';
    include_once __DIR__ . '/../views/editNote.php';
    include_once __DIR__ . '/../views/layout.php';
  }
}
