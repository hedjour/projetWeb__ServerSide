<?php
    require_once 'inc/bootstrap.php';

    use Auth\Exceptions\InvalidEmailException;
    use Auth\Exceptions\InvalidPasswordException;
    use Managers\UserManager;

    $userManger = new UserManager();
    try {
        $userManger->createUser('adqweasd', "password");
    } catch (InvalidEmailException $e) {
        echo 'Invalid email';
    } catch (InvalidPasswordException $e) {
        echo 'Invalid password';
    } catch (Exception $e) {
        echo 'Error';
    }
    echo json_encode($_SESSION);
    $userManger->login('adqweasd', "password");
    echo json_encode($_SESSION);
    $userManger->logout();
    echo json_encode($_SESSION);

