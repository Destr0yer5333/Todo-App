<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../user/login_form.php");
    exit();
}
@include "conn.php";

$user_id = $_SESSION['user_id'];

// FILTER REQUEST
$filter = $_GET['filter'] ?? 'all';
$priority = $_GET['priority'] ?? '';

$query = "SELECT * FROM task WHERE user_id='$user_id'";

// filter by status
if ($filter == 'pending') {
    $query .= " AND status=0";
} elseif ($filter == 'completed') {
    $query .= " AND status=1";
}

// filter by priority
if ($priority !== '') {
    $query .= " ORDER BY FIELD(priority,'High','Medium','Low')";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Tasks</title>
</head>
<body>

<div class="display-container">

    <!-- Top Area -->
    <div class="top-menu">
        <h1>Your Tasks</h1>
        <div class="buttons-wrap">
            <a href="dashboard.php" class="blue-btn">⬅ Dashboard</a>
            <a href="addtask_form.php" class="green-btn">+ Add Task</a>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filter-bar">
        <a href="display.php?filter=all" class="filter-btn <?= $filter=='all'?'active':'' ?>">All</a>
        <a href="display.php?filter=pending" class="filter-btn <?= $filter=='pending'?'active':'' ?>">Pending</a>
        <a href="display.php?filter=completed" class="filter-btn <?= $filter=='completed'?'active':'' ?>">Completed</a>

        <form class="priority-form" method="GET" action="display.php">
            <input type="hidden" name="filter" value="<?= $filter ?>">
            <select name="priority" onchange="this.form.submit()">
                <option value="">Priority Filter</option>
                <option value="high" <?= $priority=='high'?'selected':'' ?>>High First</option>
                <option value="medium" <?= $priority=='medium'?'selected':'' ?>>Medium First</option>
                <option value="low" <?= $priority=='low'?'selected':'' ?>>Low First</option>
            </select>
        </form>
    </div>

    <!-- TABLE SECTION -->
    <div class="table-container">
        <?php if ($result->num_rows > 0): ?>
        <table class="task-table">
            <tr>
                <th>ID</th>
                <th>Task</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['taskname']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>

                <td>
                    <span class="priority-badge <?= strtolower($row['priority']) ?>">
                        <?= $row['priority'] ?>
                    </span>
                </td>

                <td><?= $row['duedate'] ?></td>

                <td>
                    <?php if($row['status']==1): ?>
                        <a href="pending.php?id=<?= $row['id'] ?>" class="status-btn completed">Completed</a>
                    <?php else: ?>
                        <a href="complete.php?id=<?= $row['id'] ?>" class="status-btn pending">Pending</a>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="edit.php?idd=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>
        <?php else: ?>
            <p class="empty-msg">No tasks found!</p>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
