<?php
    $api = [
        // [METODO, ENDPOINT, CONTROLLER, FUNCTION, [MIDDLEWARES (Opcional)]]
        
        // Health
        ['GET', '/', 'CheckController', 'health'],

        // Autenticação
        ['POST', '/login', 'LoginController', 'login'],
        ['POST', '/logout', 'LoginController', 'logout'],
        ['GET', '/session', 'LoginController', 'getSession'],

        // Alune
        ['GET', '/alunes', 'AluneController', 'getAlunes', ['AuthMiddleware']],
        ['GET', '/alune', 'AluneController', 'getAlune', ['AuthMiddleware']],
        ['GET', '/alune/sala', 'AluneController', 'getAlunesSala', ['AuthMiddleware']],
        ['POST', '/alune', 'AluneController', 'criarAlune', ['AuthMiddleware']],
        ['POST', '/alune/buscar', 'AluneController', 'buscarAlune', ['AuthMiddleware']],
        ['POST', '/alune/salvar', 'AluneController', 'salvarAlune', ['AuthMiddleware']],
        ['POST', '/alune/excluir', 'AluneController', 'excluirAlune', ['AuthMiddleware']],

        // Comissao
        ['GET', '/comissoes', 'ComissaoController', 'getComissoes', ['AuthMiddleware']],
        ['GET', '/comissao', 'ComissaoController', 'getComissao', ['AuthMiddleware']],
        ['POST', '/comissao', 'ComissaoController', 'criarComissao', ['AuthMiddleware']],
        ['POST', '/comissao/buscar', 'ComissaoController', 'buscarComissao', ['AuthMiddleware']],
        ['POST', '/comissao/salvar', 'ComissaoController', 'salvarComissao', ['AuthMiddleware']],
        ['POST', '/comissao/excluir', 'ComissaoController', 'excluirComissao', ['AuthMiddleware']],

        // Disciplina
        ['GET', '/disciplinas', 'DisciplinaController', 'getDisciplinas', ['AuthMiddleware']],
        ['GET', '/disciplina', 'DisciplinaController', 'getDisciplina', ['AuthMiddleware']],
        ['POST', '/disciplina', 'DisciplinaController', 'criarDisciplina', ['AuthMiddleware']],
        ['POST', '/disciplina/buscar', 'DisciplinaController', 'buscarDisciplina', ['AuthMiddleware']],
        ['POST', '/disciplina/salvar', 'DisciplinaController', 'salvarDisciplina', ['AuthMiddleware']],
        ['POST', '/disciplina/excluir', 'DisciplinaController', 'excluirDisciplina', ['AuthMiddleware']],

        // Monitore
        ['GET', '/monitores', 'MonitoreController', 'getMonitores', ['AuthMiddleware']],
        ['GET', '/monitore', 'MonitoreController', 'getMonitore', ['AuthMiddleware']],
        ['POST', '/monitore', 'MonitoreController', 'criarMonitore', ['AuthMiddleware']],
        ['POST', '/monitore/buscar', 'MonitoreController', 'buscarMonitore', ['AuthMiddleware']],
        ['POST', '/monitore/salvar', 'MonitoreController', 'salvarMonitore', ['AuthMiddleware']],
        ['POST', '/monitore/excluir', 'MonitoreController', 'excluirMonitore', ['AuthMiddleware']],

        // Representante
        ['GET', '/representantes', 'RepresentanteController', 'getRepresentantes', ['AuthMiddleware']],
        ['GET', '/representante', 'RepresentanteController', 'getRepresentante', ['AuthMiddleware']],
        ['POST', '/representante', 'RepresentanteController', 'criarRepresentante', ['AuthMiddleware']],
        ['POST', '/representante/buscar', 'RepresentanteController', 'buscarRepresentante', ['AuthMiddleware']],
        ['POST', '/representante/salvar', 'RepresentanteController', 'salvarRepresentante', ['AuthMiddleware']],
        ['POST', '/representante/excluir', 'RepresentanteController', 'excluirRepresentante', ['AuthMiddleware']],

        // Sala
        ['GET', '/salas', 'SalaController', 'getSalas', ['AuthMiddleware']],
        ['GET', '/sala', 'SalaController', 'getSala', ['AuthMiddleware']],
        ['POST', '/sala', 'SalaController', 'criarSala', ['AuthMiddleware']],
        ['POST', '/sala/buscar', 'SalaController', 'buscarSala', ['AuthMiddleware']],
        ['POST', '/sala/salvar', 'SalaController', 'salvarSala', ['AuthMiddleware']],
        ['POST', '/sala/excluir', 'SalaController', 'excluirSala', ['AuthMiddleware']],

        // Tutore
        ['GET', '/tutores', 'TutoreController', 'getTutores', ['AuthMiddleware']],
        ['GET', '/tutore', 'TutoreController', 'getTutore', ['AuthMiddleware']],
        ['POST', '/tutore', 'TutoreController', 'criarTutore', ['AuthMiddleware']],
        ['POST', '/tutore/buscar', 'TutoreController', 'buscarTutore', ['AuthMiddleware']],
        ['POST', '/tutore/salvar', 'TutoreController', 'salvarTutore', ['AuthMiddleware']],
        ['POST', '/tutore/excluir', 'TutoreController', 'excluirTutore', ['AuthMiddleware']],

        // Presenca
        ['GET', '/presenca', 'PresencaController', 'getPresenca', ['AuthMiddleware']],
        ['POST', '/presenca/alune', 'PresencaController', 'criarPresencaAlune', ['AuthMiddleware']],
        ['POST', '/presenca/tutore', 'PresencaController', 'criarPresencaTutore', ['AuthMiddleware']],
        ['POST', '/presenca/monitore', 'PresencaController', 'criarPresencaMonitore', ['AuthMiddleware']],
        ['POST', '/presenca/reuniao', 'PresencaController', 'criarPresencaReuniao', ['AuthMiddleware']],
        ['POST', '/presenca/alune/buscar', 'PresencaController', 'buscarPresencaAlune', ['AuthMiddleware']],
        ['POST', '/presenca/alune/justificar', 'PresencaController', 'justificarPresencaAlune', ['AuthMiddleware']],
        ['POST', '/presenca/reuniao/buscar', 'PresencaController', 'buscarPresencaReuniao', ['AuthMiddleware']],
        ['POST', '/presenca/reuniao/justificar', 'PresencaController', 'justificarPresencaReuniao', ['AuthMiddleware']],
        ['POST', '/presenca/monitore/buscar', 'PresencaController', 'buscarPresencaMonitore', ['AuthMiddleware']],
        ['POST', '/presenca/monitore/editar', 'PresencaController', 'editarPresencaMonitore', ['AuthMiddleware']],
        ['POST', '/presenca/tutore/buscar', 'PresencaController', 'buscarPresencaTutore', ['AuthMiddleware']],
        ['POST', '/presenca/tutore/editar', 'PresencaController', 'editarPresencaTutore', ['AuthMiddleware']],
        ['POST', '/presenca/sala-alune/buscar', 'PresencaController', 'buscarSalaAlune', ['AuthMiddleware']],
        ['POST', '/presenca/sala-alune-justifica/buscar', 'PresencaController', 'buscarSalaAluneJustifica', ['AuthMiddleware']],
        ['POST', '/presenca/relatorio/alune', 'PresencaController', 'relatorioPresencaAlune', ['AuthMiddleware']],
        ['POST', '/presenca/relatorio/reuniao', 'PresencaController', 'relatorioPresencaReuniao', ['AuthMiddleware']],
        ['POST', '/presenca/relatorio/monitore', 'PresencaController', 'relatorioPresencaMonitore', ['AuthMiddleware']],
        ['POST', '/presenca/relatorio/tutore', 'PresencaController', 'relatorioPresencaTutore', ['AuthMiddleware']],

        // Certificados
        ['POST', '/certificado/tutore', 'CertificadoController', 'certificadoTutore', ['AuthMiddleware']],
        ['POST', '/certificado/monitore', 'CertificadoController', 'certificadoMonitore', ['AuthMiddleware']],
        ['GET', '/certificado/tutores', 'CertificadoController', 'certificadoGetTutores', ['AuthMiddleware']],
        ['POST', '/certificado/tutore/buscar', 'CertificadoController', 'certificadoGetTutore', ['AuthMiddleware']],
        ['GET', '/certificado/monitores', 'CertificadoController', 'certificadoGetMonitores', ['AuthMiddleware']],
        ['POST', '/certificado/monitore/buscar', 'CertificadoController', 'certificadoGetMonitore', ['AuthMiddleware']],
        ['GET', '/certificado/representantes', 'CertificadoController', 'certificadoGetRepresentantes', ['AuthMiddleware']],
        ['POST', '/certificado/representante/buscar', 'CertificadoController', 'certificadoGetRepresentante', ['AuthMiddleware']],
    ];
