<?php

include($_SERVER['DOCUMENT_ROOT'] . "/sso/lib/database.php");
session_start();
if ($_SESSION != null)
{

        killSession($sso_pdo, $_SESSION['user_id']);
		
}
else
{
	echo 'No session to kill. ';
}

function killSession($pdo, $user_id)
{
        echo 'Killing session. ';
        if($query=$pdo->prepare("DELETE FROM sessions WHERE user_id = :user_id")) //LIMIT 1?
        {   
                $queryArray = array(
                        'user_id' => $user_id );
                $query->execute($queryArray);

                $_SESSION = array();
                if (ini_get("session.use_cookies"))
                {   
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time() - 42000,
                        $params["path"], $params["domain"],
                        $params["secure"], $params["httponly"] );
                }   
                session_destroy();
        }


}
header('Location: http://dev.emmell.org/PAL/sso/login.php');
?>
