<?php

namespace Model;

class Task
{
  public $id;
  public $title;
  public $status;
  public $content;
  public $userID;
  public $priority;

  public function __construct($title, $status, $content, $userID, $priority)
  {
    $this->title = $title;
    $this->status = $status;
    $this->content = $content;
    $this->userID = $userID;
    $this->priority = $priority;
  }
}
