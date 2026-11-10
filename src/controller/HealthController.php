<?php
    class HealthController extends Controller {
        public function health() {
            return ["access" => true, "message" => "Api rodando!"];
        }
    }