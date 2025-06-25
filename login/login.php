<?php
session_start();
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Admin Giriş</title>
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>
  <div class="container">
    <h2>Admin Giriş</h2>
    <form method="post" action="check-login.php">
      <input type="text" name="username" placeholder="Kullanıcı Adı" required>
      <input type="password" name="password" placeholder="Şifre" required>
      <input type="submit" value="Giriş Yap">
    </form>

    <?php if ($error): ?>
      <p class="error-msg"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
  </div>
</body>
</html>
