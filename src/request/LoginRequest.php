<?php
class LoginRequest extends Request
{
    public function validateLogin()
    {
        return $this->validate([
            'usuario' => 'required|string',
            'senha' => 'required|string',
        ]);
    }
}
