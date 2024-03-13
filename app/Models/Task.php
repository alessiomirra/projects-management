<?php 

namespace App\Models; 

use PDO; 

class Task 
{
    public function __construct(protected PDO $conn)
    {}

    public function getTaskById(int $taskID) 
    {
        $ret = []; 
        
        $sql = 'select t.*, u.username from tasks as t INNER JOIN user as u';
        $sql .= ' ON u.id=t.user_id where t.id=:id';

        $stm = $this->conn->prepare($sql); 

        if ($stm){
            $res = $stm->execute(['id' => $taskID]);
            if ($res){
                $ret = $stm->fetch();
            };
        };

        return $ret; 
    }

    public function getProjectTasks(int $projectID) :array 
    {
        $result = []; 

        $sql = 'select t.*, u.username, u.email from tasks as t INNER JOIN user as u';
        $sql .= ' ON u.id=t.user_id where project_id=:project_id ORDER BY t.id DESC';

        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':project_id', $projectID, PDO::PARAM_INT);

        if ($stm) {
            $stm->execute();
            $result = $stm->fetchAll();
        }

        return $result; 
    }

    public function getUserTasks(int $userID) :array
    {
        $result = []; 

        $sql = 'select t.*, u.username, u.email from tasks as t INNER JOIN user as u';
        $sql .= ' ON u.id=t.user_id where user_id=:userID';

        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':userID', $userID, PDO::PARAM_INT);

        if ($stm){
            $stm->execute();
            $result = $stm->fetchAll();
        }

        return $result; 
    }

    public function create(array $post) :bool 
    {
        $ret = false; 

        $sql = "INSERT INTO tasks (name, description, creation, deadline, user_id, project_id) values ";
        $sql .= "(:name, :description, NOW(), :deadline, :user_id, :project_id)";
        
        $stm = $this->conn->prepare($sql); 

        if ($stm){

            $res = $stm->execute([
                'name' => $post['name'], 
                'description' => $post['description'],
                'deadline' => $post['deadline'],
                'name' => $post['name'],
                'user_id' => $post['user_id'], 
                'project_id' => $post['project_id']
            ]);

            return $stm->rowCount();
        };

        return $ret; 
    }

    public function update(array $post, int $projectID){
        $ret = false; 

        $sql = "UPDATE tasks SET name=:name, description=:description, deadline=:deadline, status=:status ";
        $sql .= "where id=:taskID";

        $stm = $this->conn->prepare($sql);

        if ($stm){
            $res = $stm->execute([
                "name" => $post["name"],
                "description" => $post["description"], 
                "deadline" => $post["deadline"],
                "status" => $post["status"],
                "taskID" => $projectID
            ]);
            return $stm->rowCount();
        };

        return $ret; 
    }

    public function updateComplete(int $taskID){
        $ret = false; 

        $sql = "UPDATE tasks SET status=:status WHERE id=:taskID";

        $stm = $this->conn->prepare($sql);

        if ($stm){
            $res = $stm->execute([
                "status" => 'completed',
                "taskID" => $taskID
            ]);
            return $stm->rowCount();
        };

        return $ret; 
    }

    public function delete(int $taskID) :int 
    {
        $ret = 0; 

        $sql = 'DELETE FROM tasks where id=:taskID';

        $stm = $this->conn->prepare($sql);

        if ($stm) {
            $stm->bindParam('taskID', $taskID, PDO::PARAM_INT);

           $res = $stm->execute();

           return $stm->rowCount();
        }

        return $ret;
    }
}