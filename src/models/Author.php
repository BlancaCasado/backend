<?php
require_once __DIR__.'/../../core/Model.php';

class Author extends Model
{
  function __construct()
  {
    parent::__construct();

    $this->table = 'authors';
  }

 // GET /authors  -> dame todos los autores
 public function getAll()
 {
   if ($this->table) {
     $sql = "SELECT * FROM ".$this->table;
     return $this->query($sql);
   } else {
     $this->error('Not table defind', 500);
   }
 }

  // POST /authors  -> crea un nuevo autor
  public function register($author)
  {
    extract($author);
    $sql = 'INSERT INTO authors
              (title)
            VALUES
              (:title)';
    $params = [
      [':title',$title],
    ];
    return $this->query($sql,$params);
  }
  
  // POST /authors/{id}  -> actualiza un autor
  public function updateAuthor($id, $author)
  {
    extract($author);
    $sql = 'UPDATE authors
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

  // GET /authors/{id}/delete  -> elimina un autor
  public function deleteAuthor($id)
  {
    $sql = 'DELETE FROM authors
            WHERE id = :id';
    $params = [
      [':id', $id],
    ];
    return $this->query($sql,$params);
  }

}