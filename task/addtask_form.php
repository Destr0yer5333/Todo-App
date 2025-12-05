<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="add-wrapper">

    <div class="add-box">

        <h2 class="add-title">Add New Task</h2>

        <form action="insert.php" method="POST">

            <label>Task Name</label>
            <input type="text" name="name" required>

            <label>Description</label>
            <textarea name="description" rows="5" required></textarea>

            <label>Priority Level</label>
            <select name="priority">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select>

            <label>Due Date</label>
            <input type="date" name="duedate" required>

            <button type="submit" class="add-btn">Add Task</button>

        </form>

        <a href="dashboard.php" class="back-btn">← Go Back</a>

    </div>

</div>

</body>
</html>
