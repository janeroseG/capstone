<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Admin Credentials</title>
</head>
<body>
    <h2>Change Admin Credentials</h2>
    <form method="POST" action="update_admin_credentials.php">
        <label for="newEmail">New Email:</label>
        <input type="email" name="newEmail" required><br><br>
        
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required><br><br>
        
        <input type="submit" value="Update Credentials">
    </form>
</body>
</html>
