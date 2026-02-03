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

// Tasks due today (ALL tasks - both pending and completed)
$today = date("Y-m-d");
$due_today_query = $conn->query("SELECT * FROM task WHERE duedate = '$today' AND user_id = $user_id");

// Tasks due today (ONLY PENDING - for counter)
$due_today_pending = $conn->query("SELECT COUNT(*) AS total FROM task WHERE duedate = '$today' AND status = 0 AND user_id = $user_id")->fetch_assoc()['total'];

// === STATISTICS ===

// Completion Rate
$completion_rate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

// Completed On Time (completed before or on due date)
$completed_on_time = $conn->query("
    SELECT COUNT(*) AS total 
    FROM task 
    WHERE status = 1 
    AND user_id = $user_id 
    AND duedate >= DATE(NOW())
")->fetch_assoc()['total'];

// Completed Late (completed after due date)
$completed_late = $conn->query("
    SELECT COUNT(*) AS total 
    FROM task 
    WHERE status = 1 
    AND user_id = $user_id 
    AND duedate < DATE(NOW())
")->fetch_assoc()['total'];

// On-time completion percentage
$on_time_percentage = $completed > 0 ? round(($completed_on_time / $completed) * 100, 1) : 0;
$late_percentage = $completed > 0 ? round(($completed_late / $completed) * 100, 1) : 0;

// Overdue Tasks (pending and past due date)
$overdue = $conn->query("
    SELECT COUNT(*) AS total 
    FROM task 
    WHERE status = 0 
    AND user_id = $user_id 
    AND duedate < '$today'
")->fetch_assoc()['total'];

// High Priority Tasks
$high_priority = $conn->query("
    SELECT COUNT(*) AS total 
    FROM task 
    WHERE user_id = $user_id 
    AND priority = 'High' 
    AND status = 0
")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TODO/style.css">
    <title>Dashboard</title>
</head>
<body>

<!-- Mobile Menu Toggle -->
<div class="mobile-menu-toggle" id="menuToggle">
    <span></span>
    <span></span>
    <span></span>
</div>

<div class="layout">

    <!-- LEFT SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <h2 class="logo">TASK MANAGER</h2>

        <a href="dashboard.php" class="side-btn active">Dashboard</a>
        <a href="display.php" class="side-btn">View Tasks</a>
        <a href="addtask_form.php" class="side-btn">Add Task</a>
        <a href="../user/logout.php" class="side-btn logout">Logout</a>
    </div>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
                <h2><?= $due_today_pending ?></h2>
                <p>Due Today</p>
            </div>
        </div>

        <!-- Detailed Statistics Section -->
        <h2 class="section-title">📊 Your Performance Statistics</h2>
        
        <div class="statistics-container">
            
            <!-- Completion Rate Card -->
            <div class="stat-detail-card">
                <div class="stat-icon">📈</div>
                <h3>Completion Rate</h3>
                <div class="percentage-bar">
                    <div class="percentage-fill" style="width: <?= $completion_rate ?>%"></div>
                </div>
                <p class="stat-number"><?= $completion_rate ?>%</p>
                <p class="stat-label"><?= $completed ?> of <?= $total ?> tasks completed</p>
            </div>

            <!-- On-Time Completion Card -->
            <div class="stat-detail-card">
                <div class="stat-icon">⏰</div>
                <h3>On-Time Completion</h3>
                <div class="percentage-bar">
                    <div class="percentage-fill success" style="width: <?= $on_time_percentage ?>%"></div>
                </div>
                <p class="stat-number"><?= $on_time_percentage ?>%</p>
                <p class="stat-label"><?= $completed_on_time ?> completed on time</p>
            </div>

            <!-- Late Completion Card -->
            <div class="stat-detail-card">
                <div class="stat-icon">⚠️</div>
                <h3>Late Completion</h3>
                <div class="percentage-bar">
                    <div class="percentage-fill warning" style="width: <?= $late_percentage ?>%"></div>
                </div>
                <p class="stat-number"><?= $late_percentage ?>%</p>
                <p class="stat-label"><?= $completed_late ?> completed late</p>
            </div>

            <!-- Additional Info Cards -->
            <div class="stat-detail-card mini">
                <div class="stat-icon-small">🔴</div>
                <h4>Overdue Tasks</h4>
                <p class="stat-number-small"><?= $overdue ?></p>
            </div>

            <div class="stat-detail-card mini">
                <div class="stat-icon-small">🔥</div>
                <h4>High Priority</h4>
                <p class="stat-number-small"><?= $high_priority ?></p>
            </div>

        </div>

        <br>

        <a class="view-btn" href="display.php">📄 View Your Tasks</a>

        <h2 class="section-title">🚨 Tasks Due Today</h2>

        <?php if ($due_today_query->num_rows > 0): ?>
            <div class="task-wrapper">
                <?php while($task = $due_today_query->fetch_assoc()): ?>
                    <div class="task-card due-today <?= $task['status'] == 1 ? 'completed-task' : '' ?>">
                        <div class="task-head">
                            <h3>
                                <?php if($task['status'] == 1): ?>
                                    <span class="checkmark">✓</span>
                                <?php endif; ?>
                                <?= htmlspecialchars($task['taskname']); ?>
                            </h3>
                            <?php if($task['status'] == 1): ?>
                                <span class="tag completed-tag">Completed</span>
                            <?php else: ?>
                                <span class="tag overdue">Due Today</span>
                            <?php endif; ?>
                        </div>

                        <p class="task-desc"><?= htmlspecialchars($task['description']); ?></p>

                        <div class="task-actions">
                            <a class="edit-btn" href="edit.php?id=<?= $task['id']; ?>">Edit</a>
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

<script>
// Only toggle sidebar when clicking the hamburger menu
document.getElementById('menuToggle').addEventListener('click', function(e) {
    e.stopPropagation();
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
});

// Close sidebar when clicking overlay
document.getElementById('sidebarOverlay').addEventListener('click', function(e) {
    e.stopPropagation();
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
});

// Close sidebar when clicking on a sidebar link (mobile only)
document.querySelectorAll('.side-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        if (window.innerWidth <= 768) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        }
    });
});
</script>

</body>
</html>