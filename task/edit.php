<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
   <link rel="stylesheet" href="../style.css">
</head>
<body>
</body>
</html>
<?php
@include "conn.php";

$id11 = $_GET['idd'];

$sql = "SELECT * FROM task WHERE id='$id11'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <div class="modern-container">
    <div class="modern-card">
<form action="edit_action.php" method="POST">
  <input type="hidden" name="id"  value="<?php echo $row['id']; ?>">
    Enter TaskName<input type="text" name="name" value="<?php echo $row['taskname']; ?>"><br>
    Enter Description<br>
    <textarea name="description" rows="5" cols="40"><?php echo $row['description']; ?></textarea>
     Priority Level
        <select name="priority" value="<?php echo $row['priority'];?>"><br>
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option></select><br> 
    Enter DueDate:<input type="date" name="duedate" value="<?php echo $row['duedate'];?>">
    <input type="submit" value="Add Task">
</form>
</div>
</div>
</body>
</html>