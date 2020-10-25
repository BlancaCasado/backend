<?php
require_once __DIR__.'/../../core/Model.php';

class History extends Model
{
  function __construct()
  {
    parent::__construct();

    $this->table = 'histories';
  }

 // GET /histories  -> dame todas las noticias de historia
 public function getAll()
 {
   if ($this->table) {
     $sql = "SELECT * FROM ".$this->table;
     return $this->query($sql);
   } else {
     $this->error('Not table defind', 500);
   }
 }

  // POST /histories  -> crea una nueva noticia de historia
  public function register($history)
  {
    extract($history);
    $sql = 'INSERT INTO histories
              (title)
            VALUES
              (:title)';
    $params = [
      [':title',$title],
    ];
    return $this->query($sql,$params);
  }
  
  // POST /histories/{id}  -> actualiza una noticia de historia
  public function updateHistory($id, $history)
  {
    extract($history);
    $sql = 'UPDATE histories
            SET 
            title = :title
            WHERE  id = :id
            ';
    $params = [
      [':id', $id],
      [':title',$title],
    ];
    $this->query($sql,$params);
  }

  // GET /histories/{id}/delete  -> elimina una noticia de historia
  public function deleteHistory($id)
  {
    $sql = 'DELETE FROM histories
            WHERE id = :id';
    $params = [
      [':id', $id],
    ];
    return $this->query($sql,$params);
  }

}