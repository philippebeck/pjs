<?php

// *************************** \\
// ***** USER CONTROLLER ***** \\
// *************************** \\

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Pam\Helper\Session;


/** ********************************
* All control actions to the gallery
*/
class UserController extends Controller
{

  /** *******************************************************\
  * Checks if the user is registred & if his password matches
  * Then connects him if it's alright
  * Otherwise, display the login form
  * @return mixed => the rendering of the login form page
  */
  public function LoginAction()
  {
    // Checks if the form has been completed
    if (!empty($_POST))
    {
      // Search the user in the DB
      $user = ModelFactory::get('User')->read($_POST['email'], 'email');

      // Checks if the password is correct
      if (password_verify($_POST['pass'], $user['pass']))
      {
        // Creates the user session
        Session::createSession(
          $user['id'],
          $user['first_name'],
          $user['image'],
          $user['email']
        );
        // Creates a custom message to welcome the user
        Session::createAlert('Successful authentication, welcome ' . $user['first_name'] .' !', 'special');

        // Redirects to the view home
        $this->redirect('home');
      }
      else {
        // Creates an authentification fail message
        Session::createAlert('Failed authentication !', 'cancel');
      }
    }
    // Returns the rendering of the view loginUser
    return $this->render('user/loginUser.twig');
  }


  /** ****************************\
  * Destroys the session to logout
  */
  public function LogoutAction()
  {
    // Destroys the user session
    Session::destroySession();

    // Redirects to the view home
    $this->redirect('home');
  }


  /** ****************\
  * Creates a new user
  * @return mixed => the rendering of the view createUser
  */
  public function CreateAction()
  {
    // Checks if the form has been completed
    if (!empty($_POST))
    {
      // Search the user in the DB
      $user = ModelFactory::get('User')->read($_POST['email'], 'email');

      // Checks if the user exists already
      if (empty($user) == false)
      {
        // Creates a fail message to inform that an existing account uses this email address
        Session::createAlert('There is already a user account with this email address');
      }
      // Uploads the image & gets back the file name
      $data['image'] = $this->upload('img/user');

      // Hashes the user password
      $data['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);

      // Creates the $data array to store the new user
      $data['first_name']   = $_POST['first_name'];
      $data['last_name']    = $_POST['last_name'];
      $data['zipcode']      = $_POST['zipcode'];
      $data['country']      = $_POST['country'];
      $data['email']        = $_POST['email'];
      $data['created_date'] = $_POST['date'];
      $data['updated_date'] = $_POST['date'];

      // Creates a new user
      ModelFactory::get('User')->create($data);

      // Creates a valid message to confirm the creation of a new user
      Session::createAlert('New user created successfully !', 'valid');

      // Redirects to the view home
      $this->redirect('home');
    }
    else {
      // Returns the rendering of the view createUser with the empty fields
      return $this->render('user/createUser.twig');
    }
  }


  /** ************\
  * Updates a user
  * @return mixed => the rendering of the view updateUser
  */
  public function UpdateAction()
  {
    // Gets the article id, then stores it
    $id = $_GET['id'];

    // Checks if the form has been completed
    if (!empty($_POST))
    {
      // Checks if a new file has been uploaded
      if (!empty($_FILES['file']['name']))
      {
        // Uploads the user image, then stores it
        $data['image'] = $this->upload('img/user');
      }
      // Hashes the user password
      $data['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);

      // Retrieves form data, then stores the user
      $data['first_name']   = $_POST['first_name'];
      $data['last_name']    = $_POST['last_name'];
      $data['zipcode']      = $_POST['zipcode'];
      $data['country']      = $_POST['country'];
      $data['email']        = $_POST['email'];
      $data['updated_date'] = $_POST['date'];

      // Updates the selected user
      ModelFactory::get('User')->update($id, $data);

      // Creates an info message to confirm the update of the selected user
      Session::createAlert('Successful modification of the selected user !', 'info');

      // Redirects to the view home
      $this->redirect('home');
    }
    // Reads the selected user, then stores it
    $user = ModelFactory::get('User')->read($id);

    // Returns the rendering of the view updateUser with the current user
    return $this->render('user/updateUser.twig', ['user' => $user]);
  }


  /** ************\
  * Deletes a user
  */
  public function DeleteAction()
  {
    // Gets the user id, then stores it
    $id = $_GET['id'];

    // Deletes the selected user
    ModelFactory::get('User')->delete($id);

    // Creates a delete message to confirm the removal of the selected user
    Session::createAlert('User permanently deleted !');

    // Redirects to the view home
    $this->redirect('home');
  }
}
