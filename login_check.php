<?php
$_UNCHECK = ['main.php', 'signup.php'];
$current_page_name = end(explode('/', $_SERVER['PHP_SELF']));

if (!in_array($current_page_name, $_UNCHECK) && !isset($_SESSION['seq'])) {
    echo "<script>alert('Please login and try again.');location.replace('/{$_SERVER['ACCESS_SERVER_NAME']}/main.php');</script>";
}
?>