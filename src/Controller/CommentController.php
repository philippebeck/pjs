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
    if ($this->session->islogged()) {

      $data['article_id']   = $this->get->getGetVar('id');
      $data['content']      = $this->post->getPostVar('content');
      $data['created_date'] = $this->post->getPostVar('date');
      $data['user_id']      = $this->session->getUserVar('id');

      ModelFactory::getModel('Comment')->create($data);
      $this->cookie->createAlert('New comment created successfully !');

      $this->redirect('article!read', ['id' => $this->get->getGetVar('id')]);
    }
    $this->cookie->createAlert('You must be logged in to add a comment...');

    $this->redirect('user!login');
  }

    public function deleteMethod()
  {
    ModelFactory::getModel('Comment')->deleteData($this->get->getGetVar('id'));
    $this->cookie->createAlert('Comment permanently deleted !');

    $this->redirect('admin');
  }
}
