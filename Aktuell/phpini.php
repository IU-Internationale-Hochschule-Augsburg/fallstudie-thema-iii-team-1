<?php

ini_set('session.gc_maxlifetime', 300);

// Start session
session_start();

if (!isset($_SESSION["Angemeldet"])){
    header("Location: LoginScreen.php");
}

elseif (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > ini_get('session.gc_maxlifetime'))) {

  // Invalidate session
  session_unset();
  session_destroy();

  // Clear cookies
  setcookie('PHPSESSID', '', time() - 3600, '/');

  // Redirect to logout page
  header('Location: http://restaurantreservierung.42web.io/Test/Testcode%20HTML/LoginScreen.php?timeout=true');
  exit();
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();