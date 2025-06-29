<?php
require_once '../controllers/JobController.php';
require_once '../controllers/ResumeController.php';
require_once '../controllers/ApplicationController.php';

// Parse the URL path
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// Remove the '/project/public' prefix if present
$basePath = '/project/public';
if (strpos($path, $basePath) === 0) {
    $path = substr($path, strlen($basePath));
}
$segments = explode('/', trim($path, '/'));

$controller = $segments[0] ?? 'job';
$action = $segments[1] ?? 'index';
$param1 = $segments[2] ?? null;
$param2 = $segments[3] ?? null;

switch ($controller) {
    case '':
    case 'job':
        $controller = new JobController();
        if ($action == 'index' || $action == '') $controller->index();
        elseif ($action == 'view' && $param1) $controller->view($param1);
        elseif ($action == 'search') $controller->search();
        elseif ($action == 'save' && $param1 && $param2) $controller->saveJob($param1, $param2);
        else {
            header("HTTP/1.0 404 Not Found");
            echo "Page not found";
        }
        break;
    case 'resume':
        $controller = new ResumeController();
        if ($action == 'upload' && $param1) $controller->upload($param1);
        elseif ($action == 'builder' && $param1) $controller->builder($param1);
        elseif ($action == 'profile' && $param1) $controller->profile($param1);
        else {
            header("HTTP/1.0 404 Not Found");
            echo "Page not found";
        }
        break;
    case 'application':
        $controller = new ApplicationController();
        if ($action == 'status' && $param1) $controller->status($param1);
        elseif ($action == 'employer_log' && $param1) $controller->employerLog($param1);
        elseif ($action == 'reminders' && $param1) $controller->reminders($param1);
        elseif ($action == 'apply' && $param1 && $param2) $controller->apply($param1, $param2);
        else {
            header("HTTP/1.0 404 Not Found");
            echo "Page not found";
        }
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
}
?>