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
    if ($this->globals->getSession()->islogged()) {

      if ($this->globals->getSession()->getUserVar('email')) {

        $allArticles  = ModelFactory::getModel('Article')->listData();
        $allComments  = ModelFactory::getModel('Comment')->listData();
        $allUsers     = ModelFactory::getModel('User')   ->listData();

        return $this->render('admin/admin.twig', [
          'allArticles'       => $allArticles,
          'allComments'       => $allComments,
          'allUsers'          => $allUsers
        ]);
      }
      $this->globals->getSession()->createAlert('Access reserved for the site administrator');

      $this->redirect('home');
    }
    $this->globals->getSession()->createAlert('You must be logged in to access the administration');

    $this->redirect('user!login');
  }
}
