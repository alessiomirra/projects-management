<?php 

namespace App\Models; 

use PDO; 

class File 
{
    public function __construct(protected PDO $conn)
    {}

    public function getFileByID(int $fileID)
    {
        $ret = []; 

        $sql = "SELECT * FROM files WHERE id=:id";

        $stm = $this->conn->prepare($sql); 

        if ($stm){
            $res = $stm->execute(['id' => $fileID]);
            if ($res){
                $ret = $stm->fetch();
            };
        };

        return $ret; 
    }

    public function saveFile(array $data) :bool 
    {
        $ret = false;

        $sql = "INSERT INTO files (user_id, project_id, path, extension, description, timestamp) values ";
        $sql .= "(:userID, :projectID, :path, :extension, :description, NOW())";

        $stm = $this->conn->prepare($sql); 

        if ($stm){
            $res = $stm->execute([
               'userID' => $data["user_id"],
               'projectID' => $data["project_id"], 
               'path' => $data["file"], 
               'extension' => $data["extension"], 
               'description' => $data["description"], 
            ]);

            return $stm->rowCount();
        }

        return $ret;
    }

    public function getProjectFiles(int $projectID) :array 
    {
        $result = [];

        $sql = 'select f.*, u.username from files as f INNER JOIN user as u';
        $sql .= ' ON u.id=f.user_id where project_id=:project_id ORDER BY f.id DESC';

        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':project_id', $projectID, PDO::PARAM_INT);

        if ($stm) {
            $stm->execute();
            $result = $stm->fetchAll();
        }

        return $result; 
    } 

    public function delete(int $fileID) :int 
    {
        $ret = 0; 

        $sql = 'DELETE FROM files where id=:fileID';

        $stm = $this->conn->prepare($sql);

        if ($stm) {
            $stm->bindParam('fileID', $fileID, PDO::PARAM_INT);

           $res = $stm->execute();

           return $stm->rowCount();
        }

        return $ret;
    }
}