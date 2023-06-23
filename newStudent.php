<?php
include('Database.php');

// New instance of database class
$db = new Database("bns015", "aim8aiJ9");

$StudentID = escapeshellarg($_POST[StudentID]);
$StudentName = escapeshellarg($_POST[StudentName]);
$Major = escapeshellarg($_POST[Major]);

// User submits form
if (isset($_POST['submit'])) {
    // Input data
    $StudentID = $_POST["StudentID"];
    $StudentName = $_POST["StudentName"];
    $Major = $_POST["Major"];
	
	// Check if values are null
	if ($StudentID != NULL && $StudentName != NULL && $Major != NULL) {
		// Insert data into table
		$query = "INSERT INTO Students (StudentID, StudentName, Major) VALUES ($StudentID, '$StudentName', '$Major')";
		$result = $db->insertRecord($query);
	} else {
		// If null, return an error
		$result = false;
	}
	
	// Resulting success message or error message
    if ($result) {
        $message = "<p>Student added successfully</p>";
    } else {
        $message = "<p>Error adding Student. Make sure student ID is unique.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<button onclick="window.location.href = 'index.html';">Home</button> <br>
    <title>Add New Student</title>
</head>
<body>
	<h2>Add New Student</h2>
	<form action="newStudent.php" method="post">
		StudentID: <input type="text" name="StudentID"><br>
		StudentName: <input type="text" name="StudentName"><br>
		Major: <input type="text" name="Major"><br>
		<br><input name="submit" type="submit" value="Add Student">
	</form>
		<?php echo $message; ?>
</body>
</html>