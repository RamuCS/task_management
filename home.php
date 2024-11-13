<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management System</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Background Styling */
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        /* Main Container */
        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
        }

        /* Title Styling */
        .title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #e0e4ff;
        }

        .subtitle {
            font-size: 16px;
            margin-bottom: 30px;
            color: #d1d9ff;
        }

        /* Button Styling */
        .btn {
            display: inline-block;
            width: 120px;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #1e90ff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #005cbf;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Task Management System</h1>
        <p class="subtitle">Organize your tasks efficiently</p>
        <a href="register.php" class="btn">Register</a>
        <a href="login.php" class="btn">Login</a>
    </div>
</body>
</html>
