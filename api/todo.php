<?php
try {
    require_once("todo.controller.php");

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = explode('/', $uri);
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $pathCount = count($path);

    $controller = new TodoController();

    switch ($requestMethod) {
        case 'GET':
            if ($path[$pathCount - 2] == 'todo' && isset($path[$pathCount - 1]) && strlen($path[$pathCount - 1])) {
                $id = $path[$pathCount - 1];
                $todo = $controller->load($id);
                if ($todo) {
                    http_response_code(200);
                    echo json_encode($todo);
                    die();
                }
                http_response_code(404);
                die();
            } else {
                http_response_code(200);
                echo json_encode($controller->loadAll());
                die();
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"));
            $result = $controller->create($data);
            if ($result) {
                http_response_code(201);
                echo json_encode(array("message" => "Todo created successfully."));
                die();
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Failed to create todo."));
                die();
            }
            break;
        case 'PUT':
            $data = json_decode(file_get_contents("php://input"));
            $result = $controller->update($data);
            if ($result) {
                http_response_code(200);
                echo json_encode(array("message" => "Todo updated successfully."));
                die();
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Failed to update todo."));
                die();
            }
            break;
        case 'DELETE':
            $data = json_decode(file_get_contents("php://input"));
            $result = $controller->delete($data);
            if ($result) {
                http_response_code(200);
                echo json_encode(array("message" => "Todo deleted successfully."));
                die();
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Failed to delete todo."));
                die();
            }
            break;
        default:
            http_response_code(501);
            die();
            break;
    }
} catch (Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die();
}
