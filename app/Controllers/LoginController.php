<?php 

namespace App\Controllers; 

use App\Models\User; 
use PDO; 

class LoginController extends BaseController
{
    public function __construct(
        protected ?PDO $conn
    ){
        parent::__construct($conn);
        $this->layout = "layout/auth.tpl.php";
    }

    private function generateToken() {
        $bytes = random_bytes(32);

        $token = bin2hex($bytes);
        $_SESSION['csrf'] = $token;
        return $token;
    }

    public function showLogin() {
        $this->content = view('login', [
            'token' => $this->generateToken(),
            'signup' => 0
        ]);
    }

    public function showSignup() {
        $this->content = view('login',
            [
                'token' => $this->generateToken(),
                'signup' => 1
            ]
        );
    }

    public function logout() {
        $_SESSION = [];
        redirect('/login');
    }

    public function login()
    {
        $token = $_POST['_csrf'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $result = $this->verifyLogin($username, $password, $token);

        $header = strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');

        if ($result['success']){
            session_regenerate_id();
            $_SESSION['loggedin'] = true; 
            $_SESSION['userID'] = $result['user']['id'];
            unset($result['user']['password']);
            $_SESSION['userData'] = $result['user'];
        } else {
            $_SESSION['message'] = $result['message'];
        };

        if ($header === 'XMLHTTPREQUEST'){
            ob_end_clean();
            echo json_encode($result);
            exit;
        } else {
            $result['success'] ? redirect('/') : redirect('/login');
        }
    }

    private function verifyLogin($username, $password, $token) :array 
    {
        $result = [
            'message' => 'USER LOGGED IN', 
            'success' => true
        ]; 

        if ($token !== $_SESSION['csrf']){
            $result = [
                'message' => 'TOKEN MISMATCH', 
                'success' => false
            ];
            return $result; 
        }; 

        $username = filter_var($username, FILTER_DEFAULT);
        if (!$username){
            $result = [
                'message' => 'ENTER AN USERNAME', 
                'success' => false
            ];
            return $result;
        }; 

        if (strlen($password) < 6){
            $result = [
                'message' => 'PASSWORD TOO SMALL', 
                'success' => false
            ];
            return $result; 
        };

        $user = new User($this->conn);
        $resUsername = $user->getUserByUsername($username);

        if (!$resUsername || !$resUsername->username){
            $result = [
                'message' => 'USER NOT FOUND', 
                'success' => false
            ]; 
            return $result; 
        };

        if (!password_verify($password, $resUsername->password)){
            $result = [
                'message' => 'WRONG PASSWORD', 
                'success' => false 
            ];
            return $result; 
        };

        $result['user'] = (array) $resUsername; 
        return $result; 
    }

    public function signup()
    {
        $token = $_POST['_csrf'] ?? ''; 
        $email = $_POST['email'] ?? '';
        $username = $_POST['username'] ?? ''; 
        $password = $_POST['password'] ?? ''; 

        $result = $this->verifySignUp($username, $email, $password, $token); 

        $header = strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');

        if ($result['success']){
            $user = new User($this->conn);

            $data['email'] = $email;
            $data['username'] = $username;
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);

            $resultSave = $user->saveUser($data); 
            $result['message'] = $resultSave['message'];
            if ($resultSave['success']) {
                $data['id'] = $resultSave['id'];
                session_regenerate_id();

                $_SESSION['loggedin'] = true;
                unset($data['password']);
                $_SESSION['userData'] = $data;
            };
        };

        if ($header === 'XMLHTTPREQUEST') {
            ob_end_clean();
            echo json_encode($result);
            exit;
        } else {
            if (!$result['success']) {
                $_SESSION['message'] = $result['message'];
            } else {
                $_SESSION['signedUp'] = true;
            }
            $result['success'] ? redirect('/') : redirect('/signup');
        }
    }

    private function  verifySignUp($username, $email, $password, $token)
    {
        $result = [
            'message' => 'USER SIGNED UP CORRECTLY',
            'success' => true
        ];

        if ($token !== $_SESSION['csrf']) {
            $result = [
                'message' => 'TOKEN MISMATCH',
                'success' => false
            ];
            return $result;
        }

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $result = [
                'message' => 'WRONG EMAIL',
                'success' => false
            ];
            return $result;
        }

        $username = filter_var($username, FILTER_DEFAULT);
        if (!$email) {
            $result = [
                'message' => 'WRONG USERNAME',
                'success' => false
            ];
            return $result;
        }

        if (strlen($password) < 6) {
            $result = [
                'message' => 'PASSWORD TOO SMALL',
                'success' => false
            ];
            return $result;
        }

        $user = new User($this->conn);
        $resUsername = $user->getUserByUsername($username);

        if ($resUsername && $resUsername->username) {
            $result = [
                'message' => 'A USER ALREADY EXISTS WITH THIS USERNAME',
                'success' => false
            ];
            return $result;
        }

        return $result;
    }
}
