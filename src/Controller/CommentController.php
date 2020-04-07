<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;

/**
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends MainController
{
    public function createMethod()
  {
    if ($this->globals->getSession()->islogged()) {

      $data['article_id']   = $this->globals->getGet()->getGetVar('id');
      $data['content']      = $this->globals->getPost()->getPostVar('content');
      $data['created_date'] = $this->globals->getPost()->getPostVar('date');
      $data['user_id']      = $this->globals->getSession()->getUserVar('id');

      ModelFactory::getModel('Comment')->create($data);
      $this->globals->getSession()->createAlert('New comment created successfully !');

      $this->redirect('article!read', ['id' => $this->globals->getGet()->getGetVar('id')]);
    }
    $this->globals->getSession()->createAlert('You must be logged in to add a comment...');

    $this->redirect('user!login');
  }

    public function deleteMethod()
  {
    ModelFactory::getModel('Comment')->deleteData($this->globals->getGet()->getGetVar('id'));
    $this->globals->getSession()->createAlert('Comment permanently deleted !');

    $this->redirect('admin');
  }
}
