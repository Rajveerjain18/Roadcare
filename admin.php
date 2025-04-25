<?php
session_start();

$admin_username = 'admin';
$admin_password = 'admin123';

if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        isset($_POST['username']) &&
        isset($_POST['password'])) {
        
        if ($_POST['username'] === $admin_username &&
            $_POST['password'] === $admin_password) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            $error = "Invalid credentials";
        }
    }
    
    if (!isset($_SESSION['admin_logged_in'])) {
        include 'admin_login.php';
        exit();
    }
}

$db_host = 'localhost';
$db_user = 'root'; 
$db_pass = '18Rajveer@18';     
$db_name = 'roadcare'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['issue_id']) && isset($_POST['status'])) {
    $issue_id = $conn->real_escape_string($_POST['issue_id']);
    $status = $conn->real_escape_string($_POST['status']);
    
    $sql = "UPDATE issues SET status = '$status' WHERE id = '$issue_id'";
    if (!$conn->query($sql)) {
        echo "Error updating status: " . $conn->error;
    }
}

// Fetch issues
$sql = "SELECT * FROM issues ORDER BY created_at DESC";
$result = $conn->query($sql);
if (!$result) {
    die("Error fetching issues: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - RoadCare</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .dashboard-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background-color: var(--white);
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 0.875rem;
            color: var(--gray-600);
            margin-bottom: 0.5rem;
        }

        .stat-card p {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .issues-table {
            width: 100%;
            background-color: var(--white);
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .issues-table th,
        .issues-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--gray-200);
        }

        .issues-table th {
            background-color: var(--gray-50);
            font-weight: 500;
            color: var(--gray-700);
        }

        .status-select {
            padding: 0.25rem 0.5rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.375rem;
            background-color: var(--white);
        }

        .priority-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .priority-urgent {
            background-color: #fef2f2;
            color: #991b1b;
        }

        .priority-high {
            background-color: #fff7ed;
            color: #9a3412;
        }

        .priority-medium {
            background-color: #fef3c7;
            color: #92400e;
        }

        .priority-low {
            background-color: #f0fdf4;
            color: #166534;
        }

        .logout-button {
            background-color: var(--red-500);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }

        .logout-button:hover {
            background-color: #dc2626;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="admin-container">
        <div class="dashboard-header">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
            <a href="logout.php" class="logout-button ml-auto">Logout</a>
        </div>

        <div class="dashboard-stats">
            <div class="stat-card">
                <h3>Total Issues</h3>
                <p><?php echo $result->num_rows; ?></p>
            </div>
            <div class="stat-card">
                <h3>Pending Issues</h3>
                <p><?php 
                    $pending = $conn->query("SELECT COUNT(*) as count FROM issues WHERE status = 'pending'")->fetch_assoc();
                    echo $pending['count'];
                ?></p>
            </div>
            <div class="stat-card">
                <h3>Resolved Issues</h3>
                <p><?php 
                    $resolved = $conn->query("SELECT COUNT(*) as count FROM issues WHERE status = 'completed'")->fetch_assoc();
                    echo $resolved['count'];
                ?></p>
            </div>
        </div>

        <div class="issues-table-container">
            <table class="issues-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Reported On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td>
                                <span class="priority-badge priority-<?php echo strtolower($row['priority']); ?>">
                                    <?php echo ucfirst($row['priority']); ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="issue_id" value="<?php echo $row['id']; ?>">
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $row['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="in-progress" <?php echo $row['status'] === 'in-progress' ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="completed" <?php echo $row['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="view_issue.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800">View</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- E-Support Column -->
    <div id="e-support-column" style="position: fixed; top: 0; right: 0; width: 300px; height: 100%; background-color: #f9f9f9; border-left: 1px solid #ccc; box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); overflow-y: auto; padding: 1rem;">
        <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem;">E-Support</h2>
        <iframe src="chat_service_url" style="width: 100%; height: calc(100% - 2rem); border: none;"></iframe>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script>
        // Example script for initializing the chat service
        // Replace 'chat_service_url' with the actual URL of your chat service
        console.log("E-Support column loaded.");
    </script>

    <script src="main.js"></script>
</body>
</html>