<?php
namespace Mod;

require_once __DIR__ . '/../config/config.php';
use Conf;

abstract class Base {
  protected $dbconn;
  protected $table_name;
  protected $created_at;
  protected $updated_at;

  function __construct($name) {
    $this->dbconn = Conf\DbConn();
    $this->table_name = $name;
    $this->created_at = time();
    $this->updated_at = time();
  }

  function run_query($sql) {
    return mysqli_query($this->dbconn, $sql);
  }

  function real_string($str) {
    return mysqli_real_escape_string($this->dbconn, $str);
  }

  function real_val($str) {
    return (is_string($str) ? "'" : '') .
      $this->real_string($str) .
      (is_string($str) ? "'" : '');
  }

  function find($key, $val) {
    $sql = 'select * from ' . $this->real_string($this->table_name) . ' where ' .
      $this->real_string($key) . ' = ' . $this->real_val($val);
    return $this->run_query($sql);
  }

  function update($key, $val, $fields, $vals) {
    $sql = 'update ' . $this->real_string($this->table_name) . ' set ' .
      join(', ', array_map(fn($k, $v) => 
        $this->real_string($k) . ' = ' . $this->real_val($v)
      , $fields, $vals)) .
      ' where ' . $this->real_string($key) . ' = ' . $this->real_val($val);

    return $this->run_query($sql);
  }

  function add($fields, $vals) {
    $sql = 'insert into ' . $this->real_string($this->table_name) . ' (' .
      join(', ', array_map(fn($k) => $this->real_string($k), $fields)) .
      ') values (' .
      join(', ', array_map(fn($v) => $this->real_val($v), $vals)) .
      ')';

    $this->run_query($sql);
    $sql = 'select * from ' . $this->real_string($this->table_name) .
      ' where id = last_insert_id();';
    return $this->run_query($sql);
  }

  function get_created() {
    return $this->created_at;
  }

  function get_updated() {
    return $this->updated_at;
  }

  abstract function save();
  abstract static function new(...$args);
  abstract static function load($id);
}
?>
