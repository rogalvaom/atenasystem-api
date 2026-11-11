<?php
class Request
{
    protected $data;
    protected $token;

    public function __construct($data = [], $token = null)
    {
        $this->data = $data;
        $this->token = $token;
    }

    public function validate(array $rules)
    {
        foreach ($rules as $field => $ruleString) {
            $value = $this->input($field);
            $rulesArray = explode('|', $ruleString);

            foreach ($rulesArray as $rule) {
                if ($rule === 'required' && (empty($value) && $value !== '0' && $value !== 0)) {
                    $this->fail("O campo {$field} é obrigatório.");
                }

                if ($rule === 'string' && !empty($value) && !is_string($value)) {
                    $this->fail("O campo {$field} deve ser uma string.");
                }

                if ($rule === 'numeric' && !empty($value) && !is_numeric($value)) {
                    $this->fail("O campo {$field} deve ser numérico.");
                }

                if (strpos($rule, 'min:') === 0 && !empty($value)) {
                    $min = (int) str_replace('min:', '', $rule);
                    if (is_string($value) && mb_strlen($value) < $min) {
                        $this->fail("O campo {$field} deve ter no mínimo {$min} caracteres.");
                    } elseif (is_numeric($value) && $value < $min) {
                        $this->fail("O campo {$field} deve ser no mínimo {$min}.");
                    }
                }

                if (strpos($rule, 'max:') === 0 && !empty($value)) {
                    $max = (int) str_replace('max:', '', $rule);
                    if (is_string($value) && mb_strlen($value) > $max) {
                        $this->fail("O campo {$field} deve ter no máximo {$max} caracteres.");
                    } elseif (is_numeric($value) && $value > $max) {
                        $this->fail("O campo {$field} deve ser no máximo {$max}.");
                    }
                }
            }
        }
        return true;
    }

    private function fail($message)
    {
        http_response_code(422);
        echo json_encode([
            "access" => false,
            "message" => $message
        ]);
        exit;
    }

    public function input($key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }
}
