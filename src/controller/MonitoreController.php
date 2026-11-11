<?php
    class MonitoreController{
        function getMonitores(){
            $monitores = new MonitoreModel();
            return $monitores->getMonitores();
        }

        function getMonitore($data){
            $id = is_array($data) ? (isset($data['id']) ? $data['id'] : (isset($data['monitore']) ? $data['monitore'] : null)) : $data;
            if (!$id && isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            $monitore = new MonitoreModel();
            return $monitore->getMonitore($id);
        }

        function buscarMonitore($post){
            $id = isset($post['monitore']) ? $post['monitore'] : (isset($post['id']) ? $post['id'] : null);
            return $this->getMonitore($id);
        }

        function criarMonitore($post){
            $monitore = new MonitoreModel();
            $monitore->nome = $post['nome'] ?? '';
            $monitore->usuario = $post['usuario'] ?? '';
            $monitore->senha = $post['senha'] ?? '';
            $id = $monitore->criarMonitore();
            return ["access" => true, "message" => "Salvo com sucesso!", "id" => $id];
        }

        function salvarMonitore($post){
            $monitore = new MonitoreModel();
            $monitore->nome = $post['nome'] ?? '';
            $monitore->usuario = $post['usuario'] ?? '';
            $monitore->senha = $post['senha'] ?? '';
            $monitore->salvarMonitore($post['id'] ?? null);
            return ["access" => true, "message" => "Atualizado com sucesso!"];
        }

        function excluirMonitore($post){
            $monitore = new MonitoreModel();
            $monitore->id = $post['id'] ?? null;
            $monitore->excluir();
            return ["access" => true, "message" => "Excluído com sucesso!"];
        }
    }
?>