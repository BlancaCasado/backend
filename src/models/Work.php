<?php
require_once __DIR__.'/../../core/Model.php';

class Work extends Model
{
  function __construct()
  {
    parent::__construct();

    $this->table = 'works';
  }

 // GET /works  -> dame todas las obras
 public function getAll()
 {
   if ($this->table) {
     $sql = "SELECT * FROM ".$this->table;
     return $this->query($sql);
   } else {
     $this->error('Not table defind', 500);
   }
 }

  // POST /works  -> crea una nueva obra
  public function register($work)
  {
    extract($work);
    $sql = 'INSERT INTO works
              (title, theme, editor)
            VALUES
              (:title,  :theme, :editor)';
    $params = [
      [':title',$title],
      [':theme',$theme],
      [':editor',$editor],
    ];
    return $this->query($sql,$params);
  }
  
  // POST /works/{id}  -> actualiza una obra
  public function updateWork($id, $work)
  {
    extract($work);
    $sql = 'UPDATE works
            SET 
            title = :title,
            theme = :theme,
            editor = :editor
            WHERE  id = :id
            ';
    $params = [
      [':id', $id],
      [':title',$title],
      [':theme',$theme],
      [':editor',$editor],
    ];
    $this->query($sql,$params);
  }

  // GET /works/{id}/delete  -> elimina una obra
  public function deleteWork($id)
  {
    $sql = 'DELETE FROM works
            WHERE id = :id';
    $params = [
      [':id', $id],
    ];
    return $this->query($sql,$params);
  }

}