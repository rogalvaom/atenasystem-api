<?php
class AuthMiddleware extends Middleware
{
    public function handle($data, $token)
    {
        if (empty($token) || $token !== md5(session_id())) {
            http_response_code(401);
            echo json_encode([
                "access" => false,
                "message" => "Não autorizado. Faça login novamente."
            ]);
            exit;
        }

        return true;
    }
}
