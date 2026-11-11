<?php
    class ComissaoController{
        function getComissoes(){
            $comissoes = new ComissaoModel();
            return $comissoes->getComissoes();
        }

        function getComissao($data){
            $id = is_array($data) ? (isset($data['id']) ? $data['id'] : (isset($data['comissao']) ? $data['comissao'] : null)) : $data;
            if (!$id && isset($_GET['id'])) {
                $id = $_GET['id'];
            }
            $comissao = new ComissaoModel();
            return $comissao->getComissao($id);
        }

        function buscarComissao($post){
            $id = isset($post['comissao']) ? $post['comissao'] : (isset($post['id']) ? $post['id'] : null);
            return $this->getComissao($id);
        }

        function criarComissao($post){
            $comissao = new ComissaoModel();
            $comissao->nome = $post['nome'] ?? '';
            $comissao->usuario = $post['usuario'] ?? '';
            $comissao->senha = $post['senha'] ?? '';
            $id = $comissao->criarComissao();
            return ["access" => true, "message" => "Salvo com sucesso!", "id" => $id];
        }

        function salvarComissao($post){
            $comissao = new ComissaoModel();
            $comissao->nome = $post['nome'] ?? '';
            $comissao->usuario = $post['usuario'] ?? '';
            $comissao->senha = $post['senha'] ?? '';
            $comissao->salvarComissao($post['id'] ?? null);
            return ["access" => true, "message" => "Atualizado com sucesso!"];
        }

        function excluirComissao($post){
            $comissao = new ComissaoModel();
            $comissao->id = $post['id'] ?? null;
            $comissao->excluir();
            return ["access" => true, "message" => "Excluído com sucesso!"];
        }
    }
?>