<?php
// Start session
session_start();

// Generate CSRF token
$csrf_token = bin2hex(random_bytes(32)); // Generate a random token
$_SESSION['csrf_token'] = $csrf_token; // Store the token in the session

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    echo "You are already logged in as user with ID: " . $_SESSION['user_id'];
} else {
    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            echo "CSRF token verification failed."; // or handle the error in your desired way
            exit;
        }

        // Get form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate username and password
        if (empty($username) || empty($password)) {
            echo "Please enter both username and password.";
        } else {
            // Validate username format
            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid username format. Please enter a valid email address.";
            } else {
                // Validate password complexity
                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
                    $password)) {
                    echo "Invalid password. Password must be at least 12 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@$!%*?&).";
                } else {
                    try {
                        // Authenticate against a database or other data source
                        // Example: Fetch user data from a database based on the provided username
                        // and compare the password hash with the stored password hash
                        $user_data = fetch_user_data_from_database($username);
                        if ($user_data) {
                            $stored_password_hash = $user_data['password_hash'];
                            if (password_verify($password, $stored_password_hash)) {
                                // Successful login
                                echo "Login successful!";
                                $_SESSION['user_id'] = $user_data['user_id']; // Store user ID in session

                                // Set secure session cookie
                                session_set_cookie_params([
                                    'lifetime' => 3600, // Set session cookie lifetime to 1 hour
                                    'path' => '/',
                                    'domain' => '.example.com', // Set domain to your own domain
                                    'secure' => true, // Cookie only transmitted over HTTPS
                                    'httponly' => true, // Cookie not accessible by JavaScript
                                    'samesite' => 'Lax' // Cookie not sent on cross-site requests
                                ]);
                                session_regenerate_id(true); // Generate a new session ID and delete the old one
                            } else {
                                // Failed login attempt
                                echo "Invalid username or password.";
                            }
                        } else {
                            // Failed login attempt
                            echo "Invalid username or password.";
                        }
                    } catch (Exception $e) {
                        // Error occurred during database operation
                        // Log the error for debugging
                        error_log("Database error: " . $e->getMessage());
                        echo "An error occurred. Please try again later.";
                    }
                }
            }
        }
    }
}

function fetch_user_data_from_database($username) {
    // Establish database connection
    $mysqli = new mysqli('localhost', 'username', 'password', 'database_name');
// Check connection
if ($mysqli->connect_errno) {
    // Connection failed
    error_log("Database connection failed: " . $mysqli->connect_error);
    echo "An error occurred. Please try again later.";
    exit;
}

// Prepare and execute query to fetch user data based on the provided username
$stmt = $mysqli->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Fetch user data
if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $stmt->close();
    $mysqli->close();
    return $row;
} else {
    $stmt->close();
    $mysqli->close();
    return false;
}
}
?>
