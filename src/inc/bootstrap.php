<?php
    session_start();
    const PROJECT_ROOT_PATH = __DIR__ . "/../";

// include main configuration file
    require_once PROJECT_ROOT_PATH . "/inc/config.php";

//// include the base controller file
    require_once PROJECT_ROOT_PATH . "/Controller/Api/BaseController.php";
    require_once PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";

// include the use model file
    require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";
    require_once PROJECT_ROOT_PATH . "/Model/Database.php";
    require_once PROJECT_ROOT_PATH . "/manager/UserManager.php";

    require_once PROJECT_ROOT_PATH . "/exceptions/exceptions.inc.php";

