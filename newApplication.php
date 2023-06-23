<?php
include('Database.php');

// New instance of database class
$db = new Database("bns015", "aim8aiJ9");

$StudentID = escapeshellarg($_POST[StudentID]);
$JobID = escapeshellarg($_POST[JobID]);

// User submits form
if (isset($_POST['submit'])) {
    // Input data
    $StudentID = $_POST["StudentID"];
    $JobID = $_POST["JobID"];
	
	// Check if values are null
	if ($StudentID != NULL && $JobID != NULL) {
		// Insert data into table
		$query = "INSERT INTO Applications (StudentID, JobID) VALUES ($StudentID, $JobID)";
		$result = $db->insertRecord($query);
	} else {
		// If null, return an error
		$result = false;
	}

	// Resulting success message or error message
    if ($result) {
        $message = "<p>Application added successfully</p>";
    } else {
        $message = "<p>Unable to add Application. Make sure student ID and job ID exist.</p>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<button onclick="window.location.href = 'index.html';">Home</button> <br>
    <title>Add New Application</title>
</head>
<body>
	<h2>Add New Application</h2>
	<form action="newApplication.php" method="post">
		StudentID: <input type="text" name="StudentID"><br>
		JobID: <input type="text" name="JobID"><br>
		<br><input name="submit" type="submit" value="Add Application">
	</form>
		<?php echo $message; ?>
</body>
</html>