<?php
    require_once 'inc/bootstrap.php';

    use Auth\Exceptions\InvalidEmailException;
    use Auth\Exceptions\InvalidPasswordException;
    use Managers\UserManager;

//    $userManger = new UserManager();
//    try {
//        $userManger->createUser('testUser', "password");
//    } catch (InvalidEmailException $e) {
//        echo 'Invalid email';
//    } catch (InvalidPasswordException $e) {
//        echo 'Invalid password';
//    } catch (Exception $e) {
//        echo 'Error';
//    }
//    echo json_encode($_SESSION);
//    $userManger->login('testUser', "password");
    $userModel = new \Models\UserModel();
    echo $userModel->update("UPDATE user SET password = ? WHERE id = ?", ["ss", 1235, 2000]);
//    echo json_encode($_SESSION);
//    $userManger->logout();
//    echo json_encode($_SESSION);

