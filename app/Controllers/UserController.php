<?php 

namespace App\Controllers; 

use App\Models\Project;
use App\Models\Task; 
use App\Models\User; 

use PDO; 

class UserController extends BaseController 
{
    public function __construct(
        protected ?PDO $conn
    ){
        parent::__construct($conn);
    }

    public function usersList() :void 
    {
        $this->redirectIfNotLoggedIn();

        $userObj = new User($this->conn);
        $users = $userObj->getAll();

        $this->content = view('usersList', compact("users"));
    }

    public function userPage(string $username) :void 
    {
        $user = new User($this->conn);
        $result = $user->getUserByUsername($username);

        $taskObj = new Task($this->conn);
        $tasks = $taskObj->getUserTasks($result->id);

        $this->content = view('user', compact('result', 'tasks')); 
    }

    public function deleteAccount(int $userID) :void
    {   
        $this->redirectIfNotLoggedIn();

        $userData = $_SESSION["userData"];

        if (getUserId() == $userID){
            // visitor deleting its own account
            // remember to log out the user and clean the $_SESSION
            $userObj = new User($this->conn); 
            $userObj->deleteAccount($userID);

            if ($userData["avatar"]){
                deleteOldAvatar($userData["avatar"]);
            }

            // logout the user
            $loginController = new LoginController($this->conn); 
            $loginController->logout();

        } else {
            $_SESSION['message'] = "You haven't permissions to delete that account";

            redirect('/');
        }
    }

    public function editAccount(int $userID) :void 
    {
        $this->redirectIfNotLoggedIn();

        $userObj = new User($this->conn);
        $user = $userObj->getUserByID($userID);

        $this->content = view('editUser' ,compact('user'));
    }

    public function edit(int $userID) :void 
    {
        $this->redirectIfNotLoggedIn();

        $userData = $_SESSION["userData"];

        $post = [
            'username' => trim($_POST["username"]) ?? '',
            'email' => trim($_POST["email"]) ?? '',
            'first_name' => trim($_POST["first_name"]) ?? '',
            'last_name' => trim($_POST["last_name"]) ?? '', 
        ];

        if ($_FILES["avatar"]){
            if ($userData["avatar"]){
                deleteOldAvatar($userData["avatar"]);
            }

            $res = copyAvatar($_FILES["avatar"], $userID);
            if ($res["success"]){
                $post["avatar"] = $res["avatar"];
            }
        };

        $userObj = new User($this->conn); 
        $userObj->edit($post, $userID);

        // logout the user
        $loginController = new LoginController($this->conn); 
        $loginController->logout();
    }

}