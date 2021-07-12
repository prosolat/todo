<?php 
    // initialize errors variable
	$errors = "";

	// connect to database
	$dbconn = mysqli_connect("localhost", "todo", "testing1", "todo");
    if (!$dbconn) {
        echo "connection error";
    }

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "You must fill in the task";
		}else{
			$task = $_POST['task'];
			$sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($dbconn, $sql);
			header('location: new.php');
		}
	}	
    // delete task
if (isset($_GET['del_task'])) {
	$id = $_GET['del_task'];

	mysqli_query($dbconn, "DELETE FROM tasks WHERE id=".$id);
	header('location: new.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>OLAT ToDo PROGRAM</title>
    <style>
    .heading{
	width: 50%;
	margin: 30px auto;
	text-align: center;
	color: 	blue;
}
.add_btn{
    cursor: pointer;
}
form {
	width: 50%; 
	margin: 30px auto; 
	border-radius: 5px; 
	padding: 10px;
	background: #FFF8DC;
	border: 1px solid #6B8E23;
}
form p {
	color: red;
	margin: 0px;
}
.task_input {
	width: 75%;
	height: 15px; 
	padding: 10px;
    border-right: none;
    border-left: none;
    border-top: none;
	border-bottom: 2px solid #6B8E23;
}
.add_btn {
	height: 39px;
	background: #FFF8DC;
	color: 	#6B8E23;
	border: 2px solid #6B8E23;
	border-radius: 5px; 
	padding: 5px 20px;
}

table {
    width: 50%;
    margin: 30px auto;
    border-collapse: collapse;
}

tr {
	border-bottom: 1px solid #cbcbcb;
}

th {
	font-size: 19px;
	color: #6B8E23;
}

th, td{
	border: none;
    height: 30px;
    padding: 2px;
}

tr:hover {
	background: #E9E9E9;
}

.task {
	text-align: left;
}

.delete{
	text-align: center;
}
.delete a{
	color: white;
	background: #a52a2a;
	padding: 1px 6px;
	border-radius: 3px;
	text-decoration: none;
}</style>
</head>
<body>
	<div class="heading">
		<h2 style="font-style: 'Hervetica';">OLAT TO-DO LIST</h2>
        <P>MAKING YOUR PLANS COME TO LIVE</P>
	</div>
	<form method="post" action="new.php" class="input_form">
    <?php if (isset($errors)) { ?>
        <p><?php echo $errors; ?></p>
    <?php } ?>
		<input type="text" name="task" class="task_input" placeholder ='what would you like do today'>
		<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
	</form>
    <table>
	<thead>
		<tr>
			<th>S/N</th>
			<th>Tasks</th>
			<th style="width: 60px;">Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		// select all tasks if page is visited or refreshed
		$tasks = mysqli_query($dbconn, "SELECT * FROM tasks");

		$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
			<tr>
				<td> <?php echo $i; ?> </td>
				<td class="task"> <?php echo $row['task']; ?> </td>
				<td class="delete"> 
					<a href="new.php?del_task=<?php echo $row['id'] ?>">DEL</a> 
				</td>
			</tr>
		<?php $i++; } ?>	
	</tbody>
</table>
</body>
</html>