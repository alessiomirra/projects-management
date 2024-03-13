<?php 

namespace App\Models; 

use PDO; 

class Project
{
    public function __construct(protected PDO $conn)
    {}

    public function all() :array 
    {
        $result = [];

        $sql = 'select p.*, u.username, u.email from projects as p INNER JOIN user as u';
        $sql .= ' ON u.id=p.user_id ORDER BY p.id DESC';
        $stm = $this->conn->query($sql);
        if ($stm && $stm->rowCount()) {
            $result = $stm->fetchAll();
        }; 

        return $result; 
    }

    public function findProjectByID(int $projectID){
        $ret = []; 

        $sql = 'select p.*, u.username from projects as p INNER JOIN user as u';
        $sql .= ' ON u.id=p.user_id where p.id = :id';
        
        $stm = $this->conn->prepare($sql); 
        if ($stm){
            $res = $stm->execute(['id' => $projectID]);
            if ($res){
                $ret = $stm->fetch();
            };
        };

        return $ret; 
    }

    public function save(array $post) :bool
    {
        $ret = []; 

        $sql = 'INSERT INTO projects (name, description, start, deadline, user_id, notes) values ';
        $sql .= ' (:name, :description, NOW(), :deadline, :user_id, :notes)';

        $stm = $this->conn->prepare($sql); 

        if ($stm){
            
            $res = $stm->execute([
                'name' => $post['name'],
                'description' => $post['description'],
                'deadline' => $post['deadline'], 
                'user_id' => $post['user_id'], 
                'notes' => $post['notes']
            ]);

            if (!$res){
                $_SESSION['message'] = "Something went wrong";
            }

            return $stm->rowCount(); 
        }

        return $ret;
    }

    public function update(array $post, int $projectID) :bool 
    {
        $ret = false; 

        $sql = "UPDATE projects SET name=:name, description=:description, start=:start, deadline=:deadline, user_id=:user_id, notes=:notes ";
        $sql .= "where id = :projectID";
        
        $stm = $this->conn->prepare($sql); 

        if ($stm){
            $res = $stm->execute([
                'name' => $post['name'],
                'description' => $post['description'],
                'start' => $post['start'],
                'deadline' => $post['deadline'],
                'user_id' => $post['user_id'],
                'notes' => $post['notes'],
                'projectID' => $projectID
            ]);

            return $stm->rowCount(); 

        };

        return $ret;
    }

    public function delete(int $projectID) :int 
    {
        $ret = 0; 

        $sql = 'DELETE FROM projects '; 
        $sql .= 'where id = :projectID';

        $stm = $this->conn->prepare($sql); 

        if ($stm){
            $stm->bindParam('projectID', $projectID, PDO::PARAM_INT);
            $res = $stm->execute(); 
            return $stm->rowCount();
        }; 

        return $ret; 
    }
}