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

if ($priority !== '') {
    if ($priority == 'high') {
        $query .= " ORDER BY FIELD(priority,'High','Medium','Low')";
    } elseif ($priority == 'medium') {
        $query .= " ORDER BY FIELD(priority,'Medium','High','Low')";
    } elseif ($priority == 'low') {
        $query .= " ORDER BY FIELD(priority,'Low','Medium','High')";
    }
} else {
    // Default ordering when no priority filter
    $query .= " ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/TODO/style.css">
    <title>Tasks</title>
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

        <a href="dashboard.php" class="side-btn">Dashboard</a>
        <a href="display.php" class="side-btn active">View Tasks</a>
        <a href="addtask_form.php" class="side-btn">Add Task</a>
        <a href="../user/logout.php" class="side-btn logout">Logout</a>
    </div>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN CONTENT -->
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
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td data-label="ID"><?= $row['id'] ?></td>
                        <td data-label="Task"><?= htmlspecialchars($row['taskname']) ?></td>
                        <td data-label="Description"><?= htmlspecialchars($row['description']) ?></td>

                        <td data-label="Priority">
                            <span class="priority-badge <?= strtolower($row['priority']) ?>">
                                <?= $row['priority'] ?>
                            </span>
                        </td>

                        <td data-label="Due Date"><?= $row['duedate'] ?></td>

                        <td data-label="Status">
                            <?php if($row['status']==1): ?>
                                <a href="pending.php?id=<?= $row['id'] ?>" class="status-btn completed">Completed</a>
                            <?php else: ?>
                                <a href="complete.php?id=<?= $row['id'] ?>" class="status-btn pending">Pending</a>
                            <?php endif; ?>
                        </td>

                        <td data-label="Actions" class="action-cell">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="delete-btn">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p class="empty-msg">No tasks found!</p>
            <?php endif; ?>
        </div>

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

</body></html>