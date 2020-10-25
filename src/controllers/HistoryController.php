<?php
require_once __DIR__.'/../../core/Controller.php';
require_once __DIR__.'/../models/History.php';
require_once __DIR__.'/../validations/HistoryValidation.php';

class historyController extends Controller
{

  function __construct()
  {
    parent::__construct();

    $this->validate = new AuthorValidation();
    $this->history = new History();
  }

  public function getAll()
  {
    $this->responseJson($this->history->getAll());
  }

  public function getHistory($idhistory)
  {
    $this->responseJson($this->history->getById($idhistory));
  }

  public function register()
  {
    $this->validate->validationRegisterHistory($this->request);
    $history = [
      'title' => $this->request['title'],
    ];

    $idhistory = $this->history->register($history);
    $history = $this->history->getById($idhistory);
    $this->responseJson(["history" => $history]);
  }

  public function updHistory($id)
  {
    $history = [
      'title' => $this->request['title'],
    ];
    $this->history->updateHistory($id, $history);
    $this->responseJson($history);
  }
  

  public function delHistory($id)
  {
    $this->history->deleteHistory($id);
    $this->responseJson('Noticia de historia borrada');
  }

}