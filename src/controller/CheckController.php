<?php
    class CheckController extends Controller {
        public function health() {
            return ["access" => true, "message" => "Api rodando!"];
        }
    }