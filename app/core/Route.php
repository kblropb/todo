<?php

namespace app\core;

class Route
{
    static function start()
    {
        $path = parse_url($_SERVER['REQUEST_URI']);
        $routes = explode('/', $path['path']);

        $controllerName = empty($routes[1]) ? 'frontpage' : $routes[1];
        $actionName = empty($routes[2]) ? 'index' : $routes[2];
        parse_str($_SERVER['QUERY_STRING'], $params);

        $needProcess = true;
        foreach (['tests/', 'css/', 'js/', 'fonts/', 'favicon'] as $query) {
            if (strpos($_SERVER['REQUEST_URI'], $query, 0) !== false) {
                $needProcess = false;
            }
        }

        if ($needProcess) {

            $controllerName = ucfirst($controllerName) . 'Controller';
            $actionName = $actionName . 'Action';
            $controllerFullName = 'app\controller\\' . $controllerName;

            if (file_exists($controllerFullName . '.php')) {
                $request = new BaseRequest();
                $controller = new $controllerFullName();
                echo $controller->$actionName($request);
            } else {
                $controller = new BaseController();
                $data = [
                    'title' => 'Page not found',
                    'content' => 'Page not found'
                ];
                $controller->sendErrorAction($data, '404.php');
            }
        }

        return true;
    }
}