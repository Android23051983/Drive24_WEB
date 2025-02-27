<?php
session_start();
session_destroy();
header('Location: /index.php');
exit(); // Завершаем выполнение скрипта, чтобы избежать вывода лишнего контента
?>