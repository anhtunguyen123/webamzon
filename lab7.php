<?php
// Thiết lập thông tin kết nối đến database
$servername = "database-server-lab7.cocgl5wbv5ga.ap-southeast-1.rds.amazonaws.com";
$username = "admin";
$password = "12345678";
$dbname = "myDB";

// Tạo kết nối đến database
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Kiểm tra nếu form đã submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ form và kiểm tra
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        // Dùng Prepared Statement để tránh SQL Injection
        $stmt = $conn->prepare("SELECT * FROM User WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);

        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra kết quả
        if ($result->num_rows > 0) {
            echo "Bạn đã đăng nhập thành công.";
            // Có thể redirect hoặc tạo session ở đây
        } else {
            echo "Tên đăng nhập hoặc mật khẩu không đúng.";
        }

        $stmt->close();
    } else {
        echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
</head>
<body>
    <h2>Đăng nhập</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required><br><br>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
</body>
</html>
