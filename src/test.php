<?php
    require_once 'api.php';
    require_once PROJECT_ROOT_PATH . 'manager/UserManager.php';
    $userManger = new UserManager();
//    try {
//        $userManger->createUser('adqweasd', "password");
//    } catch (InvalidEmailException $e) {
//        echo 'Invalid email';
//    } catch (InvalidPasswordException $e) {
//        echo 'Invalid password';
//    } catch (Exception $e) {
//        echo 'Error';
//    }
    echo json_encode($_SESSION);
    $userManger->login('adqweasd', "password");
    echo json_encode($_SESSION);
    $userManger->logout();
    echo json_encode($_SESSION);

