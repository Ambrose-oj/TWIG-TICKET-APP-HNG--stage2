<?php
require_once __DIR__ . '/vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

// Twig setup
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader, ['cache' => false]);

// Parse URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Debug (remove later)
echo "<pre>URI: '$uri'</pre>";

// Dummy data
$dashboard_data = [
    'stats' => ['open' => 12, 'in_progress' => 5, 'resolved' => 58]
];

// Routing
if ($uri === '/' || $uri === '') {
    echo $twig->render('landing_page.twig');
    exit;
}
if ($uri === '/login') {
    echo $twig->render('login.twig', ['error_message' => null]);
    exit;
}
if ($uri === '/signup') {
    echo $twig->render('signup.twig', ['error_message' => null]);
    exit;
}
if ($uri === '/dashboard') {
    echo $twig->render('dashboard.twig', $dashboard_data);
    exit;
}
if ($uri === '/tickets') {
    echo $twig->render('ticket_manager.twig');
    exit;
}

// Serve static files from /public
if (preg_match('#^/public/(.*)$#', $uri, $matches)) {
    $file = __DIR__ . '/public/' . $matches[1];
    if (file_exists($file) && !is_dir($file)) {
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $types = [
            'css' => 'text/css',
            'js'  => 'application/javascript',
            'svg' => 'image/svg+xml',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
        ];
        if (isset($types[$ext])) {
            header('Content-Type: ' . $types[$ext]);
            readfile($file);
            exit;
        }
    }
}

// 404
http_response_code(404);
echo "<h1>404 Not Found</h1><p>URI: " . htmlspecialchars($uri) . "</p>";