<?php

    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/register.tpl.php');

    drawRegister($session);

    /*    
    if(User::duplicateUsername($db, $_POST['username'])){
		$_SESSION['ERROR'] = 'Duplicated Username';
		header("Location:".$_SERVER['HTTP_REFERER']."");
	}
	else if(User::duplicateEmail($db, $_POST['email'])){
		$_SESSION['ERROR'] = 'Duplicated Email';
		header("Location:".$_SERVER['HTTP_REFERER']."");
	}
 	else if (($userID = User::createUser($db, $_POST['username'], $_POST['password'], $_POST['name'], $_POST['email'])) != -1) {
  		echo 'User Registered successfully';
 		setCurrentUser($userID, $_POST['username']);
        header("Location:../pages/client.php");
 	}
 	else{
  		$_SESSION['ERROR'] = 'ERROR';
  		header("Location:".$_SERVER['HTTP_REFERER']."");
 	}

    
    require_once(__DIR__ . '/../templates/register.tpl.php');
    */
?>