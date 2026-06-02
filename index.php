<?php
ob_start();
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
date_default_timezone_set('Asia/Ho_Chi_Minh');

$db_host = 'localhost';
$db_name = 'ywvpewmp_thicongnghe';
$db_user = 'ywvpewmp_thicongnghe';
$db_pass = 'ywvpewmp_thicongnghe';

try {
 $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
 ]);

 $tables = [
     "CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) UNIQUE NOT NULL, password VARCHAR(255) NOT NULL, fullname VARCHAR(100) NOT NULL, role ENUM('admin', 'user') DEFAULT 'user', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",
     "CREATE TABLE IF NOT EXISTS exams (id INT AUTO_INCREMENT PRIMARY KEY, title VARCHAR(255) NOT NULL, code VARCHAR(50) NOT NULL, duration INT NOT NULL, description TEXT, status ENUM('active', 'inactive') DEFAULT 'active', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)",
     "CREATE TABLE IF NOT EXISTS questions (id INT AUTO_INCREMENT PRIMARY KEY, exam_id INT, q_type ENUM('mcq', 'tf') NOT NULL, q_index INT, content TEXT, shared_context TEXT, FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE)",
     "CREATE TABLE IF NOT EXISTS answers_mcq (question_id INT PRIMARY KEY, opt_a TEXT, opt_b TEXT, opt_c TEXT, opt_d TEXT, correct_opt CHAR(1), FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE)",
     "CREATE TABLE IF NOT EXISTS answers_tf (question_id INT PRIMARY KEY, part_a TEXT, is_a_true TINYINT(1), part_b TEXT, is_b_true TINYINT(1), part_c TEXT, is_c_true TINYINT(1), part_d TEXT, is_d_true TINYINT(1), FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE)",
     "CREATE TABLE IF NOT EXISTS results (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, exam_id INT, score DECIMAL(4,2), mcq_score DECIMAL(4,2), tf_score DECIMAL(4,2), time_taken INT, ip VARCHAR(45), device TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE)",
     "CREATE TABLE IF NOT EXISTS result_details (id INT AUTO_INCREMENT PRIMARY KEY, result_id INT, question_id INT, user_answer TEXT, is_correct TINYINT(1), points DECIMAL(4,2), FOREIGN KEY (result_id) REFERENCES results(id) ON DELETE CASCADE, FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE)",
     "CREATE TABLE IF NOT EXISTS settings (setting_key VARCHAR(50) PRIMARY KEY, setting_value TEXT)"
 ];
 foreach ($tables as $sql) { $pdo->exec($sql); }

 $patches = [
     "ALTER TABLE answers_mcq CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
     "ALTER TABLE answers_tf CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
     "ALTER TABLE questions CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
     "ALTER TABLE result_details CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
     "ALTER TABLE exams CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
     "ALTER TABLE users ADD COLUMN fullname VARCHAR(100) NOT NULL AFTER password",
     "ALTER TABLE exams ADD COLUMN code VARCHAR(50) NOT NULL AFTER title",
     "ALTER TABLE exams ADD COLUMN duration INT NOT NULL DEFAULT 45",
     "ALTER TABLE exams ADD COLUMN description TEXT",
     "ALTER TABLE exams ADD COLUMN is_shuffled TINYINT(1) NOT NULL DEFAULT 1",
     "ALTER TABLE exams ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active'",
     "ALTER TABLE questions ADD COLUMN q_type ENUM('mcq', 'tf') NOT NULL DEFAULT 'mcq' AFTER exam_id",
     "ALTER TABLE questions ADD COLUMN q_index INT NOT NULL DEFAULT 0 AFTER q_type",
     "ALTER TABLE questions ADD COLUMN content TEXT",
     "ALTER TABLE questions ADD COLUMN shared_context TEXT AFTER content",
     "ALTER TABLE results ADD COLUMN score DECIMAL(4,2)",
     "ALTER TABLE results ADD COLUMN mcq_score DECIMAL(4,2)",
     "ALTER TABLE results ADD COLUMN tf_score DECIMAL(4,2)",
     "ALTER TABLE results ADD COLUMN time_taken INT",
     "ALTER TABLE results ADD COLUMN ip VARCHAR(45)",
     "ALTER TABLE results ADD COLUMN device TEXT",
     "ALTER TABLE result_details ADD COLUMN user_answer TEXT",
     "DELETE FROM questions WHERE id NOT IN (SELECT question_id FROM answers_mcq) AND id NOT IN (SELECT question_id FROM answers_tf)"
 ];
 foreach ($patches as $patch) { try { $pdo->exec($patch); } catch (Exception $e) {} }

 $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
 if ($stmt->fetchColumn() == 0) {
     $default_pw = password_hash('admin123', PASSWORD_BCRYPT);
     $pdo->exec("INSERT INTO users (username, password, fullname, role) VALUES ('admin', '$default_pw', 'Quản Trị Viên', 'admin')");
 }

 $stmt = $pdo->query("SELECT COUNT(*) FROM settings");
 if ($stmt->fetchColumn() == 0) {
     $pdo->exec("INSERT INTO settings (setting_key, setting_value) VALUES 
         ('logo_type', 'icon'), 
         ('logo_icon', 'fa-solid fa-microchip'), 
         ('logo_image', ''), 
         ('favicon', '')");
 }

} catch (PDOException $e) { 
    die("<meta charset='UTF-8'><div style='text-align:center;margin-top:50px;font-family:sans-serif;'><h2>Lỗi kết nối CSDL</h2><p>Vui lòng kiểm tra lại thông tin DB.</p><p style='color:red; font-weight:bold;'>Chi tiết lỗi: " . htmlspecialchars($e->getMessage()) . "</p></div>"); 
}

if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }

function verify_csrf() { 
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        echo "<meta charset='UTF-8'><script>alert('Lỗi: Dữ liệu gửi lên quá lớn! Vui lòng giảm dung lượng và thử lại.'); history.back();</script>";
        exit;
    }
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) { 
        $nocache = time();
        echo "<meta charset='UTF-8'><script>alert('Lỗi xác thực phiên làm việc (CSRF Token). Vui lòng tải lại trang và thử lại!'); window.location.href='?action=home&nocache={$nocache}';</script>";
        exit;
    } 
}

function is_logged_in() { return isset($_SESSION['user_id']); }
function is_admin() { return isset($_SESSION['role']) && $_SESSION['role'] === 'admin'; }

$site_settings = [];
try {
   $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
   while ($row = $stmt->fetch()) {
       $site_settings[$row['setting_key']] = $row['setting_value'];
   }
} catch (Exception $e) {}

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
if (is_logged_in() && in_array($action, ['login', 'register'])) { $action = 'home'; }
if ($action == 'home' && is_admin()) { $action = 'admin'; }

$msg = ''; $msg_type = 'success';

if ($action == 'ajax_upload_image' && is_admin()) {
 header('Content-Type: application/json');
 if (!isset($_FILES['file'])) { echo json_encode(['error' => 'Không tìm thấy file']); exit; }
 $dir = 'uploads/'; if (!is_dir($dir)) mkdir($dir, 0777, true);
 $fileInfo = pathinfo($_FILES['file']['name']); $ext = strtolower($fileInfo['extension']);
 $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'];
 if (!in_array($ext, $allowed)) { echo json_encode(['error' => 'Chỉ chấp nhận file ảnh']); exit; }
 if ($_FILES['file']['size'] > 5 * 1024 * 1024) { echo json_encode(['error' => 'File quá lớn']); exit; }
 $filepath = $dir . uniqid('img_') . '_' . time() . '.' . $ext;
 if (move_uploaded_file($_FILES['file']['tmp_name'], $filepath)) { echo json_encode(['url' => $filepath]); } 
 else { echo json_encode(['error' => 'Lưu file thất bại.']); }
 exit;
}

if ($action == 'logout') { 
    session_unset(); 
    session_destroy(); 
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    header("Location: ?action=home&nocache=" . time()); 
    exit; 
}

if ($action == 'register' && $_SERVER['REQUEST_METHOD'] == 'POST') {
 verify_csrf();
 $user = trim($_POST['username']); $pass = $_POST['password']; $name = trim($_POST['fullname']);
 $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?"); $stmt->execute([$user]);
 if ($stmt->rowCount() > 0) { $msg = "Tài khoản đã tồn tại!"; $msg_type = 'error'; $action = 'register'; } 
 else {
     $hashed = password_hash($pass, PASSWORD_BCRYPT);
     $stmt = $pdo->prepare("INSERT INTO users (username, password, fullname) VALUES (?, ?, ?)");
     $stmt->execute([$user, $hashed, $name]);
     $msg = "Đăng ký thành công! Vui lòng đăng nhập."; $action = 'login';
 }
}

if ($action == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
 verify_csrf();
 $user = trim($_POST['username']); $pass = $_POST['password'];
 $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?"); $stmt->execute([$user]);
 $u = $stmt->fetch();
 if ($u && password_verify($pass, $u['password'])) {
     $_SESSION['user_id'] = $u['id']; 
     $_SESSION['username'] = $u['username'];
     $_SESSION['fullname'] = !empty($u['fullname']) ? $u['fullname'] : $u['username'];
     $_SESSION['role'] = $u['role'];
     
     session_write_close();
     
     if ($u['role'] === 'admin') { header("Location: ?action=admin"); exit; } 
     else { header("Location: ?action=home"); exit; }
 } else { $msg = "Sai tài khoản hoặc mật khẩu!"; $msg_type = 'error'; }
}

if ($action == 'admin_save_settings' && is_admin() && $_SERVER['REQUEST_METHOD'] == 'POST') {
   verify_csrf();
   $stmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = ?");
   $stmt->execute([$_POST['logo_type'], 'logo_type']);
   $stmt->execute([$_POST['logo_icon'], 'logo_icon']);
   $stmt->execute([$_POST['logo_image'], 'logo_image']);
   $stmt->execute([$_POST['favicon'], 'favicon']);
   
   header("Location: ?action=admin_settings&msg=" . urlencode("Lưu cài đặt thành công!")); exit;
}

if ($action == 'admin_toggle_exam' && is_admin() && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $pdo->exec("UPDATE exams SET status = IF(status='active', 'inactive', 'active') WHERE id = $id");
  header("Location: ?action=admin"); exit;
}
if ($action == 'admin_delete_exam' && is_admin() && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $pdo->exec("DELETE FROM exams WHERE id = $id");
  header("Location: ?action=admin&msg=Đã xóa đề thi"); exit;
}

if ($action == 'admin_submit_exam' && is_admin() && $_SERVER['REQUEST_METHOD'] == 'POST') {
 verify_csrf();
 try {
     $pdo->beginTransaction();
     $is_edit = !empty($_POST['edit_exam_id']);
     $is_shuffled = 1; 
     
     if ($is_edit) {
         $exam_id = intval($_POST['edit_exam_id']);
         $stmt = $pdo->prepare("UPDATE exams SET title=?, code=?, duration=?, description=?, is_shuffled=? WHERE id=?");
         $stmt->execute([$_POST['title'], $_POST['code'], $_POST['duration'], $_POST['description'], $is_shuffled, $exam_id]);
     } else {
         $stmt = $pdo->prepare("INSERT INTO exams (title, code, duration, description, is_shuffled) VALUES (?, ?, ?, ?, ?)");
         $stmt->execute([$_POST['title'], $_POST['code'], $_POST['duration'], $_POST['description'], $is_shuffled]);
         $exam_id = $pdo->lastInsertId();
     }

     for ($i=1; $i<=24; $i++) {
         $content = $_POST["mcq_{$i}_content"] ?? '';
         $shared_context = null; 
         $correct_opt = $_POST["mcq_{$i}_correct"] ?? NULL;
         $opt_a = $_POST["mcq_{$i}_a"] ?? '';
         $opt_b = $_POST["mcq_{$i}_b"] ?? '';
         $opt_c = $_POST["mcq_{$i}_c"] ?? '';
         $opt_d = $_POST["mcq_{$i}_d"] ?? '';
         
         if ($is_edit) {
             $q_id = $pdo->query("SELECT id FROM questions WHERE exam_id=$exam_id AND q_index=$i AND q_type='mcq'")->fetchColumn();
             if ($q_id) {
                 $pdo->prepare("UPDATE questions SET content=?, shared_context=? WHERE id=?")->execute([$content, $shared_context, $q_id]);
                 $pdo->prepare("UPDATE answers_mcq SET opt_a=?, opt_b=?, opt_c=?, opt_d=?, correct_opt=? WHERE question_id=?")
                     ->execute([$opt_a, $opt_b, $opt_c, $opt_d, $correct_opt, $q_id]);
             } else {
                 $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, shared_context) VALUES (?, 'mcq', ?, ?, ?)")->execute([$exam_id, $i, $content, $shared_context]);
                 $q_id = $pdo->lastInsertId();
                 $pdo->prepare("INSERT INTO answers_mcq (question_id, opt_a, opt_b, opt_c, opt_d, correct_opt) VALUES (?, ?, ?, ?, ?, ?)")
                     ->execute([$q_id, $opt_a, $opt_b, $opt_c, $opt_d, $correct_opt]);
             }
         } else {
             $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, shared_context) VALUES (?, 'mcq', ?, ?, ?)")->execute([$exam_id, $i, $content, $shared_context]);
             $q_id = $pdo->lastInsertId();
             $pdo->prepare("INSERT INTO answers_mcq (question_id, opt_a, opt_b, opt_c, opt_d, correct_opt) VALUES (?, ?, ?, ?, ?, ?)")
                 ->execute([$q_id, $opt_a, $opt_b, $opt_c, $opt_d, $correct_opt]);
         }
     }

     for ($i=25; $i<=28; $i++) {
         $content = $_POST["tf_{$i}_content"] ?? '';
         $shared_context = null; 
         $a_true = isset($_POST["tf_{$i}_a_true"]) ? 1 : 0;
         $b_true = isset($_POST["tf_{$i}_b_true"]) ? 1 : 0;
         $c_true = isset($_POST["tf_{$i}_c_true"]) ? 1 : 0;
         $d_true = isset($_POST["tf_{$i}_d_true"]) ? 1 : 0;
         $part_a = $_POST["tf_{$i}_a"] ?? '';
         $part_b = $_POST["tf_{$i}_b"] ?? '';
         $part_c = $_POST["tf_{$i}_c"] ?? '';
         $part_d = $_POST["tf_{$i}_d"] ?? '';
         
         if ($is_edit) {
             $q_id = $pdo->query("SELECT id FROM questions WHERE exam_id=$exam_id AND q_index=$i AND q_type='tf'")->fetchColumn();
             if ($q_id) {
                 $pdo->prepare("UPDATE questions SET content=?, shared_context=? WHERE id=?")->execute([$content, $shared_context, $q_id]);
                 $pdo->prepare("UPDATE answers_tf SET part_a=?, is_a_true=?, part_b=?, is_b_true=?, part_c=?, is_c_true=?, part_d=?, is_d_true=? WHERE question_id=?")
                     ->execute([$part_a, $a_true, $part_b, $b_true, $part_c, $c_true, $part_d, $d_true, $q_id]);
             } else {
                 $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, shared_context) VALUES (?, 'tf', ?, ?, ?)")->execute([$exam_id, $i, $content, $shared_context]);
                 $q_id = $pdo->lastInsertId();
                 $pdo->prepare("INSERT INTO answers_tf (question_id, part_a, is_a_true, part_b, is_b_true, part_c, is_c_true, part_d, is_d_true) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")
                     ->execute([$q_id, $part_a, $a_true, $part_b, $b_true, $part_c, $c_true, $part_d, $d_true]);
             }
         } else {
             $pdo->prepare("INSERT INTO questions (exam_id, q_type, q_index, content, shared_context) VALUES (?, 'tf', ?, ?, ?)")->execute([$exam_id, $i, $content, $shared_context]);
             $q_id = $pdo->lastInsertId();
             $pdo->prepare("INSERT INTO answers_tf (question_id, part_a, is_a_true, part_b, is_b_true, part_c, is_c_true, part_d, is_d_true) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)")
                 ->execute([$q_id, $part_a, $a_true, $part_b, $b_true, $part_c, $c_true, $part_d, $d_true]);
         }
     }

     $pdo->commit(); 
     $msg = $is_edit ? "Đã lưu thay đổi đề thi!" : "Tạo đề thi thành công!";
     header("Location: ?action=admin&msg=" . urlencode($msg)); exit;
 } catch (Exception $e) { $pdo->rollBack(); echo "<meta charset='UTF-8'><script>alert('Lỗi khi lưu đề: " . addslashes($e->getMessage()) . "'); history.back();</script>"; exit; }
}

