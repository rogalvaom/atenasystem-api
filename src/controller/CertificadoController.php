<?php
class CertificadoController{
    public function certificadoTutore($post){
        if (isset($post['dataInicial'])
            && $post['dataInicial'] != ""
            && isset($post['dataFinal'])
            && $post['dataFinal'] != ""
            && isset($post['tutore'])
            && $post['tutore'] != ""
        ){
            $UtilsController = new UtilsController();
            $data1 = explode('-',$post['dataInicial']);
            $dataInicial = $data1[1];
            $mesInicial = $UtilsController->getMes($dataInicial);

            $data2 = explode('-',$post['dataFinal']);
            $dataFinal = $data2[1];
            $mesFinal = $UtilsController->getMes($dataFinal);
            $anoFinal = $data2[0];

            $SalaController = new SalaController();
            $salas = $SalaController->getSalas();
            $PresencaController = new PresencaController();
            $presencaAulas  = 0;
            foreach($salas as $sala){  
                $aulas = $PresencaController->getPresencaPeriodo(
                    $sala['id'],
                    0,
                    0,
                    $post['tutore'],
                    $post['dataInicial'],
                    $post['dataFinal']
                );
                $presencaAulas  = count($aulas) + $presencaAulas;
            }

            $reuniao = $PresencaController->getPresencaPeriodo(
                0,
                0,
                0,
                $post['tutore'],
                $post['dataInicial'],
                $post['dataFinal']
            );
            $presencaReuniao = count($reuniao);

            return json_encode([
                "access" => true,
                "mesInicial" => $mesInicial,
                "mesFinal" => $mesFinal,
                "anoFinal" => $anoFinal,
                "presencaAulas" => $presencaAulas,
                "presencaReuniao" => $presencaReuniao,
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Por favor, ensira todos os dados"
            ]);
        }
    }

    public function certificadoMonitore($post){
        if (isset($post['dataInicial'])
            && $post['dataInicial'] != ""
            && isset($post['dataFinal'])
            && $post['dataFinal'] != ""
            && isset($post['monitore'])
            && $post['monitore'] != ""
        ){
            $UtilsController = new UtilsController();
            $data1 = explode('-',$post['dataInicial']);
            $dataInicial = $data1[1];
            $mesInicial = $UtilsController->getMes($dataInicial);

            $data2 = explode('-',$post['dataFinal']);
            $dataFinal = $data2[1];
            $mesFinal = $UtilsController->getMes($dataFinal);
            $anoFinal = $data2[0];

            $PresencaController = new PresencaController();
            $monitorias = $PresencaController->getPresencaMonitore(
                $post['monitore'],
                $post['dataInicial'],
                $post['dataFinal']
            );
            
            return json_encode([
                "access" => true,
                "mesInicial" => $mesInicial,
                "mesFinal" => $mesFinal,
                "anoFinal" => $anoFinal,
                "monitoria" => count($monitorias),
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Por favor, ensira todos os dados"
            ]);
        }
    }

    ////////////////////////////////////////////////////
    function certificadoGetTutores(){
        $tutores = new TutoreModel();
        return json_encode($tutores->getTutores());
    }

    function certificadoGetTutore($post){
        $id = $post['id'];
        $tutore = (new TutoreModel())->getTutore($id);
        if($tutore["nome"] != ''){
            return json_encode([
                "access" => true,
                "tutore" => $tutore,
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Usuario não encontrado"
            ]);
        }
    }

    function certificadoGetMonitores(){
        $monitores = new MonitoreModel();
        return json_encode($monitores->getMonitores());
    }

    function certificadoGetMonitore($post){
        $id = $post['id'];
        $monitore = (new MonitoreModel())->getMonitore($id);
        if($monitore["nome"] != ''){
            return json_encode([
                "access" => true,
                "monitore" => $monitore,
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Usuario não encontrado"
            ]);
        }
    }

    function certificadoGetRepresentantes(){
        $representantes = new RepresentanteModel(); 
        return json_encode($representantes->getRepresentantes());
    }

    function certificadoGetRepresentante($post){
        $id = $post['id'];
        $representante = (new RepresentanteModel())->getRepresentante($id);
        if($representante["nome"] != ''){
            return json_encode([
                "access" => true,
                "representante" => $representante,
            ]);
        } else {
            return json_encode([
                "access" => false,
                "message" => "Usuario não encontrado"
            ]);
        }
    }
}
?>