<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
  {
    if ($this->session->islogged()) {

      if ($this->session->getUserVar('email')) {

        $allArticles  = ModelFactory::getModel('Article')->listData();
        $allComments  = ModelFactory::getModel('Comment')->listData();
        $allUsers     = ModelFactory::getModel('User')   ->listData();

        return $this->render('admin/admin.twig', [
          'allArticles'       => $allArticles,
          'allComments'       => $allComments,
          'allUsers'          => $allUsers
        ]);
      }
      $this->cookie->createAlert('Access reserved for the site administrator');

      $this->redirect('home');
    }
    $this->cookie->createAlert('You must be logged in to access the administration');

    $this->redirect('user!login');
  }
}
