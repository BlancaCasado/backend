<?php
require_once __DIR__.'/../../core/Model.php';

class Genre extends Model
{
  function __construct()
  {
    parent::__construct();

    $this->table = 'genres';
  }

 // GET /genres  -> dame todos los géneros
 public function getAll()
 {
   if ($this->table) {
     $sql = "SELECT * FROM ".$this->table;
     return $this->query($sql);
   } else {
     $this->error('Not table defind', 500);
   }
 }

  // POST /genres  -> crea un nuevo género
  public function register($genre)
  {
    extract($genre);
    $sql = 'INSERT INTO genres
              (title)
            VALUES
              (:title)';
    $params = [
      [':title',$title],
    ];
    return $this->query($sql,$params);
  }
  
  // POST /genres/{id}  -> actualiza un género
  public function updateGenre($id, $genre)
  {
    extract($genre);
    $sql = 'UPDATE genres
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

  // GET /genres/{id}/delete  -> elimina un género
  public function deleteGenre($id)
  {
    $sql = 'DELETE FROM genres
            WHERE id = :id';
    $params = [
      [':id', $id],
    ];
    return $this->query($sql,$params);
  }

}