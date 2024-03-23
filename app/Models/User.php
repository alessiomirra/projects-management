<?php 

namespace App\Models; 

use PDO; 

class User 
{
    public function __construct(
        protected PDO $conn 
    ){}

    public function getAll() {
        $result = []; 

        $sql = "SELECT * FROM user"; 
        $stm = $this->conn->prepare($sql); 
        $res = $stm->execute(); 

        if ($res && $stm->rowCount()){
            $result = $stm->fetchAll(); 
        };

        return $result; 
    }

    public function getUserByUsername(string $username) :object
    {
        $result = new \stdClass();
        if (!$username) {
            return $result;
        }

        $sql = 'SELECT * FROM user WHERE username = :username';
        $stm = $this->conn->prepare($sql); 
        $res = $stm->execute(['username'=> $username]);

        if ($res && $stm->rowCount()){
            $result = $stm->fetch();
        }

        return $result; 
    }

    public function getUserByID(int $userID) :object 
    {
        $result = new \stdClass(); 

        $sql = 'SELECT * FROM user WHERE id = :id';
        $stm = $this->conn->prepare($sql);
        $res = $stm->execute(['id' => $userID]); 

        if ($res && $stm->rowCount()){
            $result = $stm->fetch();
        }

        return $result; 
    }

    public function saveUser(array $data)
    {
        $result = [
            'id' => 0,
            'success' => false, 
            'message' => 'PROBLEM SAVING USER'
        ]; 

        $sql = 'INSERT INTO user (username, email, password) ';
        $sql .= ' VALUES (:username, :email, :password)';

        $stm = $this->conn->prepare($sql); 

        if ($stm){
            $res = $stm->execute([
                'username' => $data["username"],
                'email' => $data["email"],
                'password' => $data["password"]
            ]);
            if ($res){
                $result['success'] = 1;
                $result['id'] = $this->conn->lastInsertId();
                $result['message'] = 'USER CREATED CORRECTLY';
            } else {
                $result['success']  = $this->conn->errorInfo();;
            }; 
        } else {
            $result['message'] = $this->conn->errorInfo();
        };
        return $result; 
    }

    public function deleteAccount(int $userID) :int 
    {
        $ret = 0; 

        $sql = 'DELETE FROM user WHERE id=:userID';

        $stm = $this->conn->prepare($sql); 

        if ($stm){
            $stm->bindParam('userID', $userID, PDO::PARAM_INT);

            $res = $stm->execute();

            return $stm->rowCount();
        };

        return $ret;
    }

    public function edit(array $post, int $userID) :bool 
    {
        $ret = false;

        $sql = "UPDATE user SET username=:username, email=:email, first_name=:first_name, last_name=:last_name, avatar=:avatar ";
        $sql .= " where id=:userID";

        $stm = $this->conn->prepare($sql); 

        if ($stm){

            $res = $stm->execute([
                "username" => $post["username"],
                "email" => $post["email"],
                "first_name" => $post["first_name"],
                "last_name" => $post["last_name"],
                "avatar" => $post["avatar"] ?? '',
                "userID" => $userID
            ]);

            return $stm->rowCount();

        }

        return $ret; 
    }
}