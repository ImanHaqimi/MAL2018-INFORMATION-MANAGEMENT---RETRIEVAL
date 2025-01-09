<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 90%;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Form</h2>
        <form method="post" action="">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
    </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $serverName = "your_server_name.database.windows.net";
        $connectionOptions = array(
            "Database" => "your_database_name",
            "Uid" => "your_username",
            "PWD" => "your_password"
        );

        // Establishes the connection
        $conn = sqlsrv_connect($serverName, $connectionOptions);

        if ($conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        $tsql = "SELECT password FROM users WHERE username = ?";
        $params = array($username);

        $stmt = sqlsrv_query($conn, $tsql, $params);

        if ($stmt === false) {
            echo "<div class='container'><p>Error: " . print_r(sqlsrv_errors(), true) . "</p></div>";
        } else {
            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            if ($row && password_verify($password, $row['password'])) {
                echo "<div class='container'><p>Login successful!</p></div>";
            } else {
                echo "<div class='container'><p>Invalid username or password.</p></div>";
            }
        }

        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
    }
    ?>
</body>
</html>