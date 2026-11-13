<?php
    class Router{

        private $url;
        private $method;
        private $data;
        private $token;
        private $baseUrl;

        function __construct() {
            $this->url = $_SERVER["REQUEST_URI"];
            $this->method = $_SERVER["REQUEST_METHOD"];
            $this->data = $this->getData();
            $this->token = $this->getToken();
            $this->baseUrl = $_ENV['BASE_URL'];
        }

        function checkApi(){
            $uri = $this->url;
            if (strpos($uri, '/api/') === false) {
                return false;
            }
            return true;
        }

        function getToken(){
            $header = getallheaders();
            $token = isset($header['token']) ? $header['token'] : null;
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
            } elseif (strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
                $contents = file_get_contents('php://input');
                parse_str($contents, $input);
            } else {
                $contents = file_get_contents('php://input');
                if (!empty($contents)) {
                    $decoded = json_decode($contents, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $input = $decoded;
                    } else {
                        parse_str($contents, $input);
                    }
                }
            }
            return $input;
        }

        function pathApi(){
            $url = $this->url;

            $apiPart = substr($url, strpos($url, '/api/') + 5);
            $apiPart = explode('?', $apiPart);
            $endpoint = $apiPart[0];
            $queryString = isset($apiPart[1]) ? $apiPart[1] : "";

            if ($queryString != "") {
                $paramsArray = explode('&', $queryString);
                $params = [];
                foreach ($paramsArray as $param) {
                    $param = explode('=', $param);
                    $name = $param[0];
                    $value = $param[1];
                    $params[$name] = $value;
                }
                $this->data = array_merge($this->data, $params);
            }

            return '/'.$endpoint;
        }

        function runApi($routes){
            $path = $this->pathApi();

            foreach($routes as $route){
                $RouteMethod = $route[0];
                $RoutePath = $route[1];
                $RouteClass = $route[2];
                $RouteFunction = $route[3];
                if ($RouteMethod == $this->method && $RoutePath == $path){
                    $Class = new $RouteClass();
                    if (method_exists($Class, $RouteFunction)){
                        http_response_code(200);
                        $response = $Class->$RouteFunction($this->data, $this->token);
                        if (is_array($response) || is_object($response)) {
                            echo json_encode($response);
                        } else {
                            echo $response;
                        }
                        break;
                    } else {
                        http_response_code(405);
                        break;
                    }
                } else {
                    http_response_code(405);
                }
            }
        }

        function pathWeb($url, $routes){
            $url = explode('?',$url);
            unset($url[1]);
            $url = implode('',$url);

            $file = $_SERVER['PROJECT_ROOT'] . '/' . $url;

            if(is_file($file)){
                return $file;
            }

            $url = '/'.$url;

            foreach($routes as $route){
                $RoutePath = $route[0];
                $RouteWeb = $_SERVER['PROJECT_ROOT'] . '/public/view' . $route[1];

                if ($url == $RoutePath) {
                    if(is_file($RouteWeb)){
                        return $RouteWeb;
                    }
                }
            }

            return $_SERVER['PROJECT_ROOT'] . '/public/view/404.html';
        }

        function runWeb($routes){
            $uri = $this->url;
            $parametros = explode('/',$uri);
            unset($parametros[0]);
            $parametros = array_values($parametros);
            $url = implode('/',$parametros);

            $path = $this->pathWeb($url, $routes);

            if(isset($path)){
                $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $mimeTypes = [
                    'png'   => 'image/png',
                    'jpg'   => 'image/jpeg',
                    'jpeg'  => 'image/jpeg',
                    'gif'   => 'image/gif',
                    'svg'   => 'image/svg+xml',
                    'ico'   => 'image/x-icon',
                    'webp'  => 'image/webp',
                    'css'   => 'text/css',
                    'js'    => 'text/javascript',
                    'pdf'   => 'application/pdf',
                    'woff'  => 'font/woff',
                    'woff2' => 'font/woff2',
                    'ttf'   => 'font/ttf',
                    'otf'   => 'font/otf',
                    'eot'   => 'application/vnd.ms-fontobject',
                ];

                if (isset($mimeTypes[$extension])){
                    $c = file_get_contents($path);
                    $size = filesize($path);
                    header('Content-Type: ' . $mimeTypes[$extension]);
                    header("Content-length: $size");
                    if ($extension === 'pdf') {
                        header('Content-Disposition: inline; filename="' . basename($path) . '"');
                    }
                    echo $c;
                }else{
                    if(is_file($path)){
                        echo "<script>var basePath = '" . $this->baseUrl . "'</script>";
                        echo "<script src='" . $this->baseUrl . "/public/js/jquery-1.11.1.min.js'></script>";
                        echo "<script src='" . $this->baseUrl . "/public/js/api.js'></script>";
                        include_once $path;
                    }
                }
            }
        }
    }
?>