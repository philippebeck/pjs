<?php

// **************************** \\
// ***** ADMIN CONTROLLER ***** \\
// **************************** \\

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Pam\Helper\Session;

use App\Helper\User;


/** ***************************************\
* All control actions to the administration
*/
class AdminController extends Controller
{

  /** *********************************************************************\
  * Reads all objects for CRUD actions from the database, then display them
  * @return mixed => the rendering of the view admin
  */
  public function IndexAction()
  {
    // Checks if the user is connected
    if (Session::islogged())
    {
      // Checks if the user is the administrator
      if (Session::userEmail() == User::adminEmail())
      {
        // Reads all users, then stores them
        $allUsers = ModelFactory::get('User')->list();

        // Returns the rendering of the view admin with the user datas
        return $this->render('admin.twig', ['allUsers' => $allUsers]);
      }
      else {
        // Creates a warning message to inform that only the admin can access to this page
        Session::createAlert('Access reserved for the site administrator', 'warning');

        // Redirects to the view home
        $this->redirect('home');
      }
    }
    else {
      // Creates a cancel message to ask to be connected
      Session::createAlert('You must be logged in to access the administration', 'cancel');

      // Redirects to the view loginUser
      $this->redirect('user!login');
    }
  }
}
