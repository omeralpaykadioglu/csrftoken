<?php

// CSRF Token doğrulama sistemi

session_start();

function generateCSRFToken() {
   if (empty($_SESSION['csrf_token'])) {
       $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
   }
}

function addCSRFTokenToForm() {
   generateCSRFToken();
   $token = $_SESSION['csrf_token'];
   echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

function validateCSRFToken($token) {
   if (!empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
       // Token doğrulandı
       return true;
   } else {
       // Token doğrulanamadı
       return false;
   }
}

// İstek doğrulama örneği
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $submittedToken = $_POST['csrf_token'];
   if (!validateCSRFToken($submittedToken)) {
       return false;
   }
}

?>
