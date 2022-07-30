<?php
namespace Mod;

use Exception;

require_once __DIR__ . '/base.model.php';

class User extends Base {
  public $id;
  public $username;
  private $hash_passwd;

  function __construct($username = '', $password = '') {
    parent::__construct('users');
    $this->username = $username;
    $this->new_passwd($password);
  }

  function new_passwd($password) {
    $this->hash_passwd = password_hash($password, PASSWORD_DEFAULT);
  }

  function verify($password) {
    return password_verify($password, $this->hash_passwd);
  }

  function save() {
    return $this->update('id', $this->id,
      ['username', 'hash_passwd'],
      [$this->username, $this->hash_passwd]);
  }

  static function load($id) {
    $user = new User();
    $res = $user->find('id', $id)->fetch_assoc();
    if (!$res) return false;

    $user->id = $res['id'];
    $user->username = $res['username'];
    $user->hash_passwd = $res['hash_passwd'];
    $user->created_at = $res['created_at'];
    $user->updated_at = $res['updated_at'];

    return $user;
  }

  static function new(...$args) {
    [$username, $password] = $args;
    $user = new User($username, $password);

    try {
      $res = $user->add(
        ['username', 'hash_passwd'],
        [$user->username, $user->hash_passwd])->fetch_assoc();
    } catch(Exception $err) {
      if (preg_match('/duplicate entry.*username/i', $err)) {
        throw new Exception("Username $username existed.");
      }
      throw $err;
    }

    if (!$res) return false;
    $user->id = $res['id'];
    $user->created_at = $res['created_at'];
    $user->updated_at = $res['updated_at'];

    return $user;
  }

  static function _find($key, $val) {
    $user = new User();
    $res = $user->find($key, $val)->fetch_assoc();
    if (!$res) return false;
    $user->id = $res['id'];
    $user->username = $res['username'];
    $user->hash_passwd = $res['hash_passwd'];
    $user->created_at = $res['created_at'];
    $user->updated_at = $res['updated_at'];
    return $user;
  }
}
?>
