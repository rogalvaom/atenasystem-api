<?php
class Router {
    private $url;
    private $method;
    private $data;
    private $token;

    function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->url = $_SERVER["REQUEST_URI"];
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->data = $this->getData();
        $this->token = $this->getToken();
    }

    function checkApi(){
        $uri = $this->url;
        if (strpos($uri, '/api/') === false) {
            return false;
        }
        return true;
    }


    function getHeaders(){
        $headers = [];

        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        } else if (apache_request_headers()) {
            $headers = apache_request_headers();
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = $_SERVER['HTTP_AUTHORIZATION'];
        }

        return $headers;
    }
    function getToken(){
        $headers = $this->getHeaders();
        $autorization = $headers['Authorization'] ?? '';
        $token = str_replace('Bearer ', '', $autorization);

        return $token;
    }

    function getData(){
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        $input = [];
        if (strpos($contentType, 'multipart/form-data') !== false) {
            $input = $_POST;
            if (!empty($_FILES)) {
                $input['_files'] = $_FILES;
            }
        } else {
            $contents = file_get_contents('php://input');
            if (isset($contents)){
                $input = (array) json_decode($contents);
            }
        }
        return $input;
    }

    function pathApi(){
        $url = $this->url;
        $pos = strpos($url, '/api');
        if ($pos !== false) {
            $apiPart = substr($url, $pos + 4);
        } else {
            $apiPart = $url;
        }
        $apiPart = explode('?', $apiPart);
        $endpoint = $apiPart[0];
        $queryString = isset($apiPart[1]) ? $apiPart[1] : "";

        if ($queryString != "") {
            $paramsArray = explode('&', $queryString);
            $params = [];
            foreach ($paramsArray as $param) {
                $param = explode('=', $param);
                if (isset($param[0]) && isset($param[1])) {
                    $params[$param[0]] = $param[1];
                }
            }
            $this->data = array_merge($this->data, $params);
        }

        $endpoint = rtrim($endpoint, '/');
        return $endpoint === '' ? '/' : $endpoint;
    }

    function runApi($routes){
        if ($this->method == 'OPTIONS') {
            http_response_code(200);
            return;
        }
        $path = $this->pathApi();

        foreach($routes as $route){
            $RouteMethod = $route[0];
            $RoutePath = $route[1];
            $RouteClass = $route[2];
            $RouteFunction = $route[3];
            $RouteMiddlewares = isset($route[4]) ? $route[4] : [];

            if ($RouteMethod == $this->method && $RoutePath == $path){
                foreach ($RouteMiddlewares as $middlewareClass) {
                    if (class_exists($middlewareClass)) {
                        $middlewareInstance = new $middlewareClass();
                        if (method_exists($middlewareInstance, 'handle')) {
                            $middlewareInstance->handle($this->data, $this->token);
                        }
                    }
                }

                $Class = new $RouteClass();
                if (method_exists($Class, $RouteFunction)){
                    http_response_code(200);
                    $response = $Class->$RouteFunction($this->data, $this->token);
                    if (is_array($response) || is_object($response)) {
                        echo json_encode($response);
                    } else {
                        echo $response;
                    }
                    return;
                } else {
                    http_response_code(405);
                    return;
                }
            }
        }
        http_response_code(405);
    }
}
?>