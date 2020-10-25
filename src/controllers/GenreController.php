<?php
require_once __DIR__.'/../../core/Controller.php';
require_once __DIR__.'/../models/Genre.php';
require_once __DIR__.'/../validations/GenreValidation.php';

class genreController extends Controller
{

  function __construct()
  {
    parent::__construct();

    $this->validate = new GenreValidation();
    $this->genre = new Genre();
  }

  public function getAll()
  {
    $this->responseJson($this->genre->getAll());
  }

  public function getGenre($idgenre)
  {
    $this->responseJson($this->genre->getById($idgenre));
  }

  public function register()
  {
    $this->validate->validationRegisterGenre($this->request);
    $genre = [
      'title' => $this->request['title'],
    ];

    $idgenre = $this->genre->register($genre);
    $genre = $this->genre->getById($idgenre);
    $this->responseJson(["genre" => $genre]);
  }

  public function updGenre($id)
  {
    $genre = [
      'title' => $this->request['title'],
    ];
    $this->genre->updateGenre($id, $genre);
    $this->responseJson($genre);
  }
  

  public function delGenre($id)
  {
    $this->genre->deleteGenre($id);
    $this->responseJson('Genero borrado');
  }

}