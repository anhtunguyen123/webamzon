<?php
// Thiết lập thông tin kết nối đến database
$servername = "database-lab-v2.cndynac4jyld.us-east-1.rds.amazonaws.com";
$username_db = "admin";
$password_db = "anhtu123";
$dbname = "database-lab-v2";

// Tạo kết nối đến database
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Kiểm tra nếu form đã submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ form, chống SQL injection
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Sử dụng prepared statement để tránh SQL Injection
    $stmt = $conn->prepare("SELECT * FROM User WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password); // ss = string, string
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra số lượng bản ghi trả về
    if ($result->num_rows > 0) {
        echo "Bạn đã đăng nhập thành công";
        // Chuyển hướng hoặc thực hiện hành động tiếp theo
    } else {
        echo "Bạn đã đăng nhập không thành công";
    }

    $stmt->close();
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
