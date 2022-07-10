<?php
require_once('autoload.php');

class AcaoSalaVirtual extends AcaoBase {

    /**
     * {@inheritdoc}
     */
    protected function getAcoesConsulta(): array {
        $acoes = parent::getAcoesConsulta();
        $acoes[] = self::ACAO_PROFESSORES;
        $acoes[] = self::ACAO_ALUNOS;
        $acoes[] = self::ACAO_REGISTRO_AULA;
        return $acoes;
    }

    /**
     * {@inheritdoc}
     */
    protected function filtraConsulta() {
        $this->adicionaCondicaoComplexaSalaVirtualPerfil();
    }

    /**
     * Filtra a consulta das salas virtuais através do vínculo do usuário com ela.
     * Ou seja, se o perfil é um professor, ele consultará apenas as salas virtuais que ele é vinculado.
     * Idem para o aluno
     */
    protected function adicionaCondicaoComplexaSalaVirtualPerfil() {
        $tipoPerfil = $_SESSION['tipo'];
        if (in_array($tipoPerfil, [Usuario::PERFIL_PROFESSOR, Usuario::PERFIL_ALUNO])) {
            $chave  = $tipoPerfil == Usuario::PERFIL_PROFESSOR ? $_SESSION['codigoProfessor'] : $_SESSION['codigoAluno'];
            $tabela = [
                Usuario::PERFIL_PROFESSOR => 'TBSalaVirtualProfessor',
                Usuario::PERFIL_ALUNO     => 'TBSalaVirtualAluno'
            ];
            $colunaCodigo = [
                Usuario::PERFIL_PROFESSOR => 'PROCodigo',
                Usuario::PERFIL_ALUNO     => 'ALUCodigo'
            ];
            $this->adicionaCondicaoComplexa(' EXISTS ('.$this->getCondicaoSalaVirtualTipoPerfil($chave, $tabela[$tipoPerfil], $colunaCodigo[$tipoPerfil]).') ');
        }
    }

    /**
     * Retorna o SubSQL para a condição complexa do filtro das salas virtuais
     * @param string $chave
     * @param string $tabela
     * @param string $colunaCondicao
     * @return string
     */
    protected function getCondicaoSalaVirtualTipoPerfil(string $chave, string $tabela, string $colunaCondicao) : string {
        $sql = 'SELECT 1'
            .   ' FROM '.$tabela
            .  ' WHERE '.$tabela.'.SALCodigo = TBSalaVirtual.SALCodigo'
            .    ' AND '.$tabela.'.'.$colunaCondicao.' = '.$chave.' ';
        return $sql;
    }


}