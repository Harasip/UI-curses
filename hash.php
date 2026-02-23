<?php
$new_password = 'admin123';  // ← измени здесь
echo password_hash($new_password, PASSWORD_DEFAULT);
?>