if ($action == 'submit_exam' && is_logged_in() && $_SERVER['REQUEST_METHOD'] == 'POST') {
 verify_csrf();
 $exam_id = intval($_POST['exam_id']); $user_id = $_SESSION['user_id'];
 $ip = $_SERVER['REMOTE_ADDR']; $device = $_SERVER['HTTP_USER_AGENT'];
 
 $stmt = $pdo->prepare("SELECT duration FROM exams WHERE id = ?"); $stmt->execute([$exam_id]);
 $exam = $stmt->fetch(); if(!$exam) { echo "<meta charset='UTF-8'><script>alert('Đề thi không tồn tại!'); window.location.href='?action=home';</script>"; exit; }

 $time_taken = time() - ($_SESSION["exam_start_$exam_id"] ?? time());
 
 $mcq_correct = [];
 $stmt = $pdo->prepare("SELECT q.id, a.correct_opt FROM questions q JOIN answers_mcq a ON q.id = a.question_id WHERE q.exam_id = ?");
 $stmt->execute([$exam_id]); while ($row = $stmt->fetch()) $mcq_correct[$row['id']] = $row['correct_opt'];

 $tf_correct = [];
 $stmt = $pdo->prepare("SELECT q.id, a.is_a_true, a.is_b_true, a.is_c_true, a.is_d_true FROM questions q JOIN answers_tf a ON q.id = a.question_id WHERE q.exam_id = ?");
 $stmt->execute([$exam_id]); while ($row = $stmt->fetch()) { $tf_correct[$row['id']] = ['a' => $row['is_a_true'], 'b' => $row['is_b_true'], 'c' => $row['is_c_true'], 'd' => $row['is_d_true']]; }

 $mcq_score = 0; $tf_score = 0; $details = [];
 $ans_mcq = $_POST['ans_mcq'] ?? [];
 foreach ($mcq_correct as $q_id => $correct_opt) {
     $user_opt = $ans_mcq[$q_id] ?? null; 
     $is_correct = ($correct_opt !== null && $user_opt === $correct_opt) ? 1 : 0;
     $points = $is_correct ? 0.25 : 0; $mcq_score += $points;
     $details[] = ['q_id' => $q_id, 'ans' => $user_opt, 'is_correct' => $is_correct, 'points' => $points];
 }

 $ans_tf = $_POST['ans_tf'] ?? [];
 foreach ($tf_correct as $q_id => $correct) {
     $user_ans = $ans_tf[$q_id] ?? []; $parts_correct = 0;
     $u_a = isset($user_ans['a']) ? ($user_ans['a'] === 'true' ? 1 : 0) : -1;
     $u_b = isset($user_ans['b']) ? ($user_ans['b'] === 'true' ? 1 : 0) : -1;
     $u_c = isset($user_ans['c']) ? ($user_ans['c'] === 'true' ? 1 : 0) : -1;
     $u_d = isset($user_ans['d']) ? ($user_ans['d'] === 'true' ? 1 : 0) : -1;
     
     if ($u_a !== -1 && $u_a == $correct['a']) $parts_correct++; 
     if ($u_b !== -1 && $u_b == $correct['b']) $parts_correct++;
     if ($u_c !== -1 && $u_c == $correct['c']) $parts_correct++; 
     if ($u_d !== -1 && $u_d == $correct['d']) $parts_correct++;

     $points = 0;
     if ($parts_correct == 1) $points = 0.1; elseif ($parts_correct == 2) $points = 0.25;
     elseif ($parts_correct == 3) $points = 0.5; elseif ($parts_correct == 4) $points = 1.0;
     $tf_score += $points;
     $details[] = ['q_id' => $q_id, 'ans' => json_encode(['a'=>$u_a, 'b'=>$u_b, 'c'=>$u_c, 'd'=>$u_d]), 'is_correct' => ($parts_correct == 4 ? 1 : 0), 'points' => $points];
 }

 $total_score = $mcq_score + $tf_score;

 $pdo->beginTransaction();
 $stmt = $pdo->prepare("INSERT INTO results (user_id, exam_id, score, mcq_score, tf_score, time_taken, ip, device) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
 $stmt->execute([$user_id, $exam_id, $total_score, $mcq_score, $tf_score, $time_taken, $ip, $device]);
 $result_id = $pdo->lastInsertId();

 $stmtD = $pdo->prepare("INSERT INTO result_details (result_id, question_id, user_answer, is_correct, points) VALUES (?, ?, ?, ?, ?)");
 foreach ($details as $d) { $stmtD->execute([$result_id, $d['q_id'], $d['ans'], $d['is_correct'], $d['points']]); }
 $pdo->commit();

 unset($_SESSION["exam_start_$exam_id"]);
 unset($_SESSION["exam_order_$exam_id"]); 
 
 header("Location: ?action=result&id=$result_id"); exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
 <title>Thi Công Nghệ - Hệ Thống Trực Tuyến</title>
 
 <link rel="manifest" href="manifest.json">
 <meta name="theme-color" content="#0ea5e9">
 <link rel="apple-touch-icon" href="icon-192.png">

 <?php if (!empty($site_settings['favicon'])): ?>
     <link rel="icon" href="<?= htmlspecialchars($site_settings['favicon']) ?>">
 <?php endif; ?>

 <script src="https://cdn.tailwindcss.com"></script>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
 <script>
     tailwind.config = {
         theme: {
             extend: {
                 colors: { primary: '#0ea5e9', secondary: '#0284c7', accent: '#fbbf24', bg_light: '#f0f9ff' },
                 fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'], }
             }
         }
     }
 </script>
 <style>
     @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
     html { -webkit-overflow-scrolling: touch; }
     body { background-color: #f8fafc; }
     .glass-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
     .noselect { -webkit-user-select: none; -ms-user-select: none; user-select: none; }
     ::-webkit-scrollbar { width: 6px; height: 6px; }
     ::-webkit-scrollbar-track { background: transparent; }
     ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
     ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
     .break-words { word-break: break-word; overflow-wrap: break-word; }
     .preview-img-in-input img { max-height: 150px; border-radius: 8px; margin-top: 8px; border: 2px solid #e2e8f0; display: block; cursor: zoom-in; }
     .prose table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 0.9rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
     .prose th, .prose td { border: 1px solid #cbd5e1; padding: 10px 12px; text-align: left; }
     .prose th { background-color: #f1f5f9; font-weight: 700; color: #334155; }
     .prose tr:nth-child(even) { background-color: #f8fafc; }
     .prose img, .break-words img, label img, td img { cursor: zoom-in; max-width: 100%; height: auto; border-radius: 8px; border: 1px solid #e2e8f0; display: inline-block; margin-top: 5px; }
     #zModal img { cursor: zoom-out; }
     .custom-scrollbar::-webkit-scrollbar { width: 4px; }
 </style>
</head>
<body class="text-slate-800 antialiased min-h-screen flex flex-col font-sans overflow-x-hidden">

<nav class="bg-secondary text-white shadow-lg sticky top-0 z-50 transform-gpu">
 <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
     <div class="flex justify-between items-center h-16">
         <a href="?action=home" class="flex items-center gap-2 text-lg sm:text-xl font-bold tracking-tight truncate">
             <div class="bg-white/20 p-2 rounded-lg flex items-center justify-center backdrop-blur-sm w-10 h-10 overflow-hidden">
                 <?php if (($site_settings['logo_type'] ?? 'icon') === 'icon'): ?>
                     <i class="<?= htmlspecialchars($site_settings['logo_icon'] ?? 'fa-solid fa-microchip') ?> text-white text-xl"></i>
                 <?php elseif (!empty($site_settings['logo_image'])): ?>
                     <img src="<?= htmlspecialchars($site_settings['logo_image']) ?>" class="max-w-full max-h-full object-contain" alt="Logo">
                 <?php else: ?>
                     <i class="fa-solid fa-microchip text-white text-xl"></i>
                 <?php endif; ?>
             </div>
             <span class="truncate hidden sm:inline">Hệ Thống Thi Công Nghệ</span>
             <span class="truncate sm:hidden">Thi Công Nghệ</span>
         </a>
         <div class="flex items-center gap-2 sm:gap-4">
             <?php if (is_logged_in()): ?>
                 <?php if (is_admin()): ?>
                     <a href="?action=admin" class="hidden sm:flex items-center gap-1 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition"><i class="fa-solid fa-gauge-high"></i> Quản trị</a>
                     <a href="?action=admin" class="sm:hidden text-white hover:bg-white/10 p-2 rounded-lg transition"><i class="fa-solid fa-gauge-high text-lg"></i></a>
                 <?php endif; ?>
                 <div class="hidden sm:flex items-center gap-2 font-medium text-sm bg-black/10 px-3 py-1.5 rounded-full border border-white/10">
                     <i class="fa-solid fa-circle-user text-lg text-sky-200"></i> <span class="truncate max-w-[150px]"><?= htmlspecialchars($_SESSION['fullname']) ?></span>
                 </div>
                 <a href="?action=logout" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-bold transition shadow-sm flex items-center gap-2"><i class="fa-solid fa-power-off"></i> <span class="hidden sm:inline">Thoát</span></a>
             <?php else: ?>
                 <a href="?action=login" class="hover:text-sky-200 font-medium px-2 py-2">Đăng nhập</a>
                 <a href="?action=register" class="bg-white text-secondary px-4 py-2 rounded-lg font-bold hover:bg-sky-50 shadow-sm transition">Đăng ký</a>
             <?php endif; ?>
         </div>
     </div>
 </div>
</nav>

<main class="flex-grow flex flex-col items-center w-full">
<?php
$get_msg = $_GET['msg'] ?? $msg;
if ($get_msg) {
 $color = $msg_type == 'error' ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200';
 $icon = $msg_type == 'error' ? 'fa-circle-xmark' : 'fa-circle-check';
 echo "<div class='w-full max-w-md mx-auto mt-6 px-4'><div class='p-4 rounded-xl border $color flex items-center gap-3 shadow-sm'><i class='fa-solid $icon text-xl'></i><span class='font-medium'>".htmlspecialchars($get_msg)."</span></div></div>";
}

if (!is_logged_in() && in_array($action, ['login', 'register', 'home'])): 
 $is_reg = ($action == 'register');
?>
 <div class="flex flex-col items-center justify-center flex-grow py-12 px-4 w-full">
     <div class="text-center mb-8 max-w-2xl px-4">
         <h1 class="text-3xl font-black text-secondary mb-3">Hệ Thống Trực Tuyến Công Nghệ</h1>
         <p class="text-slate-500 font-medium">Kiểm tra kiến thức trực tuyến. Đăng nhập để bắt đầu.</p>
     </div>
     <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl w-full max-md md:max-w-md border border-slate-100 relative overflow-hidden">
         <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-primary to-accent"></div>
         <div class="text-center mb-8">
             <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-sky-50 text-secondary mb-4"><i class="fa-solid <?= $is_reg ? 'fa-user-plus' : 'fa-right-to-bracket' ?> text-3xl"></i></div>
             <h2 class="text-2xl font-extrabold text-slate-800"><?= $is_reg ? 'Tạo Tài Khoản Mới' : 'Đăng Nhập' ?></h2>
         </div>
         <form method="POST" action="?action=<?= $is_reg ? 'register' : 'login' ?>" class="space-y-4">
             <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
             <?php if($is_reg): ?>
                 <div><input type="text" name="fullname" required placeholder="Họ và Tên" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none transition-all"></div>
             <?php endif; ?>
             <div><input type="text" name="username" required placeholder="Tên đăng nhập" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none transition-all"></div>
             <div><input type="password" name="password" required placeholder="Mật khẩu" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 outline-none transition-all"></div>
             <button type="submit" class="w-full bg-primary hover:bg-secondary text-white font-bold py-3.5 rounded-xl shadow-lg transition-all duration-200 mt-2">
                 <?= $is_reg ? 'Đăng Ký' : 'Đăng Nhập' ?>
             </button>
         </form>
         <div class="mt-6 text-center text-sm text-slate-500">
             <?= $is_reg ? 'Đã có tài khoản?' : 'Chưa có tài khoản?' ?> 
             <a href="?action=<?= $is_reg ? 'login' : 'register' ?>" class="text-secondary font-bold hover:underline ml-1"><?= $is_reg ? 'Đăng nhập' : 'Tạo ngay' ?></a>
         </div>
     </div>
 </div>

<?php 
elseif (is_logged_in() && $action == 'home' && !is_admin()): 
 $stmt = $pdo->prepare("SELECT COUNT(*) as total, MAX(score) as max_score FROM results WHERE user_id = ?"); $stmt->execute([$_SESSION['user_id']]); $stats = $stmt->fetch();
 $stmt = $pdo->prepare("SELECT r.*, e.title FROM results r JOIN exams e ON r.exam_id = e.id WHERE r.user_id = ? ORDER BY r.created_at DESC"); $stmt->execute([$_SESSION['user_id']]); $history = $stmt->fetchAll();
 $exams = $pdo->query("SELECT * FROM exams WHERE status = 'active' ORDER BY id DESC")->fetchAll();
?>
 <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 w-full">
     <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-3xl p-8 sm:p-10 mb-8 text-white shadow-xl relative overflow-hidden">
         <div class="absolute inset-0 bg-black opacity-10"></div>
         <div class="relative z-10">
             <h2 class="text-3xl md:text-4xl font-black mb-3">Ôn tập kiến thức Công Nghệ</h2>
             <p class="text-sky-100 text-lg max-w-2xl mb-6">Hệ thống kiểm tra trực tuyến. Tham gia các bài kiểm tra để củng cố kiến thức của bạn.</p>
             <div class="inline-block bg-white/20 backdrop-blur px-4 py-2 rounded-lg font-medium">Xin chào, <?= htmlspecialchars($_SESSION['fullname']) ?> 👋</div>
         </div>
         <i class="fa-solid fa-microchip absolute -bottom-10 -right-10 text-[200px] opacity-20 transform -rotate-12"></i>
     </div>

     <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
         <div class="lg:col-span-1 space-y-4">
             <div class="flex items-center gap-2 mb-4"><i class="fa-solid fa-fire text-orange-500 text-xl"></i><h2 class="text-xl font-bold text-slate-800">Đề Thi Đang Mở</h2></div>
             <div class="grid gap-4">
                 <?php foreach($exams as $e): ?>
                 <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 hover:border-primary/50 hover:shadow-md transition-all group">
                     <div class="flex justify-between items-start mb-2">
                         <span class="bg-sky-50 text-secondary text-xs font-bold px-2 py-1 rounded">Mã: <?= htmlspecialchars($e['code']) ?></span>
                         <span class="text-slate-500 text-sm font-medium"><i class="fa-regular fa-clock mr-1"></i><?= $e['duration'] ?>p</span>
                     </div>
                     <h3 class="font-bold text-lg mb-2 text-slate-800 group-hover:text-primary transition-colors"><?= htmlspecialchars($e['title']) ?></h3>
                     <a href="?action=take_exam&id=<?= $e['id'] ?>" class="block w-full text-center bg-slate-800 hover:bg-primary text-white py-2.5 rounded-xl font-bold transition-colors shadow-md">Vào thi ngay <i class="fa-solid fa-arrow-right ml-1"></i></a>
                 </div>
                 <?php endforeach; ?>
                 <?php if(empty($exams)): ?>
                     <div class="bg-white p-8 rounded-2xl border border-slate-200 text-center text-slate-500 bg-slate-50/50">
                         <i class="fa-solid fa-book-open-reader text-4xl mb-3 text-slate-300"></i><p class="font-medium">Chưa có đề thi nào mở.</p>
                     </div>
                 <?php endif; ?>
             </div>
         </div>

         <div class="lg:col-span-2">
             <div class="grid grid-cols-2 gap-4 mb-6">
                 <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                     <div><div class="text-sm text-slate-500 font-medium mb-1">Tổng bài nộp</div><div class="text-3xl font-black text-slate-800"><?= $stats['total'] ?></div></div>
                     <div class="w-12 h-12 bg-sky-50 rounded-full flex items-center justify-center text-secondary text-xl"><i class="fa-solid fa-file-contract"></i></div>
                 </div>
                 <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                     <div><div class="text-sm text-emerald-600 font-medium mb-1">Điểm cao nhất</div><div class="text-3xl font-black text-emerald-600"><?= number_format((float)$stats['max_score'], 1) ?></div></div>
                     <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-500 text-xl"><i class="fa-solid fa-ranking-star"></i></div>
                 </div>
             </div>

             <div class="flex items-center gap-2 mb-4"><i class="fa-solid fa-clock-rotate-left text-slate-400 text-xl"></i><h2 class="text-xl font-bold text-slate-800">Lịch Sử Làm Bài</h2></div>
             <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                 <div class="overflow-x-auto">
                     <table class="min-w-full divide-y divide-slate-200">
                         <thead class="bg-slate-50"><tr><th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Tên đề thi</th><th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Điểm số</th><th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">Ngày nộp</th><th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase">Chi tiết</th></tr></thead>
                         <tbody class="divide-y divide-slate-100">
                             <?php foreach($history as $h): ?>
                             <tr class="hover:bg-slate-50">
                                 <td class="px-6 py-4"><div class="font-bold text-slate-800"><?= htmlspecialchars($h['title']) ?></div><div class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-stopwatch mr-1"></i><?= round($h['time_taken']/60) ?>p</div></td>
                                 <td class="px-6 py-4 text-center"><div class="inline-flex items-center justify-center w-10 h-10 rounded-full border-2 <?= $h['score'] >= 5 ? 'border-emerald-500 text-emerald-600 bg-emerald-50' : 'border-rose-500 text-rose-600 bg-rose-50' ?> font-black text-base shadow-sm"><?= number_format($h['score'], 1) ?></div></td>
                                 <td class="px-6 py-4 text-center text-sm text-slate-500"><?= date('d/m/Y H:i', strtotime($h['created_at'])) ?></td>
                                 <td class="px-6 py-4 text-right text-sm"><a href="?action=result&id=<?= $h['id'] ?>" class="bg-white border border-slate-200 hover:text-primary px-3 py-1.5 rounded-lg font-medium shadow-sm transition-colors">Xem</a></td>
                             </tr>
                             <?php endforeach; ?>
                         </tbody>
                     </table>
                     <?php if(empty($history)): ?><div class="p-12 text-center text-slate-400 bg-slate-50/50"><i class="fa-solid fa-scroll text-5xl mb-4 opacity-30"></i><p class="font-bold">Bạn chưa có lịch sử làm bài</p></div><?php endif; ?>
                 </div>
             </div>
         </div>
     </div>
 </div>

<?php
elseif (is_logged_in() && $action == 'take_exam' && isset($_GET['id'])):
 $exam_id = intval($_GET['id']);
 $stmt = $pdo->prepare("SELECT * FROM exams WHERE id = ?"); $stmt->execute([$exam_id]); $exam = $stmt->fetch(); if(!$exam) { echo "<meta charset='UTF-8'><script>alert('Đề thi không tồn tại!'); window.location.href='?action=home';</script>"; exit; }
 if(!isset($_SESSION["exam_start_$exam_id"])) { $_SESSION["exam_start_$exam_id"] = time(); }
 
 $stmt = $pdo->prepare("SELECT q.*, am.opt_a, am.opt_b, am.opt_c, am.opt_d, at.part_a, at.part_b, at.part_c, at.part_d FROM questions q LEFT JOIN answers_mcq am ON q.id = am.question_id LEFT JOIN answers_tf at ON q.id = at.question_id WHERE q.exam_id = ? ORDER BY q.q_index ASC");
 $stmt->execute([$exam_id]); 
 $questions_raw = $stmt->fetchAll();
 
 $session_order_key = "exam_order_$exam_id";

 if (!isset($_SESSION[$session_order_key])) {
     $mcq_qs = [];
     $tf_qs = [];
     foreach($questions_raw as $q) {
         if ($q['q_type'] == 'mcq') $mcq_qs[] = $q;
         else $tf_qs[] = $q;
     }
     
     shuffle($mcq_qs);
     shuffle($tf_qs);
     
     $ordered_qs = array_merge($mcq_qs, $tf_qs);
     
     $ans_order = [];
     foreach($ordered_qs as $q) {
         if ($q['q_type'] == 'mcq') {
             $k = ['A','B','C','D']; 
             shuffle($k);
             $ans_order[$q['id']] = $k;
         } else {
             $k = ['a','b','c','d']; 
             shuffle($k);
             $ans_order[$q['id']] = $k;
         }
     }
     
     $_SESSION[$session_order_key] = [
         'questions' => $ordered_qs,
         'answers' => $ans_order
     ];
 }

 $questions = $_SESSION[$session_order_key]['questions'];
 $ans_order = $_SESSION[$session_order_key]['answers'];
?>
 
 <div class="max-w-7xl mx-auto w-full px-2 sm:px-4 lg:px-8 py-6 noselect relative preview-img-in-input">
     <form id="examForm" method="POST" action="?action=submit_exam" class="flex flex-col lg:flex-row gap-6 items-start relative">
         <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
         <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
         
         <div class="w-full lg:w-1/4 lg:order-2 lg:sticky lg:top-20 z-10 hidden lg:block">
             <div class="glass-panel bg-white/90 rounded-2xl shadow-lg border border-slate-200 p-5 flex flex-col h-[calc(100vh-8rem)]">
                 <div class="text-center mb-6 pb-5 border-b border-slate-100">
                     <div class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-widest">Thời gian còn lại</div>
                     <div id="timer_desktop" class="text-4xl font-black text-rose-500 font-mono tracking-wider drop-shadow-sm">--:--</div>
                 </div>
                 <div class="flex-grow overflow-y-auto pr-2 custom-scrollbar">
                     <div class="text-xs font-bold text-primary mb-2">Trắc nghiệm (1-24)</div>
                     <div class="grid grid-cols-4 gap-2 mb-5">
                         <?php for($i=1; $i<=24; $i++): ?> <button type="button" onclick="scrollToQ(<?= $i ?>)" id="btn_nav_<?= $i ?>" class="nav-btn w-full aspect-square rounded-lg border border-slate-300 font-bold text-slate-600 hover:bg-slate-100 text-sm flex items-center justify-center"><?= $i ?></button> <?php endfor; ?>
                     </div>
                     <div class="text-xs font-bold text-purple-600 mb-2 border-t border-slate-100 pt-3">Đúng/Sai (25-28)</div>
                     <div class="grid grid-cols-4 gap-2">
                         <?php for($i=25; $i<=28; $i++): ?> <button type="button" onclick="scrollToQ(<?= $i ?>)" id="btn_nav_<?= $i ?>" class="nav-btn w-full aspect-square rounded-lg border border-slate-300 font-bold text-slate-600 hover:bg-slate-100 text-sm flex items-center justify-center"><?= $i ?></button> <?php endfor; ?>
                     </div>
                 </div>
                 <div class="pt-4 border-t border-slate-100">
                     <button type="button" onclick="confirmSubmit()" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-xl shadow-lg text-lg"><i class="fa-solid fa-paper-plane mr-2"></i> NỘP BÀI THI</button>
                 </div>
             </div>
         </div>

         <div class="w-full lg:w-3/4 lg:order-1 flex flex-col gap-6">
             
             <div class="lg:hidden sticky top-[72px] z-40 bg-white border border-slate-200 shadow-md px-4 py-3 flex justify-between items-center rounded-2xl transform-gpu">
                 <div class="flex flex-col">
                     <span class="text-[10px] font-bold text-slate-500 uppercase leading-tight">Thời gian</span>
                     <span id="timer_mobile" class="text-2xl font-black text-rose-600 font-mono leading-none">--:--</span>
                 </div>
                 <button type="button" onclick="confirmSubmit()" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-sm flex items-center text-base active:scale-95 transition-transform"><i class="fa-solid fa-paper-plane mr-2"></i> Nộp Bài</button>
             </div>

             <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 text-center relative overflow-hidden">
                 <div class="absolute top-0 left-0 w-2 h-full bg-primary"></div>
                 <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 mb-2"><?= htmlspecialchars($exam['title']) ?></h1>
                 <div class="flex flex-wrap justify-center gap-2 sm:gap-3 text-sm font-medium text-slate-500 mt-3">
                     <span class="bg-slate-100 px-3 py-1.5 rounded-xl break-words max-w-full text-center">Mã: <?= htmlspecialchars($exam['code']) ?></span>
                     <span class="bg-slate-100 px-3 py-1.5 rounded-xl whitespace-nowrap"><i class="fa-regular fa-clock"></i> <?= $exam['duration'] ?>p</span>
                 </div>
             </div>

             <?php foreach($questions as $idx => $q): 
                 $display_index = $idx + 1; 
             ?>
                 <div id="q_<?= $display_index ?>" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-7 shadow-sm scroll-mt-24">
                     <div class="flex flex-col sm:flex-row gap-4 mb-4 sm:mb-6">
                         <div class="shrink-0 flex items-center border-b sm:border-0 pb-3 sm:pb-0">
                             <span class="bg-primary text-white font-black rounded-xl w-10 h-10 flex items-center justify-center shadow-md"><?= $display_index ?></span>
                         </div>
                         <div class="w-full min-w-0">
                             <div class="text-base sm:text-lg font-medium text-slate-800 prose max-w-none break-words whitespace-pre-line"><?= trim(htmlspecialchars_decode($q['content'] ?? '')) ?></div>
                         </div>
                     </div>
                     <div class="pl-0 sm:pl-14">
                         <?php if($q['q_type'] == 'mcq'): ?>
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                 <?php 
                                     $options = ['A'=>$q['opt_a'], 'B'=>$q['opt_b'], 'C'=>$q['opt_c'], 'D'=>$q['opt_d']];
                                     $orig_keys = $ans_order[$q['id']];
                                     $labels = ['A', 'B', 'C', 'D']; 
                                     
                                     foreach($orig_keys as $i => $orig_key): 
                                         $val = $options[$orig_key];
                                         $label = $labels[$i];
                                 ?>
                                     <label class="flex items-start p-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-primary/50 has-[:checked]:border-primary has-[:checked]:bg-sky-50" onclick="markDone(<?= $display_index ?>)">
                                         <input type="radio" name="ans_mcq[<?= $q['id'] ?>]" value="<?= $orig_key ?>" class="mt-1 w-5 h-5 text-primary focus:ring-primary shrink-0">
                                         <div class="ml-3 break-words whitespace-pre-line w-full"><span class="font-bold mr-1"><?= $label ?>.</span><?= trim(htmlspecialchars_decode($val ?? '')) ?></div>
                                     </label>
                                 <?php endforeach; ?>
                             </div>
                         <?php elseif($q['q_type'] == 'tf'): ?>
                             <div class="w-full rounded-xl border border-slate-200 overflow-hidden">
                                 <table class="w-full text-sm sm:text-base text-left table-fixed">
                                     <thead class="bg-slate-50 border-b border-slate-200">
                                         <tr>
                                             <th class="p-2 text-center w-[10%] sm:w-[8%]">Ý</th>
                                             <th class="p-2 w-[50%] sm:w-[62%]">Nội dung</th>
                                             <th class="p-1 sm:p-2 text-center text-emerald-600 w-[20%] sm:w-[15%]">Đúng</th>
                                             <th class="p-1 sm:p-2 text-center text-rose-600 w-[20%] sm:w-[15%]">Sai</th>
                                         </tr>
                                     </thead>
                                     <tbody class="divide-y divide-slate-100">
                                         <?php 
                                             $parts = ['a'=>$q['part_a'], 'b'=>$q['part_b'], 'c'=>$q['part_c'], 'd'=>$q['part_d']];
                                             $orig_keys = $ans_order[$q['id']];
                                             $labels = ['a', 'b', 'c', 'd']; 
                                             
                                             foreach($orig_keys as $i => $orig_key): 
                                                 $val = $parts[$orig_key];
                                                 $label = $labels[$i];
                                         ?>
                                         <tr class="hover:bg-slate-50">
                                             <td class="p-2 text-center font-black align-middle"><?= $label ?>)</td>
                                             <td class="p-2 break-words align-middle leading-relaxed whitespace-pre-line"><?= trim(htmlspecialchars_decode($val ?? '')) ?></td>
                                             <td class="p-1 sm:p-2 text-center align-middle"><input type="radio" name="ans_tf[<?= $q['id'] ?>][<?= $orig_key ?>]" value="true" class="w-5 h-5 sm:w-6 sm:h-6 text-emerald-500 cursor-pointer" onclick="markDone(<?= $display_index ?>)"></td>
                                             <td class="p-1 sm:p-2 text-center align-middle"><input type="radio" name="ans_tf[<?= $q['id'] ?>][<?= $orig_key ?>]" value="false" class="w-5 h-5 sm:w-6 sm:h-6 text-rose-500 cursor-pointer" onclick="markDone(<?= $display_index ?>)"></td>
                                         </tr>
                                         <?php endforeach; ?>
                                     </tbody>
                                 </table>
                             </div>
                         <?php endif; ?>
                     </div>
                 </div>
             <?php endforeach; ?>
         </div>
     </form>
 </div>
 <script>
     let timeLeft = <?= $exam['duration'] ?> * 60; 
     let timerDesktop = document.getElementById('timer_desktop');
     let timerMobile = document.getElementById('timer_mobile');
     function updateTimer() {
         let m = Math.floor(timeLeft / 60); let s = timeLeft % 60;
         let timeStr = (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s;
         if(timerDesktop) timerDesktop.innerText = timeStr;
         if(timerMobile) timerMobile.innerText = timeStr;
         
         if(timeLeft <= 300) { 
             if(timerDesktop) timerDesktop.classList.add('text-rose-600', 'animate-pulse'); 
             if(timerMobile) timerMobile.classList.add('text-rose-600', 'animate-pulse'); 
         }
         if (timeLeft <= 0) { clearInterval(timerInterval); alert("Hết giờ! Tự động nộp."); document.getElementById('examForm').submit(); }
         timeLeft--;
     }
     let timerInterval = setInterval(updateTimer, 1000); updateTimer();
     function scrollToQ(idx) { let el = document.getElementById('q_' + idx); if(el) { el.scrollIntoView({behavior: "smooth", block: "center"}); } }
     function markDone(idx) { let btn = document.getElementById('btn_nav_' + idx); if(btn) { btn.classList.remove('border-slate-300', 'text-slate-600', 'hover:bg-slate-100'); btn.classList.add('bg-primary', 'text-white', 'border-primary', 'shadow-md'); } }
     function confirmSubmit() { let totalDone = document.querySelectorAll('.nav-btn.bg-primary').length; let msg = totalDone < 28 ? `Làm được ${totalDone}/28 câu. Bạn chắc chắn nộp?` : "Xác nhận nộp bài thi?"; if(confirm(msg)) { document.getElementById('examForm').submit(); } }
 </script>

<?php
elseif (is_logged_in() && $action == 'result' && isset($_GET['id'])):
 $res_id = intval($_GET['id']);
 $stmt = $pdo->prepare("SELECT * FROM results WHERE id = ? AND (user_id = ? OR ? = 'admin')"); $stmt->execute([$res_id, $_SESSION['user_id'], $_SESSION['role']]); $res = $stmt->fetch(); if(!$res) { echo "<meta charset='UTF-8'><script>alert('Không tìm thấy kết quả!'); window.location.href='?action=home';</script>"; exit; }
 $exam_id = $res['exam_id']; $stmt = $pdo->prepare("SELECT * FROM exams WHERE id = ?"); $stmt->execute([$exam_id]); $exam = $stmt->fetch();
 $stmt = $pdo->prepare("SELECT rd.*, q.q_type, q.q_index, q.content, q.shared_context, am.opt_a, am.opt_b, am.opt_c, am.opt_d, am.correct_opt, at.part_a, at.part_b, at.part_c, at.part_d, at.is_a_true, at.is_b_true, at.is_c_true, at.is_d_true FROM result_details rd JOIN questions q ON rd.question_id = q.id LEFT JOIN answers_mcq am ON q.id = am.question_id LEFT JOIN answers_tf at ON q.id = at.question_id WHERE rd.result_id = ? ORDER BY q.q_index ASC");
 $stmt->execute([$res_id]); $details = $stmt->fetchAll(); $is_pass = $res['score'] >= 5;
?>
 <div class="max-w-5xl mx-auto w-full px-4 sm:px-6 py-8">
     <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-10 border border-slate-100">
         <div class="p-8 sm:p-12 text-center bg-gradient-to-b <?= $is_pass ? 'from-emerald-50 to-white' : 'from-rose-50 to-white' ?>">
             <div class="inline-flex items-center justify-center w-20 h-20 rounded-full mb-6 <?= $is_pass ? 'bg-emerald-100 text-emerald-500' : 'bg-rose-100 text-rose-500' ?>"><i class="fa-solid <?= $is_pass ? 'fa-trophy' : 'fa-face-frown-open' ?> text-4xl"></i></div>
             <h1 class="text-3xl font-black mb-3">Kết Quả Bài Làm</h1>
             <p class="text-lg opacity-70 mb-6"><?= htmlspecialchars($exam['title']) ?></p>
             <div class="text-6xl font-black <?= $is_pass ? 'text-emerald-600' : 'text-rose-600' ?> mb-8"><?= number_format($res['score'], 1) ?><span class="text-xl opacity-50">/10</span></div>
             <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-left max-w-3xl mx-auto">
                 <div class="bg-white p-4 rounded-xl border shadow-sm"><div class="text-xs opacity-50 uppercase font-bold">Trắc nghiệm</div><div class="text-xl font-bold"><?= number_format($res['mcq_score'], 2) ?> đ</div></div>
                 <div class="bg-white p-4 rounded-xl border shadow-sm"><div class="text-xs opacity-50 uppercase font-bold">Đúng/Sai</div><div class="text-xl font-bold"><?= number_format($res['tf_score'], 2) ?> đ</div></div>
                 <div class="bg-white p-4 rounded-xl border shadow-sm"><div class="text-xs opacity-50 uppercase font-bold">Thời gian</div><div class="text-lg font-bold"><?= round($res['time_taken']/60, 1) ?>p</div></div>
                 <div class="bg-white p-4 rounded-xl border shadow-sm"><div class="text-xs opacity-50 uppercase font-bold">Ngày thi</div><div class="text-sm font-bold"><?= date('d/m/Y', strtotime($res['created_at'])) ?></div></div>
             </div>
         </div>
     </div>

     <div class="space-y-6">
         <?php foreach($details as $d): ?>
             <?php 
                 $borderColor = 'border-slate-200'; $bgColor = 'bg-white'; $iconHtml = '';
                 if($d['is_correct'] || $d['points'] == 1) { $borderColor = 'border-emerald-400'; $iconHtml = '<span class="text-emerald-600 text-xs font-bold">ĐÚNG (+'.$d['points'].')</span>'; } 
                 elseif($d['points'] > 0) { $borderColor = 'border-amber-400'; $iconHtml = '<span class="text-amber-600 text-xs font-bold">1 PHẦN (+'.$d['points'].')</span>'; } 
                 else { $borderColor = 'border-rose-400'; $bgColor = 'bg-rose-50/30'; $iconHtml = '<span class="text-rose-600 text-xs font-bold">SAI (0đ)</span>'; }
             ?>
             <div class="<?= $bgColor ?> rounded-2xl shadow-sm border-l-4 <?= $borderColor ?> border-y border-r p-4 sm:p-5 relative">
                 <div class="flex justify-between mb-3"><h3 class="font-bold">Câu <?= $d['q_index'] ?></h3><?= $iconHtml ?></div>
                 <div class="prose max-w-none mb-4 text-sm bg-slate-50 p-3 rounded-lg border whitespace-pre-line"><?= trim(htmlspecialchars_decode($d['content'] ?? '')) ?></div>
                 
                 <?php if($d['q_type'] == 'mcq'): ?>
                     <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                         <?php foreach(['A'=>$d['opt_a'], 'B'=>$d['opt_b'], 'C'=>$d['opt_c'], 'D'=>$d['opt_d']] as $k => $v): 
                             $is_user_choice = ($d['user_answer'] == $k); $is_actual_correct = ($d['correct_opt'] == $k);
                             $class = "border-slate-200 opacity-60"; 
                             if($is_actual_correct) { $class = "border-emerald-500 bg-emerald-50 text-emerald-900 font-bold opacity-100"; } 
                             elseif($is_user_choice && !$is_actual_correct) { $class = "border-rose-400 bg-rose-50 text-rose-900 line-through opacity-100"; } 
                         ?>
                             <div class="p-2 border-2 rounded-lg <?= $class ?> flex"><span class="font-black mr-2"><?= $k ?>.</span><div class="break-words whitespace-pre-line w-full"><?= trim(htmlspecialchars_decode($v ?? '')) ?></div></div>
                         <?php endforeach; ?>
                     </div>
                 <?php elseif($d['q_type'] == 'tf'): $u_ans = json_decode($d['user_answer'], true) ?: []; ?>
                     <div class="w-full rounded-lg border mt-2 overflow-hidden">
                         <table class="w-full text-sm text-left table-fixed">
                             <thead class="bg-slate-50 border-b">
                                 <tr>
                                     <th class="p-2 text-center w-[10%]">Ý</th>
                                     <th class="p-2 w-[50%] sm:w-[60%]">Nội dung</th>
                                     <th class="p-1 sm:p-2 text-center w-[20%] sm:w-[15%] text-[10px] sm:text-sm">Bạn chọn</th>
                                     <th class="p-1 sm:p-2 text-center w-[20%] sm:w-[15%] text-[10px] sm:text-sm">Đ.Án</th>
                                 </tr>
                             </thead>
                             <tbody class="divide-y divide-slate-100">
                                 <?php foreach(['a'=>['text'=>$d['part_a'], 'correct'=>$d['is_a_true']], 'b'=>['text'=>$d['part_b'], 'correct'=>$d['is_b_true']], 'c'=>['text'=>$d['part_c'], 'correct'=>$d['is_c_true']], 'd'=>['text'=>$d['part_d'], 'correct'=>$d['is_d_true']]] as $k => $v):
                                    $u_chose = (isset($u_ans[$k]) && $u_ans[$k] !== -1) ? $u_ans[$k] : null; 
                                    
                                     $is_match = ($u_chose !== null && $u_chose == $v['correct']);
                                 ?>
                                 <tr class="<?= $is_match ? '' : 'bg-rose-50/50' ?>">
                                     <td class="p-2 text-center font-bold uppercase w-[10%] align-middle"><?= $k ?></td>
                                     <td class="p-2 break-words align-middle leading-relaxed whitespace-pre-line"><?= trim(htmlspecialchars_decode($v['text'] ?? '')) ?></td>
                                     <td class="p-1 sm:p-2 text-center font-bold text-[10px] sm:text-sm w-[20%] sm:w-[15%] align-middle <?= $u_chose === null ? 'text-slate-400' : ($u_chose == 1 ? 'text-emerald-600' : 'text-rose-600') ?>">
                                         <?= $u_chose === null ? 'Bỏ trống' : ($u_chose == 1 ? 'ĐÚNG' : 'SAI') ?>
                                     </td>
                                     <td class="p-1 sm:p-2 text-center font-bold text-blue-600 text-[10px] sm:text-sm w-[20%] sm:w-[15%] align-middle"><?= $v['correct'] == 1 ? 'ĐÚNG' : 'SAI' ?></td>
                                 </tr>
                                 <?php endforeach; ?>
                             </tbody>
                         </table>
                     </div>
                 <?php endif; ?>
             </div>
         <?php endforeach; ?>
     </div>
     <div class="text-center mt-8"><a href="?action=home" class="inline-block bg-slate-800 text-white font-bold py-3 px-8 rounded-xl shadow-md">Về trang chủ</a></div>
 </div>

<?php 
elseif (is_logged_in() && is_admin() && $action == 'admin'): 
 try {
     $total_users = $pdo->query("SELECT COUNT(*) FROM users WHERE role='user'")->fetchColumn();
     $total_exams = $pdo->query("SELECT COUNT(*) FROM exams")->fetchColumn();
     $total_takes = $pdo->query("SELECT COUNT(*) FROM results")->fetchColumn();
     $avg_score = $pdo->query("SELECT AVG(score) FROM results")->fetchColumn();
     $history = $pdo->query("SELECT r.*, u.username, u.fullname, e.title as exam_title FROM results r JOIN users u ON r.user_id = u.id JOIN exams e ON r.exam_id = e.id ORDER BY r.created_at DESC LIMIT 50")->fetchAll();
     $all_exams = $pdo->query("SELECT * FROM exams ORDER BY id DESC")->fetchAll();
     $all_users = $pdo->query("SELECT * FROM users WHERE role='user' ORDER BY id DESC")->fetchAll();
 } catch (Exception $e) {
     die("<div class='max-w-7xl mx-auto p-4 text-rose-500 font-bold'>Lỗi CSDL Admin: " . $e->getMessage() . "</div>");
 }
?>
 <div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 w-full">
     <div class="bg-slate-800 rounded-3xl p-8 mb-8 text-white shadow-xl relative overflow-hidden">
         <div class="relative z-10 flex flex-col sm:flex-row justify-between items-center gap-6">
             <div><h1 class="text-3xl font-black mb-2 text-sky-300">Quản Trị Hệ Thống</h1><p class="text-slate-400 font-medium">Quản lý đề thi, học sinh và kết quả môn Công Nghệ.</p></div>
             <div class="flex gap-3 shrink-0 flex-wrap sm:flex-nowrap">
                 <a href="?action=admin_settings" class="bg-slate-700 hover:bg-slate-600 text-white px-5 py-3 rounded-xl shadow-lg font-bold transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-gear text-xl"></i> Cài Đặt HT</a>
                 <a href="?action=admin_exam_form" class="bg-primary text-white px-6 py-3 rounded-xl shadow-lg font-bold hover:bg-secondary transition flex items-center gap-2 whitespace-nowrap"><i class="fa-solid fa-plus-circle text-xl"></i> Soạn Đề Mới</a>
             </div>
         </div>
     </div>

     <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
         <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100"><div class="text-xs opacity-50 uppercase mb-1">Tổng Học Sinh</div><div class="text-3xl font-black text-blue-600"><?= $total_users ?></div></div>
         <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100"><div class="text-xs opacity-50 uppercase mb-1">Lượt Thi</div><div class="text-3xl font-black text-emerald-600"><?= $total_takes ?></div></div>
         <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100"><div class="text-xs opacity-50 uppercase mb-1">Số Đề Thi</div><div class="text-3xl font-black text-purple-600"><?= $total_exams ?></div></div>
         <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100"><div class="text-xs opacity-50 uppercase mb-1">Điểm TB</div><div class="text-3xl font-black text-amber-500"><?= number_format((float)$avg_score, 2) ?></div></div>
     </div>
     
     <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
         <div class="px-6 py-5 border-b border-slate-100 bg-slate-50"><h3 class="font-bold text-lg"><i class="fa-solid fa-file-lines text-blue-600 mr-2"></i> Quản Lý Đề Thi</h3></div>
         <div class="overflow-x-auto w-full">
             <table class="min-w-full text-left text-sm">
                 <thead class="bg-white border-b text-xs uppercase text-slate-500"><tr><th class="px-6 py-4">Tên Đề</th><th class="px-6 py-4 text-center">Mã</th><th class="px-6 py-4 text-center">Thời gian</th><th class="px-6 py-4 text-center">Trạng thái</th><th class="px-6 py-4 text-right">Hành động</th></tr></thead>
                 <tbody class="divide-y divide-slate-100">
                     <?php foreach($all_exams as $ex): ?>
                     <tr class="hover:bg-slate-50">
                         <td class="px-6 py-4 font-bold text-slate-800"><?= htmlspecialchars($ex['title']) ?></td>
                         <td class="px-6 py-4 text-center"><span class="bg-slate-100 px-2 py-1 rounded text-xs font-bold"><?= htmlspecialchars($ex['code']) ?></span></td>
                         <td class="px-6 py-4 text-center"><?= $ex['duration'] ?>p</td>
                         <td class="px-6 py-4 text-center">
                             <a href="?action=admin_toggle_exam&id=<?= $ex['id'] ?>" class="text-xs font-bold px-2 py-1 rounded <?= $ex['status']=='active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' ?>"><?= $ex['status']=='active' ? 'Đang Mở' : 'Đã Đóng' ?></a>
                         </td>
                         <td class="px-6 py-4 text-right space-x-2">
                             <a href="?action=admin_exam_form&id=<?= $ex['id'] ?>" class="inline-block bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1.5 rounded font-bold"><i class="fa-solid fa-pen"></i> Sửa</a>
                             <a href="?action=admin_delete_exam&id=<?= $ex['id'] ?>" onclick="return confirm('Chắc chắn xóa? Toàn bộ kết quả của hs cũng sẽ mất!')" class="inline-block bg-rose-100 text-rose-700 hover:bg-rose-200 px-3 py-1.5 rounded font-bold"><i class="fa-solid fa-trash"></i></a>
                         </td>
                     </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         </div>
     </div>

     <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
         <div class="px-6 py-5 border-b border-slate-100 bg-slate-50"><h3 class="font-bold text-lg"><i class="fa-solid fa-clock-rotate-left text-primary mr-2"></i> Lịch Sử Nộp Bài Gần Đây</h3></div>
         <div class="overflow-x-auto w-full">
             <table class="min-w-full text-left text-sm">
                 <thead class="bg-white border-b text-xs uppercase text-slate-500"><tr><th class="px-6 py-4">Tài khoản</th><th class="px-6 py-4">Đề thi</th><th class="px-6 py-4 text-center">Điểm</th><th class="px-6 py-4 text-center">Nộp lúc</th><th class="px-6 py-4"></th></tr></thead>
                 <tbody class="divide-y divide-slate-100">
                     <?php foreach($history as $h): ?>
                     <tr class="hover:bg-slate-50">
                         <td class="px-6 py-4"><div class="font-bold">@<?= htmlspecialchars($h['username']) ?></div><div class="text-xs text-slate-500"><?= htmlspecialchars($h['fullname']) ?></div></td>
                         <td class="px-6 py-4 font-medium"><span class="line-clamp-1"><?= htmlspecialchars($h['exam_title']) ?></span></td>
                         <td class="px-6 py-4 text-center"><span class="font-bold <?= $h['score'] >= 5 ? 'text-emerald-600' : 'text-rose-600' ?>"><?= number_format($h['score'], 1) ?></span></td>
                         <td class="px-6 py-4 text-center text-slate-500"><?= date('d/m H:i', strtotime($h['created_at'])) ?></td>
                         <td class="px-6 py-4 text-right"><a href="?action=result&id=<?= $h['id'] ?>" target="_blank" class="text-primary font-medium hover:underline">Xem</a></td>
                     </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         </div>
     </div>

     <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
         <div class="px-6 py-5 border-b border-slate-100 bg-slate-50"><h3 class="font-bold text-lg"><i class="fa-solid fa-users text-emerald-600 mr-2"></i> Danh Sách Học Sinh</h3></div>
         <div class="overflow-x-auto w-full max-h-96">
             <table class="min-w-full text-left text-sm">
                 <thead class="bg-white border-b text-xs uppercase text-slate-500 sticky top-0"><tr><th class="px-6 py-4">ID</th><th class="px-6 py-4">Tài khoản</th><th class="px-6 py-4">Họ và Tên</th><th class="px-6 py-4 text-right">Ngày đăng ký</th></tr></thead>
                 <tbody class="divide-y divide-slate-100">
                     <?php foreach($all_users as $u): ?>
                     <tr class="hover:bg-slate-50">
                         <td class="px-6 py-4 font-mono text-slate-400">#<?= $u['id'] ?></td>
                         <td class="px-6 py-4 font-bold text-primary">@<?= htmlspecialchars($u['username']) ?></td>
                         <td class="px-6 py-4 font-bold"><?= htmlspecialchars($u['fullname']) ?></td>
                         <td class="px-6 py-4 text-right text-slate-500"><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                     </tr>
                     <?php endforeach; ?>
                 </tbody>
             </table>
         </div>
     </div>
 </div>

<?php 
elseif (is_logged_in() && is_admin() && $action == 'admin_settings'): 
?>
  <div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 w-full overflow-hidden">
      <div class="flex items-center gap-3 mb-6">
          <a href="?action=admin" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-2 rounded-lg font-bold transition"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
          <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Cài Đặt Hệ Thống</h1>
      </div>

      <form method="POST" action="?action=admin_save_settings" class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

          <h2 class="text-lg font-bold mb-5 flex items-center gap-2 border-b border-slate-100 pb-3 text-primary"><i class="fa-solid fa-image"></i> Cấu hình Logo & Favicon</h2>
          
          <div class="space-y-6">
              <div>
                  <label class="block font-bold text-sm text-slate-700 mb-3">Loại hiển thị Logo <span class="text-rose-500">*</span></label>
                  <div class="flex gap-4">
                      <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-4 py-2.5 rounded-xl cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-sky-50">
                          <input type="radio" name="logo_type" value="icon" <?= ($site_settings['logo_type'] ?? 'icon') == 'icon' ? 'checked' : '' ?> class="text-primary focus:ring-primary w-4 h-4 cursor-pointer" onchange="toggleLogoSettings()">
                          <span class="font-bold text-slate-700 text-sm">Dùng Icon FontAwesome</span>
                      </label>
                      <label class="flex items-center gap-2 bg-slate-50 border border-slate-200 px-4 py-2.5 rounded-xl cursor-pointer hover:border-primary transition-all has-[:checked]:border-primary has-[:checked]:bg-sky-50">
                          <input type="radio" name="logo_type" value="image" <?= ($site_settings['logo_type'] ?? 'icon') == 'image' ? 'checked' : '' ?> class="text-primary focus:ring-primary w-4 h-4 cursor-pointer" onchange="toggleLogoSettings()">
                          <span class="font-bold text-slate-700 text-sm">Dùng Hình Ảnh</span>
                      </label>
                  </div>
              </div>

              <div id="setting_logo_icon" class="<?= ($site_settings['logo_type'] ?? 'icon') == 'icon' ? 'block' : 'hidden' ?> bg-sky-50/50 p-4 rounded-xl border border-sky-100">
                  <label class="block font-bold text-sm text-slate-700 mb-1.5">Class Icon FontAwesome (v6.4.0)</label>
                  <p class="text-xs text-slate-500 mb-2">Truy cập fontawesome.com để lấy class. VD: <code class="bg-slate-200 px-1 rounded">fa-solid fa-microchip</code></p>
                  <div class="flex gap-3">
                      <input type="text" id="logo_icon_input" name="logo_icon" value="<?= htmlspecialchars($site_settings['logo_icon'] ?? '') ?>" class="block w-full border border-slate-300 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm transition-all" oninput="document.getElementById('icon_preview').className = this.value + ' text-3xl text-primary'">
                      <div class="w-12 h-11 shrink-0 bg-white border border-slate-200 rounded-xl flex items-center justify-center">
                          <i id="icon_preview" class="<?= htmlspecialchars($site_settings['logo_icon'] ?? 'fa-solid fa-microchip') ?> text-2xl text-primary"></i>
                      </div>
                  </div>
              </div>

              <div id="setting_logo_image" class="<?= ($site_settings['logo_type'] ?? 'icon') == 'image' ? 'block' : 'hidden' ?> bg-sky-50/50 p-4 rounded-xl border border-sky-100">
                  <label class="block font-bold text-sm text-slate-700 mb-1.5">Hình ảnh Logo (URL hoặc Upload)</label>
                  <div class="flex flex-col sm:flex-row gap-3">
                      <div class="w-16 h-16 shrink-0 bg-white border border-slate-200 rounded-xl flex items-center justify-center overflow-hidden">
                          <img id="logo_img_preview" src="<?= htmlspecialchars($site_settings['logo_image'] ?? '') ?>" class="max-w-full max-h-full object-contain <?= empty($site_settings['logo_image']) ? 'hidden' : '' ?>">
                          <i id="logo_img_placeholder" class="fa-regular fa-image text-2xl text-slate-300 <?= !empty($site_settings['logo_image']) ? 'hidden' : '' ?>"></i>
                      </div>
                      <div class="flex-grow space-y-2">
                          <div class="flex gap-2">
                              <input type="text" id="logo_image_input" name="logo_image" value="<?= htmlspecialchars($site_settings['logo_image'] ?? '') ?>" class="block w-full border border-slate-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm transition-all" placeholder="https://..." oninput="updatePreview('logo_image_input', 'logo_img_preview', 'logo_img_placeholder')">
                              <button type="button" onclick="document.getElementById('upload_logo').click()" class="shrink-0 bg-white border border-slate-300 hover:bg-slate-50 px-3 py-2 rounded-lg text-sm font-bold text-slate-700 transition flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-up"></i> Upload</button>
                              <input type="file" id="upload_logo" accept="image/*" class="hidden" onchange="uploadSettingFile(this, 'logo_image_input', 'logo_img_preview', 'logo_img_placeholder')">
                          </div>
                          <p class="text-xs text-slate-500">Nên dùng ảnh PNG vuông có nền trong suốt.</p>
                      </div>
                  </div>
              </div>

              <div class="w-full h-px bg-slate-100 my-4"></div>

              <div>
                  <label class="block font-bold text-sm text-slate-700 mb-1.5">Hình ảnh Favicon (Icon trên Tab Trình Duyệt)</label>
                  <div class="flex flex-col sm:flex-row gap-3">
                      <div class="w-12 h-12 shrink-0 bg-white border border-slate-200 rounded-xl flex items-center justify-center overflow-hidden">
                          <img id="fav_img_preview" src="<?= htmlspecialchars($site_settings['favicon'] ?? '') ?>" class="max-w-full max-h-full object-contain <?= empty($site_settings['favicon']) ? 'hidden' : '' ?>">
                          <i id="fav_img_placeholder" class="fa-solid fa-globe text-xl text-slate-300 <?= !empty($site_settings['favicon']) ? 'hidden' : '' ?>"></i>
                      </div>
                      <div class="flex-grow space-y-2">
                          <div class="flex gap-2">
                              <input type="text" id="favicon_input" name="favicon" value="<?= htmlspecialchars($site_settings['favicon'] ?? '') ?>" class="block w-full border border-slate-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm transition-all" placeholder="https://..." oninput="updatePreview('favicon_input', 'fav_img_preview', 'fav_img_placeholder')">
                              <button type="button" onclick="document.getElementById('upload_fav').click()" class="shrink-0 bg-white border border-slate-300 hover:bg-slate-50 px-3 py-2 rounded-lg text-sm font-bold text-slate-700 transition flex items-center gap-2"><i class="fa-solid fa-cloud-arrow-up"></i> Upload</button>
                              <input type="file" id="upload_fav" accept=".ico,.png,.webp,.jpg" class="hidden" onchange="uploadSettingFile(this, 'favicon_input', 'fav_img_preview', 'fav_img_placeholder')">
                          </div>
                          <p class="text-xs text-slate-500">Hỗ trợ định dạng .ico hoặc .png (Kích thước khuyên dùng: 32x32 hoặc 64x64).</p>
                      </div>
                  </div>
              </div>

          </div>

          <div class="mt-8 pt-5 border-t border-slate-100 text-right">
              <button type="submit" class="bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-xl shadow-lg shadow-primary/30 transition-all text-sm flex items-center justify-center gap-2 w-full sm:w-auto ml-auto">
                  <i class="fa-solid fa-floppy-disk"></i> LƯU CÀI ĐẶT
              </button>
          </div>
      </form>
  </div>

  <script>
      function toggleLogoSettings() {
          const isIcon = document.querySelector('input[name="logo_type"][value="icon"]').checked;
          document.getElementById('setting_logo_icon').style.display = isIcon ? 'block' : 'none';
          document.getElementById('setting_logo_image').style.display = isIcon ? 'none' : 'block';
      }

      function updatePreview(inputId, imgId, placeholderId) {
          const url = document.getElementById(inputId).value;
          const img = document.getElementById(imgId);
          const placeholder = document.getElementById(placeholderId);
          
          if(url) {
              img.src = url;
              img.classList.remove('hidden');
              placeholder.classList.add('hidden');
          } else {
              img.classList.add('hidden');
              placeholder.classList.remove('hidden');
          }
      }

      function uploadSettingFile(input, targetInputId, previewImgId, placeholderId) {
          if(!input.files || input.files.length === 0) return;
          const file = input.files[0];
          if(file.size > 5 * 1024 * 1024) { alert("File vượt quá 5MB!"); return; }
          
          const targetInput = document.getElementById(targetInputId);
          const originalText = targetInput.value;
          targetInput.value = "Đang tải lên...";
          targetInput.disabled = true;

          const formData = new FormData(); formData.append('file', file);
          fetch('index.php?action=ajax_upload_image', { method: 'POST', body: formData })
          .then(response => response.json())
          .then(data => {
              targetInput.disabled = false;
              if(data.error) { 
                  targetInput.value = originalText;
                  alert("Lỗi: " + data.error); 
              } else if(data.url) {
                  targetInput.value = data.url;
                  updatePreview(targetInputId, previewImgId, placeholderId);
              }
          })
          .catch(error => { 
              targetInput.disabled = false;
              targetInput.value = originalText;
              alert("Lỗi kết nối máy chủ!"); 
          });
      }
  </script>

<?php 
elseif (is_logged_in() && is_admin() && $action == 'admin_exam_form'): 
  $edit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  $is_edit = $edit_id > 0;
  $ex_data = ['title'=>'', 'code'=>'', 'duration'=>50, 'description'=>'', 'is_shuffled'=>1];
  $q_mcq = []; $q_tf = [];

  if ($is_edit) {
      $ex_data = $pdo->query("SELECT * FROM exams WHERE id = $edit_id")->fetch();
      if(!$ex_data) { echo "<meta charset='UTF-8'><script>alert('Không tìm thấy đề thi!'); window.location.href='?action=admin';</script>"; exit; }
      
      $stmt_mcq = $pdo->query("SELECT q.q_index, q.content, q.shared_context, a.opt_a, a.opt_b, a.opt_c, a.opt_d, a.correct_opt FROM questions q JOIN answers_mcq a ON q.id = a.question_id WHERE q.exam_id = $edit_id AND q.q_type = 'mcq'");
      while($row = $stmt_mcq->fetch()) { $q_mcq[$row['q_index']] = $row; }
      
      $stmt_tf = $pdo->query("SELECT q.q_index, q.content, q.shared_context, a.part_a, a.is_a_true, a.part_b, a.is_b_true, a.part_c, a.is_c_true, a.part_d, a.is_d_true FROM questions q JOIN answers_tf a ON q.id = a.question_id WHERE q.exam_id = $edit_id AND q.q_type = 'tf'");
      while($row = $stmt_tf->fetch()) { $q_tf[$row['q_index']] = $row; }
  }
?>
 <div class="max-w-6xl mx-auto px-2 sm:px-6 py-8 w-full overflow-hidden">
     <div class="flex items-center gap-3 mb-6 px-2">
         <a href="?action=admin" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-3 py-2 rounded-lg font-bold"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
         <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight ml-2">
             <?= $is_edit ? 'Sửa Đề Công Nghệ <span class="text-primary">#'.$edit_id.'</span>' : 'Soạn Đề Công Nghệ Mới' ?>
         </h1>
     </div>
     
     <form method="POST" action="?action=admin_submit_exam" class="space-y-6 w-full px-2" id="createExamForm">
         <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
         <?php if($is_edit): ?><input type="hidden" name="edit_exam_id" value="<?= $edit_id ?>"><?php endif; ?>
         
         <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 space-y-4">
             <h2 class="text-lg font-bold border-b pb-2"><i class="fa-solid fa-sliders opacity-50"></i> Cài đặt chung</h2>
             <div class="w-full"><label class="block font-bold text-sm mb-1">Tên đề thi *</label><input type="text" name="title" value="<?= htmlspecialchars($ex_data['title']) ?>" required class="block w-full border border-slate-300 p-3 rounded-lg outline-none focus:border-primary"></div>
             <div class="w-full"><label class="block font-bold text-sm mb-1">Mã đề *</label><input type="text" name="code" value="<?= htmlspecialchars($ex_data['code']) ?>" required class="block w-full border border-slate-300 p-3 rounded-lg outline-none focus:border-primary"></div>
             <div class="w-full"><label class="block font-bold text-sm mb-1">Thời gian (Phút) *</label><input type="number" name="duration" value="<?= $ex_data['duration'] ?>" required class="block w-full border border-slate-300 p-3 rounded-lg outline-none focus:border-primary"></div>
             <div class="w-full"><label class="block font-bold text-sm mb-1">Mô tả</label><input type="text" name="description" value="<?= htmlspecialchars($ex_data['description'] ?? '') ?>" class="block w-full border border-slate-300 p-3 rounded-lg outline-none focus:border-primary"></div>
         </div>

         <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 w-full overflow-hidden">
             <h2 class="text-lg font-bold text-primary mb-4 border-b pb-2"><i class="fa-solid fa-wand-magic-sparkles"></i> I. Nhập Nhanh Trắc Nghiệm (24 Câu)</h2>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                     <label class="block text-xs font-bold text-slate-500 mb-1">1. Nội dung 24 câu hỏi (Mỗi câu 1 dòng)</label>
                     <textarea id="fastMCQ_Content" class="w-full border border-slate-300 rounded-lg p-3 text-sm bg-slate-50 h-40 focus:bg-white outline-none focus:border-primary transition-all" placeholder="Câu 1...&#10;Câu 2..."></textarea>
                 </div>
                 <div>
                     <label class="block text-xs font-bold text-slate-500 mb-1">2. Nội dung đáp án (Dán A, B, C, D liên tiếp)</label>
                     <textarea id="fastMCQ_Options" class="w-full border border-slate-300 rounded-lg p-3 text-sm bg-slate-50 h-40 focus:bg-white outline-none focus:border-primary transition-all" placeholder="A. ... B. ... C. ... D. ..."></textarea>
                 </div>
             </div>
             <div class="mt-4">
                 <label class="block text-xs font-bold text-slate-500 mb-1">3. Bảng đáp án (VD: 1 A, 2 B...)</label>
                 <textarea id="fastMCQ_Keys" class="w-full border border-slate-300 rounded-lg p-3 text-sm bg-slate-50 h-20 focus:bg-white outline-none focus:border-primary transition-all" placeholder="1 A&#10;2 C"></textarea>
             </div>
             <button type="button" onclick="applyMCQFast()" class="mt-3 bg-primary hover:bg-secondary text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all flex items-center gap-2 text-sm">
                 <i class="fa-solid fa-check-to-slot"></i> ÁP DỤNG CHO 24 CÂU TRÊN
             </button>
         </div>

         <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 w-full overflow-hidden">
             <h2 class="text-lg font-bold text-purple-700 mb-4 border-b pb-2"><i class="fa-solid fa-wand-magic-sparkles"></i> II. Nhập Nhanh Đúng/Sai (4 Câu)</h2>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div>
                     <label class="block text-xs font-bold text-slate-500 mb-1">1. Nội dung 4 câu hỏi (Mỗi câu 1 dòng)</label>
                     <textarea id="fastTF_Content" class="w-full border border-slate-300 rounded-lg p-3 text-sm bg-slate-50 h-32 focus:bg-white outline-none focus:border-purple-500 transition-all" placeholder="Câu 25...&#10;Câu 26..."></textarea>
                 </div>
                 <div>
                     <label class="block text-xs font-bold text-slate-500 mb-1">2. Nội dung 4 ý a, b, c, d (Dán liên tiếp)</label>
                     <textarea id="fastTF_Parts" class="w-full border border-slate-300 rounded-lg p-3 text-sm bg-slate-50 h-32 focus:bg-white outline-none focus:border-purple-500 transition-all" placeholder="a) ... b) ... c) ... d) ..."></textarea>
                 </div>
             </div>
             <div class="mt-4">
                 <label class="block text-xs font-bold text-slate-500 mb-1">3. Bảng đáp án (VD: 25 SĐĐS...)</label>
                 <textarea id="fastTF_Keys" class="w-full border border-slate-300 rounded-lg p-3 text-sm bg-slate-50 h-20 focus:bg-white outline-none focus:border-purple-500 transition-all" placeholder="25 SĐĐS&#10;26 ĐSĐĐ"></textarea>
             </div>
             <button type="button" onclick="applyTFFast()" class="mt-3 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all flex items-center gap-2 text-sm">
                 <i class="fa-solid fa-check-to-slot"></i> ÁP DỤNG CHO 4 CÂU DƯỚI
             </button>
         </div>

         <div class="bg-white p-3 sm:p-6 rounded-2xl shadow-sm border border-slate-200 w-full overflow-hidden">
             <h2 class="text-lg font-bold text-primary mb-4 border-b pb-2">I. Danh Sách 24 Câu Trắc Nghiệm</h2>
             <div class="space-y-6 w-full">
                 <?php for($i=1; $i<=24; $i++): 
                     $q_data = $q_mcq[$i] ?? null;
                 ?>
                 <div class="bg-slate-50 p-4 border border-slate-200 rounded-xl w-full box-border">
                     <div class="font-bold mb-2 text-primary">Câu <?= $i ?>:</div>

                     <div class="flex flex-wrap gap-2 mb-2 w-full">
                         <button type="button" onclick="openMediaModal('mcq_<?= $i ?>_content_input')" class="text-xs bg-sky-100 text-primary px-3 py-1.5 rounded shadow-sm font-bold"><i class="fa-regular fa-image"></i> Ảnh vào câu hỏi</button>
                         <button type="button" onclick="openTableModal('mcq_<?= $i ?>_content_input')" class="text-xs bg-slate-200 text-slate-700 px-3 py-1.5 rounded shadow-sm font-bold"><i class="fa-solid fa-table"></i> Bảng vào câu hỏi</button>
                     </div>
                     <textarea id="mcq_<?= $i ?>_content_input" name="mcq_<?= $i ?>_content" required class="block w-full border border-slate-300 p-3 rounded-lg text-sm outline-none box-border mb-3 min-h-[80px]" placeholder="Nhập nội dung câu hỏi..."><?= htmlspecialchars($q_data['content'] ?? '') ?></textarea>

                     <div class="text-sm font-bold opacity-60 mb-2">Đáp án (Tick vào đáp án đúng):</div>
                     <div class="flex flex-col gap-2 w-full">
                         <?php foreach(['a','b','c','d'] as $opt): 
                             $is_checked = ($q_data && strtolower($q_data['correct_opt']) == $opt);
                         ?>
                         <div class="flex items-center bg-white border border-slate-300 rounded-lg p-2 w-full box-border group">
                             <input type="radio" name="mcq_<?= $i ?>_correct" value="<?= strtoupper($opt) ?>" <?= $is_checked ? 'checked' : '' ?> class="w-5 h-5 text-emerald-500 shrink-0 ml-1 cursor-pointer">
                             <span class="font-black w-8 text-center shrink-0"><?= strtoupper($opt) ?>.</span>
                             <textarea id="mcq_<?= $i ?>_<?= $opt ?>_input" name="mcq_<?= $i ?>_<?= $opt ?>" required class="flex-1 min-w-0 border-none bg-transparent outline-none p-1 text-sm resize-y custom-scrollbar" rows="1" placeholder="Nội dung..."><?= htmlspecialchars($q_data['opt_'.$opt] ?? '') ?></textarea>
                             <button type="button" onclick="openMediaModal('mcq_<?= $i ?>_<?= $opt ?>_input')" class="shrink-0 p-2 opacity-50 hover:opacity-100"><i class="fa-regular fa-image"></i></button>
                         </div>
                         <?php endforeach; ?>
                     </div>
                 </div>
                 <?php endfor; ?>
             </div>
         </div>

         <div class="bg-white p-3 sm:p-6 rounded-2xl shadow-sm border border-slate-200 w-full overflow-hidden">
             <h2 class="text-lg font-bold text-purple-700 mb-4 border-b pb-2">II. Danh Sách 4 Câu Đúng/Sai</h2>
             <div class="space-y-6 w-full">
                 <?php for($i=25; $i<=28; $i++): 
                     $q_data = $q_tf[$i] ?? null;
                 ?>
                 <div class="bg-slate-50 p-4 border border-slate-200 rounded-xl w-full box-border">
                     <div class="font-bold mb-2 text-purple-700">Câu <?= $i ?>:</div>

                     <div class="flex flex-wrap gap-2 mb-2 w-full">
                         <button type="button" onclick="openMediaModal('tf_<?= $i ?>_content_input')" class="text-xs bg-purple-100 text-purple-700 px-3 py-1.5 rounded shadow-sm font-bold"><i class="fa-regular fa-image"></i> Ảnh vào câu hỏi</button>
                         <button type="button" onclick="openTableModal('tf_<?= $i ?>_content_input')" class="text-xs bg-slate-200 text-slate-700 px-3 py-1.5 rounded shadow-sm font-bold"><i class="fa-solid fa-table"></i> Bảng vào câu hỏi</button>
                     </div>
                     <textarea id="tf_<?= $i ?>_content_input" name="tf_<?= $i ?>_content" required class="block w-full border border-slate-300 p-3 rounded-lg text-sm outline-none box-border mb-3 min-h-[80px]" placeholder="Nhập câu hỏi..."><?= htmlspecialchars($q_data['content'] ?? '') ?></textarea>

                     <div class="text-sm font-bold opacity-60 mb-2">4 Ý (Tick nếu ý đó ĐÚNG):</div>
                     <div class="flex flex-col gap-3 w-full">
                         <?php foreach(['a','b','c','d'] as $opt): 
                             $is_checked = $q_data && $q_data['is_'.$opt.'_true'] == 1;
                         ?>
                         <div class="flex flex-col sm:flex-row bg-white border border-slate-300 rounded-lg p-2 gap-2 w-full box-border">
                             <div class="flex flex-1 items-center min-w-0 border-b sm:border-0 pb-2 sm:pb-0">
                                 <span class="font-black w-8 text-center bg-slate-100 rounded mr-2 py-1 shrink-0"><?= $opt ?>)</span>
                                 <textarea id="tf_<?= $i ?>_<?= $opt ?>_input" name="tf_<?= $i ?>_<?= $opt ?>" required class="flex-1 min-w-0 border-none outline-none text-sm p-1 resize-y custom-scrollbar" rows="1" placeholder="Nội dung ý <?= $opt ?>..."><?= htmlspecialchars($q_data['part_'.$opt] ?? '') ?></textarea>
                                 <button type="button" onclick="openMediaModal('tf_<?= $i ?>_<?= $opt ?>_input')" class="shrink-0 p-2 opacity-50 hover:opacity-100"><i class="fa-regular fa-image"></i></button>
                             </div>
                             <label class="flex justify-center items-center gap-2 bg-slate-100 px-3 py-2 rounded shrink-0 cursor-pointer text-sm font-bold has-[:checked]:bg-emerald-500 has-[:checked]:text-white transition w-full sm:w-auto box-border">
                                 <input type="checkbox" name="tf_<?= $i ?>_<?= $opt ?>_true" <?= $is_checked ? 'checked' : '' ?> class="w-4 h-4"> Ý ĐÚNG
                             </label>
                         </div>
                         <?php endforeach; ?>
                     </div>
                 </div>
                 <?php endfor; ?>
             </div>
         </div>

         <div class="sticky bottom-2 z-40">
             <button type="submit" class="w-full bg-slate-900 text-white font-black py-4 rounded-xl shadow-2xl text-lg hover:bg-slate-800 transition">
                 <i class="fa-solid fa-save"></i> <?= $is_edit ? 'CẬP NHẬT ĐỀ THI' : 'LƯU ĐỀ THI MỚI' ?>
             </button>
         </div>
     </form>
 </div>

 <div id="mediaModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300 p-4">
     <div class="bg-white rounded-xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 box-border" id="mediaModalContent">
         <div class="bg-slate-50 border-b p-4 flex justify-between items-center"><h3 class="font-bold"><i class="fa-regular fa-images text-primary mr-2"></i> Chèn Hình Ảnh</h3><button type="button" onclick="closeMediaModal()" class="text-slate-400 p-1"><i class="fa-solid fa-xmark text-xl"></i></button></div>
         <div class="p-4"><input type="hidden" id="targetInputIdMedia" value=""><div class="flex border-b mb-4"><button type="button" onclick="switchMediaTab('upload')" id="tab_btn_upload" class="flex-1 py-2 font-bold text-sm text-primary border-b-2 border-primary">Tải lên</button><button type="button" onclick="switchMediaTab('link')" id="tab_btn_link" class="flex-1 py-2 font-bold text-sm text-slate-400 border-b-2 border-transparent">Link URL</button></div><div id="tab_upload"><div class="border-2 border-dashed border-slate-300 rounded p-6 text-center relative"><input type="file" id="imageUploadInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0" onchange="handleFileUpload(this)"><i class="fa-solid fa-cloud-arrow-up text-3xl opacity-30 mb-2"></i><p class="text-sm font-medium">Bấm chọn ảnh (Max 5MB)</p></div><div id="uploadStatus" class="hidden text-sm text-center font-bold mt-2"></div></div><div id="tab_link" class="hidden space-y-3"><input type="url" id="imageUrlInput" class="w-full border p-2 rounded text-sm" placeholder="https://..."><button type="button" onclick="insertLinkMedia()" class="w-full bg-primary text-white font-bold py-2 rounded">Chèn ảnh</button></div></div>
     </div>
 </div>
 <div id="tableModal" class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-50 hidden flex items-center justify-center opacity-0 transition-opacity duration-300 p-2">
     <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg flex flex-col max-h-[95vh] transform scale-95 transition-transform duration-300" id="tableModalContent">
         <div class="bg-slate-50 border-b p-4 flex justify-between items-center shrink-0"><h3 class="font-bold"><i class="fa-solid fa-table text-blue-600 mr-2"></i> Tạo Bảng Tùy Chỉnh</h3><button type="button" onclick="closeTableModal()" class="text-slate-400 p-1"><i class="fa-solid fa-xmark text-xl"></i></button></div>
         <div class="p-3 overflow-y-auto flex-grow bg-slate-100 text-sm">
             <input type="hidden" id="targetInputIdTable" value="">
             <div class="flex gap-3 mb-3">
                 <div class="flex-1">
                     <label class="block text-xs font-bold text-slate-500 mb-1">Tiêu đề Cột 1</label>
                     <input type="text" id="col1_header" value="Thông số" class="w-full border border-slate-200 p-2 rounded-lg text-sm outline-none focus:border-blue-500 font-bold" placeholder="VD: Thông số...">
                 </div>
                 <div class="flex-1">
                     <label class="block text-xs font-bold text-slate-500 mb-1">Tiêu đề Cột 2</label>
                     <input type="text" id="col2_header" value="Giá trị" class="w-full border border-slate-200 p-2 rounded-lg text-sm outline-none focus:border-blue-500 font-bold" placeholder="VD: Giá trị...">
                 </div>
             </div>
             <div id="tableRowsContainer" class="space-y-2"></div>
             <button type="button" onclick="addTableRow()" class="mt-3 bg-white border border-dashed border-slate-300 hover:text-primary font-bold py-2 w-full rounded shadow-sm"><i class="fa-solid fa-plus"></i> Thêm dòng</button>
         </div>
         <div class="p-3 bg-white border-t shrink-0"><button type="button" onclick="insertTable()" class="w-full bg-blue-600 text-white font-bold py-2.5 rounded shadow-md">Chèn Bảng Này</button></div>
     </div>
 </div>
 
 <script>
     function applyMCQFast() {
         let contentText = document.getElementById('fastMCQ_Content').value;
         let keysText = document.getElementById('fastMCQ_Keys').value;
         let filledCount = 0;

         if(contentText) {
             let rawBlocks = contentText.split(/(?=^\s*Câu\s+\d+)/mi).filter(b => b.trim() !== '');
             let currentIdx = 1;
             
             for (let i = 1; i <= 24; i++) {
                 let el = document.getElementById(`mcq_${i}_content_input`);
                 if (el && el.value.trim() === '') {
                     currentIdx = i;
                     break;
                 }
             }
             
             rawBlocks.forEach(block => {
                 if (currentIdx > 24) return;
                 
                 let optA="", optB="", optC="", optD="", qContent="";
                 let matchA = block.match(/(?:^|\s)A[\.\)\:]\s*([\s\S]*?)(?=(?:^|\s)B[\.\)\:]\s*|$)/i);
                 let matchB = block.match(/(?:^|\s)B[\.\)\:]\s*([\s\S]*?)(?=(?:^|\s)C[\.\)\:]\s*|$)/i);
                 let matchC = block.match(/(?:^|\s)C[\.\)\:]\s*([\s\S]*?)(?=(?:^|\s)D[\.\)\:]\s*|$)/i);
                 let matchD = block.match(/(?:^|\s)D[\.\)\:]\s*([\s\S]*?)$/i);
                 
                 optA = matchA ? matchA[1].trim() : "";
                 optB = matchB ? matchB[1].trim() : "";
                 optC = matchC ? matchC[1].trim() : "";
                 optD = matchD ? matchD[1].trim() : "";
                 
                 let firstOptIndex = block.search(/(?:^|\s)A[\.\)\:]\s*/i);
                 if (firstOptIndex !== -1) {
                     qContent = block.substring(0, firstOptIndex).trim();
                 } else {
                     qContent = block.trim();
                 }
                 
                 qContent = qContent.replace(/^\s*Câu\s+\d+[\.\:\s\-\)]*/i, '').trim();
                 
                 let elContent = document.getElementById(`mcq_${currentIdx}_content_input`);
                 if (elContent) {
                     if (qContent) elContent.value = qContent;
                     if (optA) document.getElementById(`mcq_${currentIdx}_a_input`).value = optA;
                     if (optB) document.getElementById(`mcq_${currentIdx}_b_input`).value = optB;
                     if (optC) document.getElementById(`mcq_${currentIdx}_c_input`).value = optC;
                     if (optD) document.getElementById(`mcq_${currentIdx}_d_input`).value = optD;
                     
                     elContent.closest('.bg-slate-50').classList.add('ring-2', 'ring-primary');
                     setTimeout(() => elContent.closest('.bg-slate-50').classList.remove('ring-2', 'ring-primary'), 1000);
                     
                     filledCount++;
                     currentIdx++;
                 }
             });
         }

         if(keysText) {
             let lines = keysText.split('\n');
             lines.forEach(line => {
                 line = line.trim().toUpperCase();
                 let m = line.match(/^0?([1-9]|1[0-9]|2[0-4])[\s\.\-\:]+([A-D])$/);
                 if(m) {
                     let qNum = parseInt(m[1]);
                     let ans = m[2];
                     let radios = document.getElementsByName('mcq_' + qNum + '_correct');
                     for (let i = 0; i < radios.length; i++) {
                         if (radios[i].value === ans) radios[i].checked = true;
                     }
                 }
             });
         }
         alert(`Đã áp dụng dữ liệu! Bóc tách được ${filledCount} câu trắc nghiệm.`);
     }

     function applyTFFast() {
         let contentText = document.getElementById('fastTF_Content').value;
         let keysText = document.getElementById('fastTF_Keys').value;
         let filledCount = 0;

         if(contentText) {
             let rawBlocks = contentText.split(/(?=^\s*Câu\s+\d+)/mi).filter(b => b.trim() !== '');
             let currentIdx = 25;
             
             for (let i = 25; i <= 28; i++) {
                 let el = document.getElementById(`tf_${i}_content_input`);
                 if (el && el.value.trim() === '') {
                     currentIdx = i;
                     break;
                 }
             }
             
             rawBlocks.forEach(block => {
                 if (currentIdx > 28) return;
                 
                 let optA="", optB="", optC="", optD="", qContent="";
                 let matchA = block.match(/(?:^|\s)a[\.\)\:]\s*([\s\S]*?)(?=(?:^|\s)b[\.\)\:]\s*|$)/i);
                 let matchB = block.match(/(?:^|\s)b[\.\)\:]\s*([\s\S]*?)(?=(?:^|\s)c[\.\)\:]\s*|$)/i);
                 let matchC = block.match(/(?:^|\s)c[\.\)\:]\s*([\s\S]*?)(?=(?:^|\s)d[\.\)\:]\s*|$)/i);
                 let matchD = block.match(/(?:^|\s)d[\.\)\:]\s*([\s\S]*?)$/i);
                 
                 optA = matchA ? matchA[1].trim() : "";
                 optB = matchB ? matchB[1].trim() : "";
                 optC = matchC ? matchC[1].trim() : "";
                 optD = matchD ? matchD[1].trim() : "";
                 
                 let firstOptIndex = block.search(/(?:^|\s)a[\.\)\:]\s*/i);
                 if (firstOptIndex !== -1) {
                     qContent = block.substring(0, firstOptIndex).trim();
                 } else {
                     qContent = block.trim();
                 }
                 
                 qContent = qContent.replace(/^\s*Câu\s+\d+[\.\:\s\-\)]*/i, '').trim();
                 
                 let elContent = document.getElementById(`tf_${currentIdx}_content_input`);
                 if (elContent) {
                     if (qContent) elContent.value = qContent;
                     if (optA) document.getElementById(`tf_${currentIdx}_a_input`).value = optA;
                     if (optB) document.getElementById(`tf_${currentIdx}_b_input`).value = optB;
                     if (optC) document.getElementById(`tf_${currentIdx}_c_input`).value = optC;
                     if (optD) document.getElementById(`tf_${currentIdx}_d_input`).value = optD;
                     
                     elContent.closest('.bg-slate-50').classList.add('ring-2', 'ring-purple-400');
                     setTimeout(() => elContent.closest('.bg-slate-50').classList.remove('ring-2', 'ring-purple-400'), 1000);
                     
                     filledCount++;
                     currentIdx++;
                 }
             });
         }

         if(keysText) {
             let lines = keysText.split('\n');
             lines.forEach(line => {
                 line = line.trim().toUpperCase();
                 let m = line.match(/^(?:0?([1-4])|2[5-8])[\s\.\-\:]+([SĐD]{4})$/);
                 if(m) {
                     let qNumStr = m[1];
                     let qNum = qNumStr ? parseInt(qNumStr) + 24 : parseInt(line.match(/^(2[5-8])/)[1]);
                     let pattern = m[2].replace(/D/g, 'Đ');
                     
                     let opts = ['a', 'b', 'c', 'd'];
                     for (let i = 0; i < 4; i++) {
                         let isTrue = (pattern[i] === 'Đ');
                         let chk = document.getElementsByName('tf_' + qNum + '_' + opts[i] + '_true')[0];
                         if(chk) chk.checked = isTrue;
                     }
                 }
             });
         }
         alert(`Đã áp dụng dữ liệu! Bóc tách được ${filledCount} câu Đúng/Sai.`);
     }

     function openMediaModal(t){document.getElementById('targetInputIdMedia').value=t;const m=document.getElementById('mediaModal'),c=document.getElementById('mediaModalContent');m.classList.remove('hidden');document.getElementById('imageUploadInput').value='';document.getElementById('imageUrlInput').value='';document.getElementById('uploadStatus').classList.add('hidden');setTimeout(()=>{m.classList.remove('opacity-0');c.classList.remove('scale-95');},10);}
     function closeMediaModal(){const m=document.getElementById('mediaModal'),c=document.getElementById('mediaModalContent');m.classList.add('opacity-0');c.classList.add('scale-95');setTimeout(()=>{m.classList.add('hidden');},300);}
     function switchMediaTab(t){if(t==='upload'){document.getElementById('tab_upload').classList.remove('hidden');document.getElementById('tab_link').classList.add('hidden');document.getElementById('tab_btn_upload').className="flex-1 py-2 font-bold text-sm text-primary border-b-2 border-primary";document.getElementById('tab_btn_link').className="flex-1 py-2 font-bold text-sm text-slate-400 border-b-2 border-transparent";}else{document.getElementById('tab_link').classList.remove('hidden');document.getElementById('tab_upload').classList.add('hidden');document.getElementById('tab_btn_link').className="flex-1 py-2 font-bold text-sm text-primary border-b-2 border-primary";document.getElementById('tab_btn_upload').className="flex-1 py-2 font-bold text-sm text-slate-400 border-b-2 border-transparent";}}
     function insertHTMLToTarget(h,t){const i=document.getElementById(t);if(i){if(i.value.length>0&&!i.value.endsWith('\n')){i.value+='\n';}i.value+=h;i.classList.add('ring-2','ring-emerald-500','bg-emerald-50');setTimeout(()=>{i.classList.remove('ring-2','ring-emerald-500','bg-emerald-50');},1000);}}
     function insertLinkMedia(){const u=document.getElementById('imageUrlInput').value.trim();if(!u)return;insertHTMLToTarget(`<br><img src="${u}" />`,document.getElementById('targetInputIdMedia').value);closeMediaModal();}
     function handleFileUpload(i){if(!i.files||i.files.length===0)return;const f=i.files[0],s=document.getElementById('uploadStatus');if(f.size>5*1024*1024){alert("Max 5MB!");return;}s.classList.remove('hidden','text-rose-500','text-emerald-500');s.classList.add('text-primary');s.innerHTML='Đang tải...';const d=new FormData();d.append('file',f);fetch('index.php?action=ajax_upload_image',{method:'POST',body:d}).then(r=>r.json()).then(data=>{if(data.error){s.classList.replace('text-primary','text-rose-500');s.innerText=data.error;}else if(data.url){s.classList.replace('text-primary','text-emerald-500');s.innerText="Thành công!";setTimeout(()=>{insertHTMLToTarget(`<br><img src="${data.url}" />`,document.getElementById('targetInputIdMedia').value);closeMediaModal();},500);}}).catch(e=>{s.innerText="Lỗi!";});}
     function openTableModal(t){document.getElementById('targetInputIdTable').value=t;document.getElementById('col1_header').value='Thông số';document.getElementById('col2_header').value='Giá trị';const c=document.getElementById('tableRowsContainer');c.innerHTML='';addTableRow();addTableRow();const m=document.getElementById('tableModal'),mc=document.getElementById('tableModalContent');m.classList.remove('hidden');setTimeout(()=>{m.classList.remove('opacity-0');mc.classList.remove('scale-95');},10);}
     function closeTableModal(){const m=document.getElementById('tableModal'),c=document.getElementById('tableModalContent');m.classList.add('opacity-0');c.classList.add('scale-95');setTimeout(()=>{m.classList.add('hidden');},300);}
     function addTableRow(){const c=document.getElementById('tableRowsContainer'),h=`<div class="bg-white border rounded-lg p-2 table-row-item shadow-sm flex flex-col gap-2 relative pr-10"><input type="text" class="w-full border-b p-1 outline-none text-sm font-bold" placeholder="Nội dung Cột 1..."><textarea class="w-full h-12 p-1 outline-none text-sm resize-none" placeholder="Nội dung Cột 2..."></textarea><button type="button" onclick="this.closest('.table-row-item').remove()" class="absolute top-1/2 right-2 -translate-y-1/2 text-rose-300 hover:text-rose-500 p-2"><i class="fa-solid fa-trash"></i></button></div>`;c.insertAdjacentHTML('beforeend',h);}
     function insertTable(){const r=document.querySelectorAll('.table-row-item');if(r.length===0)return;const col1=document.getElementById('col1_header').value.trim()||'Cột 1';const col2=document.getElementById('col2_header').value.trim()||'Cột 2';let h=`\n<table class="w-full border-collapse border border-slate-300 mt-2 mb-2">\n  <thead>\n    <tr class="bg-slate-100">\n      <th class="border border-slate-300 px-3 py-2 w-1/3">${col1}</th>\n      <th class="border border-slate-300 px-3 py-2">${col2}</th>\n    </tr>\n  </thead>\n  <tbody>\n`;r.forEach(ro=>{const t=ro.querySelector('input').value.trim(),e=ro.querySelector('textarea').value.trim().replace(/\n/g,'<br>');if(t||e){h+=`    <tr>\n      <td class="border border-slate-300 px-3 py-2 font-semibold">${t}</td>\n      <td class="border border-slate-300 px-3 py-2">${e}</td>\n    </tr>\n`;}});h+=`  </tbody>\n</table>\n`;insertHTMLToTarget(h,document.getElementById('targetInputIdTable').value);closeTableModal();}

     document.addEventListener('paste', function(e) {
         if (e.target.tagName.toLowerCase() !== 'textarea') return;
         let cData = e.clipboardData || window.clipboardData;
         if (!cData) return;
         for (let i = 0; i < cData.items.length; i++) {
             if (cData.items[i].type.indexOf('image') !== -1) {
                 let rawFile = cData.items[i].getAsFile();
                 if (rawFile) {
                     e.preventDefault();
                     let ext = rawFile.type.split('/')[1] || 'png';
                     let file = new File([rawFile], "pasted_image." + ext, { type: rawFile.type });
                     
                     let t = e.target;
                     if (file.size > 5242880) { alert("Max 5MB!"); return; }
                     let fd = new FormData();
                     fd.append('file', file);
                     let uid = Math.floor(Math.random() * 10000);
                     let p = `\n[Đang tải ảnh lên hệ thống... ${uid}]\n`;
                     let s = t.selectionStart;
                     let text = t.value;
                     t.value = text.substring(0, s) + p + text.substring(t.selectionEnd);
                     t.selectionStart = t.selectionEnd = s + p.length;
                     t.focus();
                     t.classList.add('bg-sky-50');
                     fetch('index.php?action=ajax_upload_image', { method: 'POST', body: fd })
                     .then(r => r.json())
                     .then(d => {
                         t.classList.remove('bg-sky-50');
                         if (d.error) {
                             t.value = t.value.replace(p, "");
                             alert(d.error);
                         } else if (d.url) {
                             t.value = t.value.replace(p, '\n<img src="'+d.url+'" />\n');
                             t.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50');
                             setTimeout(() => { t.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50'); }, 1000);
                         }
                     })
                     .catch(() => {
                         t.classList.remove('bg-sky-50');
                         t.value = t.value.replace(p, "");
                         alert("Lỗi kết nối mạng, không thể tải ảnh lên máy chủ.");
                     });
                     break;
                 }
             }
         }
     });
 </script>
<?php 
endif; 
?>
</main>

<footer class="bg-slate-900 text-white py-8 mt-auto border-t-4 border-primary w-full relative z-10">
 <div class="max-w-7xl mx-auto px-4 flex flex-col items-center justify-center text-center">
     <div class="text-slate-400 mb-2 font-medium text-sm">Copyright 2026 - Được phát triển bởi</div>
     <a href="https://www.tiktok.com/@binhsubvip" target="_blank" rel="noopener noreferrer" 
        class="inline-flex items-center gap-2 bg-slate-800 border border-slate-700 px-5 py-2 rounded-xl text-white font-bold group hover:bg-slate-700 hover:border-sky-500/50 transition-all duration-300">
         <i class="fa-brands fa-tiktok text-sky-500 text-lg"></i> BINHSUBVIP
     </a>
 </div>
</footer>

<script>
 if ('serviceWorker' in navigator) {
   window.addEventListener('load', () => {
     navigator.serviceWorker.register('./sw.js').catch(()=>{});
   });
 }
 document.addEventListener('DOMContentLoaded',function(){
     const m=document.createElement('div');
     m.id='zModal';
     m.className='fixed inset-0 z-[99999] bg-black/90 flex items-center justify-center p-2 sm:p-4 cursor-zoom-out opacity-0 pointer-events-none transition-opacity duration-300';
     m.innerHTML='<img id="zImg" src="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl transform scale-95 transition-transform duration-300"/>';
     document.body.appendChild(m);
     const zm=document.getElementById('zModal');
     const zi=document.getElementById('zImg');
     document.body.addEventListener('click',function(e){
         if(e.target.tagName==='IMG'&&!e.target.closest('#zModal')&&!e.target.closest('nav')&&!e.target.closest('button')){
             e.preventDefault();
             e.stopPropagation();
             zi.src=e.target.src;
             zm.classList.remove('pointer-events-none','opacity-0');
             zi.classList.remove('scale-95');
             zi.classList.add('scale-100');
         }
     });
     zm.addEventListener('click',function(){
         zm.classList.add('opacity-0','pointer-events-none');
         zi.classList.remove('scale-100');
         zi.classList.add('scale-95');
         setTimeout(()=>{zi.src='';},300);
     });
 });
</script>

<?php if (!is_admin()): ?>
<script>
 document.addEventListener('contextmenu', event => event.preventDefault());
 document.addEventListener('keydown', function(e) {
     if (e.keyCode === 123 || 
        (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) || 
        (e.ctrlKey && (e.keyCode === 85 || e.keyCode === 83 || e.keyCode === 80))) {
         e.preventDefault();
         return false;
     }
 });
</script>
<?php endif; ?>

</body>
</html>