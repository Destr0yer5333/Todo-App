<?php
session_start();
@include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("location: login_form.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get Total Tasks
$total = $conn->query("SELECT COUNT(*) AS total FROM task WHERE user_id = $user_id")->fetch_assoc()['total'];

// Pending Tasks
$pending = $conn->query("SELECT COUNT(*) AS total FROM task WHERE status = 0 AND user_id = $user_id")->fetch_assoc()['total'];

// Completed Tasks
$completed = $conn->query("SELECT COUNT(*) AS total FROM task WHERE status = 1 AND user_id = $user_id")->fetch_assoc()['total'];

// Tasks due today
$today = date("Y-m-d");
$due_today_query = $conn->query("SELECT * FROM task WHERE duedate = '$today' AND user_id = $user_id");
?>
<body>
    <link rel="stylesheet" href="../style.css">

<div class="layout">

    <!-- LEFT SIDEBAR -->
    <div class="sidebar">
        <h2 class="logo">TASK MANAGER</h2>

        <a href="dashboard.php" class="side-btn active">Dashboard</a>
        <a href="display.php" class="side-btn">View Tasks</a>
        <a href="addtask_form.php" class="side-btn">Add Task</a>
        <a href="../user/logout.php" class="side-btn logout">Logout</a>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="content">

        <h1 class="page-title">Dashboard Overview</h1>

        <!-- Stats Section -->
        <div class="stats-grid">
            <div class="stat-card">
                <h2><?= $total ?></h2>
                <p>Total Tasks</p>
            </div>

            <div class="stat-card">
                <h2><?= $pending ?></h2>
                <p>Pending Tasks</p>
            </div>

            <div class="stat-card completed">
                <h2><?= $completed ?></h2>
                <p>Completed</p>
            </div>

            <div class="stat-card today">
                <h2><?= $due_today_query->num_rows ?></h2>
                <p>Due Today</p>
            </div>
        </div>

        <br>

        <a class="view-btn" href="display.php">📄 View Your Tasks</a>

        <h2 class="section-title">🚨 Tasks Due Today</h2>

        <?php if ($due_today_query->num_rows > 0): ?>
            <div class="task-wrapper">
                <?php while($task = $due_today_query->fetch_assoc()): ?>
                    <div class="task-card due-today">
                        <div class="task-head">
                            <h3><?= htmlspecialchars($task['taskname']); ?></h3>
                            <span class="tag overdue">Due Today</span>
                        </div>

                        <p class="task-desc"><?= htmlspecialchars($task['description']); ?></p>

                        <div class="task-actions">
                            <a class="edit-btn" href="update.php?id=<?= $task['id']; ?>">Edit</a>
                            <a class="delete-btn" href="delete.php?id=<?= $task['id']; ?>">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="no-tasks">🎉 No tasks due today!</p>
        <?php endif; ?>
    </div>
</div>

</body>
