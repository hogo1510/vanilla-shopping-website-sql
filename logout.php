<?php
session_start();
//sessie vernietigen
session_unset();
session_destroy();
//naar login
header("Location: login.html");
exit;
?>
