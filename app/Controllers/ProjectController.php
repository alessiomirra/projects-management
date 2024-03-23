<?php 

namespace App\Controllers; 

use App\Models\Project;
use App\Models\Task; 
use App\Models\User; 
use App\Models\File; 

use PDO; 

class ProjectController extends BaseController
{
    protected Project $project; 

    public function __construct(
        protected ?PDO $conn
    ){
        parent::__construct($conn);
        $this->project = new Project($conn);
    }

    public function home() :void 
    {
        $this->redirectIfNotLoggedIn();

        $projects = $this->project->all();
        $this->content = view('home', compact('projects'), $this->tplDir);
    }

    public function getProject(int $projectID) :void 
    {
        $this->redirectIfNotLoggedIn();

        $project = $this->project->findProjectByID($projectID);

        $tasksObj = new Task($this->conn);
        $tasks = $tasksObj->getProjectTasks($projectID);

        $filesObj = new File($this->conn);
        $files = $filesObj->getProjectFiles($projectID);

        $partecipants = [];

        foreach($tasks as $task){
            $partecipants[] = $task->username;
        }

        $this->content = view('project', compact('project', 'tasks', 'files', 'partecipants'));
    }

    public function create() :void 
    {
        $this->redirectIfNotLoggedIn(); 
        $this->content = view('newproject'); 
    }

    public function createTask(int $projectID) :void 
    {
        $this->redirectIfNotLoggedIn(); 

        $project = $this->project->findProjectByID($projectID);

        $instanceUser = new User($this->conn);
        $users = $instanceUser->getAll();

        if (userCanManageProject($project->username)){
            $this->content = view('newtask', compact('project', 'users'));
        } else {
            $_SESSION['message'] = "You cannot add tasks for that project because you're not its creator or the admin";
            redirect("/");
        }

    }

    public function edit(int $projectID) :void 
    {
        $this->redirectIfNotLoggedIn(); 

        $project = $this->project->findProjectByID($projectID);

        $control = userCanManageProject($project->username);

        if (!$control){
            $_SESSION["message"] = "You haven't permissions to edit this project"; 
            redirect('/');
        }

        $this->content = view('edit', compact('project')); 
    }

    public function editTask(int $projectID, int $taskID) :void 
    {
        $this->redirectIfNotLoggedIn();

        $taskObj = new Task($this->conn);
        $task = $taskObj->getTaskById($taskID); 

        $instanceUser = new User($this->conn);
        $users = $instanceUser->getAll();

        $this->content = view('editTask', compact('task', 'users'));
    }

    public function save(?int $projectID = null) :void 
    {
        $this->redirectIfNotLoggedIn(); 

        if (isset($_POST["deadline"]) && !empty($_POST["deadline"])){
            $deadline = formatDate($_POST["deadline"]);
        } else {
            $deadline = null; 
        }

        $post = [
            "name" => trim($_POST["name"]) ?? '', 
            "description" => trim($_POST["description"]) ?? '',
            "deadline" => $deadline ?? '', 
            "user_id" => getUserId(), 
            "notes" => trim($_POST["notes"]), 
        ];

        if (!$projectID){
            $new = $this->project->save($post); 

            if ($new !== null){
                redirect('/');
            } 
        } else {
            $project = $this->project->findProjectByID($projectID);
            $post["start"] = $project->start; 
            $this->project->update($post, $projectID);
            redirect('/project/'.$projectID);
        };

    }

    public function saveTask(int $projectID, ?int $taskID=null) :void 
    {
        $this->redirectIfNotLoggedIn();

        if (isset($_POST["deadline"]) && !empty($_POST["deadline"])){
            $deadline = formatDate($_POST["deadline"]);
        } else {
            $deadline = null; 
        };

        if (isset($_POST["user"]) && !empty($_POST["user"])){
            $userObj = new User($this->conn);
            $user = $userObj->getUserByUsername($_POST["user"]);
        }

        $post = [
            "name" => trim($_POST["name"]) ?? '', 
            "description" => trim($_POST["description"]) ?? '', 
            "deadline" => $deadline ?? '', 
            "user_id" => $user->id, 
            "project_id" => $projectID 
        ]; 

        if (!$taskID){
            $taskObj = new Task($this->conn); 
            $taskObj->create($post);
        } else {
            $post["status"] = $_POST["status"]; 
            $taskObj = new Task($this->conn); 
            $taskObj->update($post, $taskID);
        }

        redirect('/project/'.$projectID);
    }

    public function completedTask(int $taskID) :void 
    {
        $this->redirectIfNotLoggedIn();
        
        $taskObj = new Task($this->conn); 
        $task = $taskObj->getTaskById($taskID);

        $control = userCanManageProject($task->username);
        if (!$control){
            $_SESSION["message"] = "You haven't permissions to edit this project"; 
            redirect('/');
        }

        $taskObj->updateComplete($taskID);

        redirect("/project/".$task->project_id);
    }

    public function delete(int $projectID) :void 
    {
        $this->redirectIfNotLoggedIn(); 

        $this->project->delete($projectID);

        redirect("/"); 
    }

    public function deleteTask(int $taskID) :void 
    {
        $this->redirectIfNotLoggedIn();

        $taskObj = new Task($this->conn);
        $task = $taskObj->getTaskById($taskID);

        $taskObj->delete($taskID);

        redirect('/project/'.$task->project_id);
    }
    
    public function saveFile(int $projectID, int $userID) :void 
    {
        $this->redirectIfNotLoggedIn();

        $data = [
            "project_id" => $projectID, 
            "user_id" => $userID
        ]; 

        if (isset($_FILES["resource"])){
            $file = $_FILES["resource"];

            $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
            $filename = $userID."_project".$projectID."_".str_replace(".", "", microtime(true)).".".$file_extension;

            moveFile($file, $projectID, $userID, $filename, $file_extension);

            $data["file"] = $filename;
            $data["extension"] = $file_extension;
        }

        $data["description"] = trim($_POST["description"]) ?? "";

        $fileObj = new File($this->conn);
        $fileObj->saveFile($data);

        redirect('/project/'.$projectID);
    }

    public function showFile($fileID){
        $fileObj = new File($this->conn); 
        $file = $fileObj->getFileByID($fileID);

        $this->content = view('fileView', compact('file'), $this->tplDir);
    }

    public function deleteFile($fileID){
        $fileObj = new File($this->conn); 
        $file = $fileObj->getFileByID($fileID);

        if ($file){
            deleteFile($file);
            $res = $fileObj->delete($file->id);
            if ($res) {
                redirect('/project/'.$file->project_id);
            } else {
                echo "Something went wrong"; 
                die; 
            }
        }

    }

}

