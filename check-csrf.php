<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Check if CSRF protection is enabled
    $middleware = $app->make('Illuminate\Foundation\Http\Kernel')->getMiddlewareGroups()['web'];
    $hasVerifyCsrfToken = false;
    
    echo "Checking middleware configuration...\n";
    echo "Web middleware group:\n";
    
    foreach ($middleware as $m) {
        echo "- {$m}\n";
        if (strpos($m, 'VerifyCsrfToken') !== false) {
            $hasVerifyCsrfToken = true;
        }
    }
    
    echo "\nCSRF protection is " . ($hasVerifyCsrfToken ? 'enabled' : 'disabled') . "\n";
    
    // Check CSRF token generation
    echo "\nGenerating a CSRF token...\n";
    $token = $app->make('session')->token();
    echo "Token: {$token}\n";
    
    // Check VerifyCsrfToken middleware exceptions
    try {
        $verifyCsrfToken = $app->make('Illuminate\Foundation\Http\Middleware\ValidateCsrfToken');
        $reflection = new ReflectionClass($verifyCsrfToken);
        $exceptProperty = $reflection->getProperty('except');
        $exceptProperty->setAccessible(true);
        $except = $exceptProperty->getValue($verifyCsrfToken);
    } catch (Exception $e) {
        echo "Error getting CSRF exceptions: {$e->getMessage()}\n";
        $except = [];
    }
    
    echo "\nCSRF token verification exceptions:\n";
    if (empty($except)) {
        echo "No exceptions (all routes are protected)\n";
    } else {
        foreach ($except as $route) {
            echo "- {$route}\n";
        }
    }
    
    // Check if the dog-tinder.swipe route is properly configured
    echo "\nChecking route configuration...\n";
    $router = $app->make('router');
    $routes = $router->getRoutes();
    
    $dogTinderSwipeRoute = null;
    foreach ($routes as $route) {
        if ($route->getName() === 'user.dog-tinder.swipe') {
            $dogTinderSwipeRoute = $route;
            break;
        }
    }
    
    if ($dogTinderSwipeRoute) {
        echo "Found user.dog-tinder.swipe route:\n";
        echo "- URI: {$dogTinderSwipeRoute->uri()}\n";
        echo "- Method: " . implode('|', $dogTinderSwipeRoute->methods()) . "\n";
        echo "- Action: {$dogTinderSwipeRoute->getActionName()}\n";
        echo "- Middleware: " . implode(', ', $dogTinderSwipeRoute->gatherMiddleware()) . "\n";
    } else {
        echo "Could not find user.dog-tinder.swipe route\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}