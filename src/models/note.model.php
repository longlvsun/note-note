<?php
namespace Mod;

use Exception;

class Note extends Base {
  public $id;
  public $owner;
  public $content;

  function __construct($owner = 0, $content = '') {
    parent::__construct('notes');
    $this->owner = $owner;
    $this->content = $content;
  }

  function save() {
    return $this->update('id', $this->id,
      ['owner', 'content'],
      [$this->owner, $this->content]
    );
  }

  static function load($id) {
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

  static function new(...$args) {
    @[$owner, $content] = $args;
    empty($owner) && $owner = 0;
    empty($content) && $content = '';
    $note = new Note($owner, $content);

    try {
      $res = $note->add(
        ['owner', 'content'],
        [$note->owner, $note->content])->fetch_assoc();
    } catch(Exception $err) {
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
    $note->content = $res['content'];
    $note->created_at = $res['created_at'];
    $note->updated_at = $res['updated_at'];
    return $note;
  }
}
?>
