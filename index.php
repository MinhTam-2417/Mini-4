<?php
// Redirect all requests to public/
$request_uri = $_SERVER['REQUEST_URI'];
$redirect_url = '/Mini-4/public' . $request_uri;

// Remove double slashes
$redirect_url = str_replace('//', '/', $redirect_url);

header('Location: ' . $redirect_url);
exit;
?> 