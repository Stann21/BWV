<?php
session_start();

if (isset($_POST['submit'])) {
    include 'dbh.inc.php';

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
	
	$sql = "SELECT * FROM users WHERE user_email='$uid'";
	$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$activation = $row['user_activated'];
			}
		}
	
    //Errors
    //Check if inputs are empty, || = Pipe, means or
    if (empty($uid) || empty($pwd)) {
        header("Location: ../index.php?login=empty");
        exit();
    }else {
        //Check if username excist in database
        $sql = "SELECT * FROM users WHERE user_email='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
		if($activation == '1') {
			header("Location: ../index.php?login=error");
            exit();
		}
        if ($resultCheck < 1){
            header("Location: ../index.php?login=error");
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)){
                //De-hashing the password
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false) {
                    header("Location: ../index.php?login=error");
                    exit();
                } elseif ($hashedPwdCheck == true) {
                    //Log in the user here
                    $_SESSION['u_id'] =$row['user_id'];
                    $_SESSION['u_first'] =$row['user_first'];
                    $_SESSION['u_last'] =$row['user_last'];
                    $_SESSION['u_email'] =$row['user_email'];
					
					$userid = $row['user_id'];
					
					if ($row['user_id'] == '1') {
					    header("Location: ../dashboard.php?user=1");
					} else {
						header("Location: ../dashboard.php?user=$userid");
					}
                    exit();
                }
            }
        }
    }

} else {
    header("Location: ../index.php?login=error");
    exit();
}