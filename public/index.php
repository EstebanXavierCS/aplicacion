<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/controllers/AuthController.php';
require_once __DIR__ . '/../src/controllers/ProductController.php';  // Add this line

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Remove the query string from the request
$request = strtok($request, '?');

// Handle POST requests for authentication
if ($method === 'POST') {
    switch ($request) {
        case '/auth/register':
            $auth = new AuthController();
            if ($auth->register($_POST['username'], $_POST['password'], $_POST['email'])) {
                header('Location: /login');
            } else {
                header('Location: /register?error=1');
            }
            exit;
            
        case '/auth/login':
            $auth = new AuthController();
            if ($auth->login($_POST['username'], $_POST['password'])) {
                header('Location: /');
            } else {
                header('Location: /login?error=1');
            }
            exit;

        case '/products/add':
            if(isset($_SESSION['username'])) {
                $productController = new ProductController();
                $productController->addProduct(
                    $_POST['name'],
                    $_POST['description'],
                    $_POST['price'],
                    $_POST['image_url']
                );
            }
            header('Location: /products');
            exit;
    }
}

// Handle GET requests
switch ($request) {
    case '/':
    case '/home':
        require __DIR__ . '/../src/views/home.php';
        break;
    case '/about':  // Add this new route
        require __DIR__ . '/../src/views/about.php';
        break;
    case '/login':
        require __DIR__ . '/../src/views/login.php';
        break;
    case '/register':
        require __DIR__ . '/../src/views/register.php';
        break;
    case '/products':
        require __DIR__ . '/../src/views/products.php';
        break;
    case '/logout':
        $auth = new AuthController();
        $auth->logout();
        header('Location: /login');
        exit;
    default:
        http_response_code(404);
        require __DIR__ . '/../src/views/404.php';
        break;
}
?>