<?php
// This is a minimal PHP file to demonstrate rendering the Twig templates.
// It is NOT a complete backend solution (it lacks routing, auth, and data persistence).

require_once 'vendor/autoload.php';

// 1. Setup Twig Loader
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

// 2. Define Dummy Data for Dashboard (required for dashboard.twig)
$dashboard_data = [
    'stats' => [
        'open' => 12,
        'in_progress' => 5,
        'resolved' => 58
    ],
    // The recent_tickets array is already hardcoded in dashboard.twig for simplicity
];

// 3. Simple Routing Logic
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/') {
    echo $twig->render('landing_page.twig');
} elseif ($uri === '/login') {
    // You would handle the login form submission here
    echo $twig->render('login.twig', ['error_message' => null]);
} elseif ($uri === '/signup') {
    // You would handle the signup form submission here
    echo $twig->render('signup.twig', ['error_message' => null]);
} elseif ($uri === '/dashboard') {
    // In a real app, you'd check auth here. If failed, redirect to /login.
    echo $twig->render('dashboard.twig', $dashboard_data);
} elseif ($uri === '/tickets') {
    // In a real app, you'd check auth, and pass the list of all tickets here.
    echo $twig->render('ticket_manager.twig');
} else {
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
}

?>
