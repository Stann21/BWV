<?php
//Check if submit button is pressed,
if (isset($_POST['submit'])) {
	include_once 'dbh.inc.php';
	
	$name = mysqli_real_escape_string($conn, $_POST['groupname']);

	//Insert the user into the database
	// The ? below are parameter markers used for variable binding
	$sql = "INSERT INTO groups (groups_groupname) VALUES (?);";
	$stmt = $conn->prepare($sql);
	//Bind the variables
	$stmt->bind_param("s", $name);
	//Execute the prepared statement
	$stmt->execute();
	//Close the statement
	$stmt->close();
	
	header("Location: ../group.php?create=success&delete=0&user=1");
	exit();
}

//Check if delete button is pressed,
if (isset($_POST['delete'])) {
	include_once 'dbh.inc.php';
	
	//Delete group			
	$id = $_POST['deleteid'];
	// The ? below are parameter markers used for variable binding
	$sql = "DELETE FROM groups WHERE groups_id=?;";
	$stmt = $conn->prepare($sql);
	//Bind the variables
	$stmt->bind_param("i", $id);
	//Execute the prepared statement
	$stmt->execute();
	//Close the statement
	$stmt->close();

	header("Location: ../group.php?user=1&delete=$id");
	exit();
}
?>