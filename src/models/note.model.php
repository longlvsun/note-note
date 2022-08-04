<?php

namespace Mod;

use Exception;

class Note extends Base {
  public $id;
  public $owner;
  public $content;
  public $title;

  function __construct($owner = 0, $title = '', $content = '') {
    parent::__construct('notes');
    $this->owner = $owner;
    $this->content = $content;
    $this->title = $title;
  }

  function save() {
    return $this->update('id', $this->id,
      ['content', 'title'],
      [$this->content, $this->title]
    );
  }

  static function load($id) {
    $note = new Note();
    $res = $note->find('id', $id)->fetch_assoc();
    if (!$res) return false;

    $note->id = $res['id'];
    $note->owner = $res['owner'];
    $note->title = $res['title'];
    $note->content = $res['content'];
    $note->created_at = $res['created_at'];
    $note->updated_at = $res['updated_at'];

    return $note;
  }

  static function new(...$args) {
    @[$owner, $title, $content] = $args;
    empty($owner) && $owner = 0;
    empty($content) && $content = '';
    empty($title) && $title = '';
    $note = new Note($owner, $title, $content);

    try {
      $res = $note->add(
        ['owner', 'content', 'title'],
        [$note->owner, $note->content, $note->title]
      )->fetch_assoc();
    } catch (Exception $err) {
      if (preg_match('/fk_owner/i', $err)) {
        throw new Exception("owner_id: $owner not exists");
      }
      throw $err;
    }

    if (!$res) return false;
    $note->id = $res['id'];
    $note->created_at = $res['created_at'];
    $note->updated_at = $res['updated_at'];

    return $note;
  }

  static function _find($key, $val) {
    $note = new Note();
    $res = $note->find($key, $val)->fetch_assoc();
    if (!$res) return false;
    $note->id = $res['id'];
    $note->owner = $res['owner'];
    $note->title = $res['title'];
    $note->content = $res['content'];
    $note->created_at = $res['created_at'];
    $note->updated_at = $res['updated_at'];
    return $note;
  }

  static function findByUser($user): array {
    $note = new Note();
    $notelist = $note->find('owner', $user)->fetch_all(MYSQLI_ASSOC);
    $notelist = array_map(function($note_assoc) {
      $note = new Note(
        $note_assoc['owner'],
        $note_assoc['title'],
        $note_assoc['content']
      );
      $note->id = $note_assoc['id'];
      $note->created_at = $note_assoc['created_at'];
      $note->updated_at = $note_assoc['updated_at'];

      return $note;
    }, $notelist);

    return $notelist;
  }

  function delete() {
    $sql = 'DELETE FROM ' . $this->real_string($this->table_name) .
      ' WHERE id = ' . $this->real_val($this->id);
    $res = $this->run_query($sql);

    return $res;
  }
}
