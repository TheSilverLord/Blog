<?php

try
{
    spl_autoload_register(function(string $className){ require_once __DIR__ . '/' . str_replace('\\','/', $className) . '.php'; });

    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/Blog/routes.php';
    
    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction)
    {
        preg_match($pattern, $route, $matches);
        if (!empty($matches))
        {
            $isRouteFound = true;
            break;
        }
    }
    if(!$isRouteFound)
    {
        throw new \Blog\Exceptions\NotFoundException();
    }
    
    unset($matches[0]);
    
    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];
    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch(\Blog\Exceptions\NotFoundException $e)
{
    $view = new \Blog\View\View(__DIR__ . '/templates/errors');
    $view->renderHTML('404.php', ['error' => $e->getMessage()], 404);
}
catch (\Blog\Exceptions\UnauthorizedException $e)
{
    $view = new \Blog\View\View(__DIR__ . '/templates/errors');
    $view->renderHTML('401.php', ['error' => $e->getMessage()], 401);
}
catch (\Blog\Exceptions\ForbiddenException $e)
{
    $view = new \Blog\View\View(__DIR__ . '/templates/errors');
    $view->renderHTML('403.php', ['error' => $e->getMessage()], 403);
}
?>