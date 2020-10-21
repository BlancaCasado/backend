<?php
require_once __DIR__.'/../../core/Controller.php';
require_once __DIR__.'/../models/Author.php';
require_once __DIR__.'/../validations/AuthorValidation.php';

class authorController extends Controller
{

  function __construct()
  {
    parent::__construct();

    $this->validate = new AuthorValidation();
    $this->author = new Author();
  }

  public function getAll()
  {
    $this->responseJson($this->author->getAll());
  }

  public function getAuthor($idauthor)
  {
    $this->responseJson($this->author->getById($idauthor));
  }

  public function register()
  {
    $this->validate->validationRegisterAuthor($this->request);
    $author = [
      'title' => $this->request['title'],
    ];

    $idauthor = $this->author->register($author);
    $author = $this->author->getById($idauthor);
    $this->responseJson(["author" => $author]);
  }

  public function updAuthor($id)
  {
    $author = [
      'title' => $this->request['title'],
    ];
    $this->author->updateAuthor($id, $author);
    $this->responseJson($author);
  }
  

  public function delAuthor($id)
  {
    $this->author->deleteAuthor($id);
    $this->responseJson('Autor borrado');
  }

}