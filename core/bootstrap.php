<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'app/Controllers/BaseController.php';
require_once 'app/Controllers/ProjectController.php';
require_once 'app/Controllers/UserController.php';
require_once 'app/Controllers/LoginController.php';
require_once 'db/DBPDO.php';
require_once 'db/DbFactory.php';
require_once 'app/Models/User.php';
require_once 'app/Models/Project.php';
require_once 'app/Models/Task.php';
require_once 'helpers/functions.php';
require_once 'config/app.config.php';
require_once 'core/Router.php';

