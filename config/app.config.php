<?php 

use App\Controllers\ProjectController;
use App\Controllers\UserController;
use App\Controllers\LoginController;

return [
    'routes' => [
        'GET' => [
            "/" => [ProjectController::class, 'home'], 
            "login" => [LoginController::class, 'showLogin'],
            "signup" => [LoginController::class, 'showSignUp'], 
            'user/:username' => [UserController::class, 'userPage'],
            'user/edit/:id' => [UserController::class, 'editAccount'],
            'project/:id' => [ProjectController::class, 'getProject'],
            'project/create' => [ProjectController::class, 'create'], 
            'project/:id/edit' => [ProjectController::class, 'edit'],
            'project/:id/new-task' => [ProjectController::class, 'createTask'],
            'project/:projectID/task/:taskID' => [ProjectController::class, 'editTask']
        ], 
        'POST' => [
            'login' => [LoginController::class, 'login'], 
            'signup' => [LoginController::class, 'signup'],
            'logout' => [LoginController::class, 'logout'], 
            'create' => [ProjectController::class, 'save'], 
            'project/:id' => [ProjectController::class, 'save'], 
            'project/:id/delete' => [ProjectController::class, 'delete'], 
            'project/:projectID/save-task' => [ProjectController::class, 'saveTask'], 
            'project/:projectID/task/:taskID' => [ProjectController::class, 'saveTask'],
            'task/:taskID/delete' => [ProjectController::class, 'deleteTask'], 
            'task/:taskID/completed' => [ProjectController::class, 'completedTask'],
            'delete-account/:userID' => [UserController::class, 'deleteAccount'],
            'user/edit/:id' => [UserController::class, 'edit'],
        ]
    ]
];