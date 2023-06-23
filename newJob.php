<?php
include('Database.php');

// New instance of database class
$db = new Database("bns015", "aim8aiJ9");

$JobID = escapeshellarg($_POST[JobID]);
$CompanyName = escapeshellarg($_POST[CompanyName]);
$JobTitle = escapeshellarg($_POST[JobTitle]);
$Salary = escapeshellarg($_POST[Salary]);
$DesiredMajor = escapeshellarg($_POST[DesiredMajor]);

// User submits form
if (isset($_POST['submit'])) {
    // Input data
    $JobID = $_POST["JobID"];
    $CompanyName = $_POST["CompanyName"];
    $JobTitle = $_POST["JobTitle"];
	$Salary = $_POST["Salary"];
	$DesiredMajor = $_POST["DesiredMajor"];

	// Check if values are null
	if ($JobID != NULL && $CompanyName != NULL && $JobTitle != NULL && $Salary != NULL) {
		// Insert data into table
		$query = "INSERT INTO Jobs (JobID, CompanyName, JobTitle, Salary, DesiredMajor) 
					VALUES ($JobID, '$CompanyName', '$JobTitle', $Salary, '$DesiredMajor')";
		$result = $db->insertRecord($query);
	} else {
		// If null, return an error
		$result = false;
	}

	// Resulting success message or error message
    if ($result) {
        $message = "<p>Job added successfully</p>";
    } else {
        $message = "<p>Error adding job. Make sure the job ID is unique and that the company name exists in the Employer table.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css">
	<button onclick="window.location.href = 'index.html';">Home</button> <br>
    <title>Add New Job</title>
</head>
<body>
	<h2>Add New Job</h2>
	<form action="newJob.php" method="post">
		JobID: <input type="text" name="JobID"><br>
		CompanyName: <input type="text" name="CompanyName"><br>
		JobTitle: <input type="text" name="JobTitle"><br>
		Salary: <input type="text" name="Salary"><br>
		DesiredMajor: <input type="text" name="DesiredMajor"><br>
		<br><input name="submit" type="submit" value="Add Job">
	</form>
		<?php echo $message; ?>
</body>
</html>