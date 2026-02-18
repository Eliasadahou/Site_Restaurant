<?php
session_start();
session_unset(); // Libère toutes les variables de session
session_destroy();
header("Location: login.php");
exit();
?>