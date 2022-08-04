<?php

namespace Mod;

use Exception;

class Note extends Base
{
  public $id;
  public $owner;
  public $content;

  function __construct($owner = 0, $title = '', $content = '')
  {
    parent::__construct('notes');
    $this->owner = $owner;
    $this->content = $content;
    $this->title = $title;
  }

function save() {}

  static function _update($id, $content, $title)
  {
    $note = new Note();
    return $note->update(
      'id',
      $id,
      ['content', 'title'],
      [$content, $title]
    );
  }

  static function load($id)
  {
    $note = new Note();
    $res = $note->find('id', $id)->fetch_assoc();
    if (!$res) return false;

    $note->id = $res['id'];
    $note->owner = $res['owner'];
    $note->content = $res['content'];
    $note->created_at = $res['created_at'];
    $note->updated_at = $res['updated_at'];

    return $note;
  }

  static function new(...$args)
  {
    @[$owner, $content] = $args;
    empty($owner) && $owner = 0;
    empty($content) && $content = '';
    $note = new Note($owner, $content);

    try {
      $res = $note->add(
        ['owner', 'content'],
        [$note->owner, $note->content]
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

  static function _find($key, $val)
  {
    $note = new Note();
    $res = $note->find($key, $val)->fetch_assoc();
    if (!$res) return false;
    $note->id = $res['id'];
    $note->owner = $res['owner'];
    $note->content = $res['content'];
    $note->created_at = $res['created_at'];
    $note->updated_at = $res['updated_at'];
    return $note;
  }

  static function findByUser($user)
  {
    $note = new Note();
    $notelist = $note->find('owner', $user)->fetch_all();
    if ($notelist) {
    }
    return $notelist;
  }

  static function createNewNote($owner, $title, $content)
  {
    empty($owner) && $owner = 0;
    empty($title) && $title = '';
    empty($content) && $content = '';
    $note = new Note($owner, $title, $content);

    try {
      $res = $note->add(
        ['owner', 'title', 'content'],
        [$note->owner, $note->title, $note->content]
      )->fetch_assoc();
    } catch (Exception $err) {
      throw $err;
    }
  }

  static function deleteNoteById($id)
  {
    $note = new Note();
    try {
      $sql = 'DELETE FROM notes WHERE id =' . $note->real_val($id);
      $res = $note->run_query($sql);
    } catch (\Exception $err) {
      if (preg_match('/fk_owner/i', $err)) {
        throw new Exception("err");
      }
      throw $err;
    }
  }

  static function findById($id)
  {
    $note = new Note();
    try {
      $result = $note->find('id', $id)->fetch_assoc();
    } catch (Exception $err) {
      throw $err;
    }
    return $result;
  }
}
