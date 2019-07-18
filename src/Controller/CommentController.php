<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;

/**
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends Controller
{
    public function createAction()
  {
    if ($this->session->islogged()) {

      $data['article_id']   = $this->get->getGetVar('id');
      $data['content']      = $this->post->getPostVar('content');
      $data['created_date'] = $this->post->getPostVar('date');
      $data['user_id']      = $this->session->userId();

      ModelFactory::get('Comment')->create($data);
      $this->cookie->createAlert('New comment created successfully !');

      $this->redirect('article!read', ['id' => $this->get->getGetVar('id')]);
    }
    $this->cookie->createAlert('You must be logged in to add a comment...');

    $this->redirect('user!login');
  }

    public function deleteAction()
  {
    ModelFactory::get('Comment')->delete($this->get->getGetVar('id'));
    $this->cookie->createAlert('Comment permanently deleted !');

    $this->redirect('admin');
  }
}
