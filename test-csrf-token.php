<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

echo "Application loaded successfully\n";

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Get the CSRF token
echo "CSRF Token Test\n";
echo "=============\n\n";

// Check if the CSRF token is being generated
echo "Generating CSRF token...\n";
$token = $app->make('session')->token();
echo "Token: " . $token . "\n\n";

// Check CSRF middleware configuration
echo "CSRF Middleware Configuration:\n";
$router = $app->make('router');
$middleware = $router->getMiddleware();
if (isset($middleware['web'])) {
    echo "Web middleware group is configured.\n";
} else {
    echo "Web middleware group is NOT configured.\n";
}

// Check if the ValidateCsrfToken middleware is in the web middleware group
echo "\nChecking for ValidateCsrfToken in middleware groups...\n";
$middlewareGroups = $router->getMiddlewareGroups();
if (isset($middlewareGroups['web'])) {
    $webMiddleware = $middlewareGroups['web'];
    $csrfMiddleware = 'Illuminate\\Foundation\\Http\\Middleware\\ValidateCsrfToken';
    $found = false;
    foreach ($webMiddleware as $mw) {
        if (is_string($mw) && ($mw === $csrfMiddleware || $mw === 'App\\Http\\Middleware\\VerifyCsrfToken')) {
            $found = true;
            echo "Found CSRF middleware: $mw\n";
            break;
        }
    }
    if (!$found) {
        echo "CSRF middleware not found in web middleware group.\n";
    }
} else {
    echo "Web middleware group not found.\n";
}

// Check the route for dog-tinder swipe
echo "\nChecking route for dog-tinder swipe...\n";
$routes = $router->getRoutes();
foreach ($routes as $route) {
    if ($route->getName() === 'user.dog-tinder.swipe') {
        echo "Found route: " . $route->uri() . "\n";
        echo "Method: " . implode('|', $route->methods()) . "\n";
        echo "Middleware: " . implode(', ', $route->middleware()) . "\n";
        break;
    }
}

// Create a test request to see if CSRF validation works
echo "\nTesting CSRF validation...\n";
try {
    $testRequest = Illuminate\Http\Request::create('/user/dog-tinder/swipe', 'POST', [
        'dog_id' => 1,
        'action' => 'like'
    ]);
    
    // Set the session on the request
    $testRequest->setLaravelSession($app->make('session')->driver());
    
    // Try to handle the request without a CSRF token
    $testResponse = $kernel->handle($testRequest);
    
    echo "Response status: " . $testResponse->getStatusCode() . "\n";
    echo "Response content: " . $testResponse->getContent() . "\n";
    
    if ($testResponse->getStatusCode() === 419) {
        echo "CSRF validation is working (got 419 status code).\n";
    } else {
        echo "CSRF validation might not be working (expected 419, got " . $testResponse->getStatusCode() . ").\n";
    }
} catch (Exception $e) {
    echo "Error testing CSRF validation: " . $e->getMessage() . "\n";
}

// Now try with a valid CSRF token
echo "\nTesting with valid CSRF token...\n";
try {
    $testRequest = Illuminate\Http\Request::create('/user/dog-tinder/swipe', 'POST', [
        'dog_id' => 1,
        'action' => 'like',
        '_token' => $token
    ]);
    
    // Set the session on the request
    $testRequest->setLaravelSession($app->make('session')->driver());
    
    // Try to handle the request with a CSRF token
    $testResponse = $kernel->handle($testRequest);
    
    echo "Response status: " . $testResponse->getStatusCode() . "\n";
    echo "Response content: " . $testResponse->getContent() . "\n";
} catch (Exception $e) {
    echo "Error testing with valid CSRF token: " . $e->getMessage() . "\n";
}

$kernel->terminate($request, $response);