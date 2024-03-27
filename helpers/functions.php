<?php 

function dd(...$data): void {
    var_dump($data);
    die;
    
}

function getParams($param, $default=null){
    return !empty($_REQUEST[$param])? $_REQUEST[$param]: $default;
}

function view(string $view,array $data = [], string $viewDir = 'app/Views/'): string {
    extract($data, EXTR_OVERWRITE);

     ob_start();
        require $viewDir . $view.'.tpl.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
}

function redirect(string $url = '/'): void {
    header("Location:$url");
    exit();
}

function isUserLoggedIn(): bool {
    return $_SESSION['loggedin'] ?? false;
}

function getUserLoggedInFullname(): string{
    return $_SESSION['userData']['username'] ?? '';
}

function getUserRole(): string{
    return $_SESSION['userData']['roletype'] ?? '';
}

function getUserUsername(): string {
    return $_SESSION['userData']['username'] ?? '';
}

function isUserAdmin(): bool{
    return getUserRole() === 'admin';
}

function userCanUpdate(): bool{
    $role = getUserRole();
    return  $role === 'admin' || $role === 'editor';
}

function getUserAvatar(): string{
    return $_SESSION['userData']['avatar'] ?? '';
}

function userCanDelete(): bool{
    return  isUserAdmin();
}

function userCanManageProject($username): bool{
    $userUsername = getUserUsername();
    return isUserAdmin() || $userUsername === $username; 
}

function getUserId(): int {
    return $_SESSION['userData']['id'] ?? 0;
}

function getRemainingTime($deadline){
    $today = new Datetime(); 
    $date = new Datetime($deadline);
    
    
    if ($date < $today) {
        return "text-danger";
    }
    
    $interval = $today->diff($date); 
    $days = $interval->days; 

    if ($days > 10){
        return ""; 
    } else if ($days <= 10 && $days > 2){
        return "text-primary"; 
    } else{
        return "text-danger";
    }
}

function formatDate($date){
    $formatted = $date; 
    if (strtotime($formatted) !== false){ // date is in the right format
        $formatted = $date; 
    } else {
        $deadline = date('Y-m-d', strtotime($formatted));
    }

    return $formatted; 
}

function copyAvatar($file, $userID){

    $result = [
        "success" => false, 
        "message" => ""
    ];

    $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $filename = $userID."_".str_replace(".", "", microtime(true)).".".$file_extension;

    $avatarDir = "./public/avatar/";

    if (!move_uploaded_file($file['tmp_name'], $avatarDir.$filename)){

        $result = [
            "success" => false, 
            "message" => "COULD NOT MOVE UPLOADED FILE"
        ];  

    } else {

        // update avatar image for thumbnail
        if ($file_extension === "jpeg" || $file_extension === "jpg"){
            $newImg = imagecreatefromjpeg($avatarDir.$filename);
            if (!$newImg){
                $result = [
                    "success" => false, 
                    "message" => "COULD NOT CREATE THUMBNAIL RESOURCE"
                ]; 
                return $result; 
            }
            $thumbnailImag = imagescale($newImg, 200);
            if (!$thumbnailImag){
                $result = [
                    "success" => false, 
                    "message" => "COULD NOT SCALE THUMBNAIL RESOURCE"
                ]; 
                return $result; 
            };
            imagejpeg($thumbnailImag, $avatarDir.'thumb_'.$filename);

            $result = [
                "success" => true, 
                "message" => "AVATAR MOVED AND THUMBNAIL CREATED", 
                "avatar" => 'thumb_'.$filename
            ]; 
            return $result; 

        } else {
            $result = [
                "success" => false, 
                "message" => "FILE EXTENSION IS NOT SUPPORTED"
            ]; 
            return $result; 
        }

    };
};

function deleteOldAvatar($file){
    $result = [
        "success" => false, 
        "message" => ""
    ];

    $avatarDir = "./public/avatar/";

    // get the original file from thumbnail file
    $original = str_replace("thumb_", "", $file);

    // define the paths for those two files
    $filename = $avatarDir.$original; 
    $filenameThumb = $avatarDir.$file; 

    if (file_exists($filename)){
        unlink($filename);
    } else {
        $result = [
            "success" => false, 
            "message" => "The original file doesn't exist"
        ];
        return $result;
    }

    if (file_exists($filenameThumb)){
        unlink($filenameThumb);
    } else {
        $result = [
            "success" => false, 
            "message" => "The thumbnail file doesn't exist"
        ];
        return $result;
    }

    $result = [
        "success" => true, 
        "message" => "deleted successfully"
    ];

    return $result; 
};

function moveFile($file, $projectID, $userID, $file_name, $file_extension)
{
    $result = [
        "success" => false, 
        "message" => ""
    ]; 

    $uploadsDir = "./public/uploads/";

    if (!move_uploaded_file($file['tmp_name'], $uploadsDir.$file_name)){
        $result = [
            "success" => false, 
            "message" => "COULD NOT MOVE UPLOADED FILE"
        ]; 
        return $result;
    } else {
        $result = [
            "success" => true, 
            "message" => "FILE MOVED"
        ]; 
        return $result;
    }
};

function deleteFile($file){
    $result = [
        "success" => false, 
        "message" => ""
    ];

    $uploadsDir = "./public/uploads/";
    $filename = $uploadsDir.$file->path; 

    if (file_exists($filename)){
        unlink($filename);
    } else {
        $result = [
            "success" => false, 
            "message" => "The original file doesn't exist"
        ];
        return $result;
    }

    $result = [
        "success" => true, 
        "message" => "deleted successfully"
    ];

    return $result; 

};