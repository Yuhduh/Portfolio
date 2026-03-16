<?php
session_start();
require_once 'config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$conn = getConnection();
$success = '';
$error = '';

// Handle project C RUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create Project
    if (isset($_POST['create_project'])) {
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $image_url = htmlspecialchars(trim($_POST['image_url']));
        $link = htmlspecialchars(trim($_POST['link']));
        
        $stmt = $conn->prepare("INSERT INTO projects (title, description, image_url, link) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $description, $image_url, $link);
        
        if ($stmt->execute()) {
            $success = 'Project created successfully!';
        } else {
            $error = 'Error creating project.';
        }
        $stmt->close();
    }
    
    // Update Project
    if (isset($_POST['update_project'])) {
        $id = intval($_POST['project_id']);
        $title = htmlspecialchars(trim($_POST['title']));
        $description = htmlspecialchars(trim($_POST['description']));
        $image_url = htmlspecialchars(trim($_POST['image_url']));
        $link = htmlspecialchars(trim($_POST['link']));
        
        $stmt = $conn->prepare("UPDATE projects SET title = ?, description = ?, image_url = ?, link = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $title, $description, $image_url, $link, $id);
        
        if ($stmt->execute()) {
            $success = 'Project updated successfully!';
        } else {
            $error = 'Error updating project.';
        }
        $stmt->close();
    }
    
    // Delete Project
    if (isset($_POST['delete_project'])) {
        $id = intval($_POST['project_id']);
        
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $success = 'Project deleted successfully!';
        } else {
            $error = 'Error deleting project.';
        }
        $stmt->close();
    }
    
    // Delete Message
    if (isset($_POST['delete_message'])) {
        $id = intval($_POST['message_id']);
        
        $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $success = 'Message deleted successfully!';
        } else {
            $error = 'Error deleting message.';
        }
        $stmt->close();
    }
}

// Fetch all projects
$projects = $conn->query("SELECT * FROM projects ORDER BY id DESC");

// Fetch all messages
$messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");

// Get project for editing
$edit_project = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_project = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Portfolio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 100px 5% 50px;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }
        .admin-header h1 {
            color: var(--text-white);
            font-size: 2.5rem;
        }
        .logout-btn {
            background-color: #ff3232;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #cc0000;
        }
        .admin-section {
            background-color: var(--card-bg);
            border: 2px solid var(--border-gray);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .admin-section h2 {
            color: var(--primary-orange);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }
        .project-form {
            display: grid;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .projects-table, .messages-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        .projects-table th, .messages-table th {
            background-color: rgba(255, 102, 0, 0.1);
            color: var(--primary-orange);
            padding: 1rem;
            text-align: left;
            border-bottom: 2px solid var(--border-gray);
        }
        .projects-table td, .messages-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-gray);
            color: var(--text-gray);
        }
        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }
        .edit-btn {
            background-color: var(--primary-orange);
            color: var(--dark-bg);
        }
        .delete-btn {
            background-color: #ff3232;
            color: white;
        }
        .edit-btn:hover {
            background-color: var(--secondary-orange);
        }
        .delete-btn:hover {
            background-color: #cc0000;
        }
        .view-site-btn {
            background-color: var(--primary-orange);
            color: var(--dark-bg);
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-left: 1rem;
        }
        .view-site-btn:hover {
            background-color: var(--secondary-orange);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">Admin Panel</div>
            <div>
                <a href="index.php" class="view-site-btn"><i class="fas fa-eye"></i> View Site</a>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <div class="admin-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h1>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success" style="margin-bottom: 2rem;">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error" style="margin-bottom: 2rem;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Projects Management -->
        <div class="admin-section">
            <h2><i class="fas fa-folder"></i> Manage Projects</h2>
            
            <form method="POST" class="project-form">
                <div class="form-group">
                    <label for="title">Project Title</label>
                    <input type="text" id="title" name="title" value="<?php echo $edit_project ? htmlspecialchars($edit_project['title']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3" required><?php echo $edit_project ? htmlspecialchars($edit_project['description']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image_url">Image URL (optional)</label>
                    <input type="text" id="image_url" name="image_url" value="<?php echo $edit_project ? htmlspecialchars($edit_project['image_url']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="link">Project Link (optional)</label>
                    <input type="text" id="link" name="link" value="<?php echo $edit_project ? htmlspecialchars($edit_project['link']) : ''; ?>">
                </div>
                
                <?php if ($edit_project): ?>
                    <input type="hidden" name="project_id" value="<?php echo $edit_project['id']; ?>">
                    <button type="submit" name="update_project" class="btn-submit">
                        <i class="fas fa-save"></i> Update Project
                    </button>
                    <a href="admin.php" class="btn-secondary" style="display: inline-block; padding: 1rem 2rem; text-decoration: none; text-align: center;">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="create_project" class="btn-submit">
                        <i class="fas fa-plus"></i> Add Project
                    </button>
                <?php endif; ?>
            </form>

            <h3 style="color: var(--text-white); margin-top: 2rem; margin-bottom: 1rem;">All Projects</h3>
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($projects && $projects->num_rows > 0): ?>
                        <?php while($project = $projects->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $project['id']; ?></td>
                                <td><?php echo htmlspecialchars($project['title']); ?></td>
                                <td><?php echo htmlspecialchars(substr($project['description'], 0, 50)) . '...'; ?></td>
                                <td><?php echo $project['link'] ? '<a href="' . htmlspecialchars($project['link']) . '" target="_blank" style="color: var(--primary-orange);">View</a>' : 'N/A'; ?></td>
                                <td>
                                    <a href="?edit=<?php echo $project['id']; ?>" class="action-btn edit-btn">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                                        <button type="submit" name="delete_project" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this project?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">No projects found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Messages Management -->
        <div class="admin-section">
            <h2><i class="fas fa-envelope"></i> Contact Messages</h2>
            
            <table class="messages-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($messages && $messages->num_rows > 0): ?>
                        <?php while($message = $messages->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $message['id']; ?></td>
                                <td><?php echo htmlspecialchars($message['name']); ?></td>
                                <td><?php echo htmlspecialchars($message['email']); ?></td>
                                <td><?php echo htmlspecialchars($message['subject']); ?></td>
                                <td><?php echo htmlspecialchars(substr($message['message'], 0, 50)) . '...'; ?></td>
                                <td><?php echo date('M d, Y', strtotime($message['created_at'])); ?></td>
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                        <button type="submit" name="delete_message" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this message?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No messages found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
