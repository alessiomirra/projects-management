<?php 

function view(string $view,array $data = [], string $viewDir = 'app/Views/'): string {
    
    extract($data, EXTR_OVERWRITE);

     ob_start();
        require $viewDir . $view.'.tpl.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
}

function dd(...$data): void {
    var_dump($data);
    die;
    
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