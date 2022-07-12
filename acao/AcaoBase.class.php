<?php
/**
 * Classe base para as classes de Acao
 */
abstract class AcaoBase {

    /** @var mixed */
    protected $Dados;

    const ACAO_ALTERAR       = 'alterar';
    const ACAO_VISUALIZAR    = 'visualizar';
    const ACAO_EXCLUIR       = 'exclusao';
    const ACAO_ATIVAR        = 'ativacao';
    const ACAO_DESATIVAR     = 'desativacao';
    const ACAO_PROFESSORES   = 'professores';
    const ACAO_ALUNOS        = 'alunos';
    const ACAO_REGISTRO_AULA = 'registrosAula';
    const ACAO_PRESENCAS     = 'presencas';

    const NOME_ACAO = [
        self::ACAO_ALTERAR       => 'Alterar',
        self::ACAO_VISUALIZAR    => 'Visualizar',
        self::ACAO_EXCLUIR       => 'Excluir',
        self::ACAO_ATIVAR        => 'Ativar',
        self::ACAO_DESATIVAR     => 'Desativar',
        self::ACAO_PROFESSORES   => 'Professores',
        self::ACAO_ALUNOS        => 'Alunos',
        self::ACAO_REGISTRO_AULA => 'Registros de Aula',
        self::ACAO_PRESENCAS     => 'Presenças'
    ];

    const ACOES_CAD = [
        self::ACAO_ALTERAR,
        self::ACAO_VISUALIZAR,
        self::ACAO_PROFESSORES,
        self::ACAO_ALUNOS,
        self::ACAO_REGISTRO_AULA,
        self::ACAO_PRESENCAS
    ];
    
    /**
     * Retorna a consulta de dados
     * @param string $classe
     * @param array  $consulta
     * @param string $tela
     * @param array  $parametros
     * @return string
     */
    public function consulta(string $classe, array $consulta, string $tela = '', array $parametros = []) : string {
        if ($tela == '') {
            $tela = $classe;
        }
        $atributos = array_map(function($linha) {
            return $linha[0];
        }, $consulta);
        $this->filtraConsulta();
        $this->ordenar();
        $dadosConsulta = $this->buscaDadosConsulta($atributos);
        return $this->montaConsulta($classe, $tela, $consulta, $dadosConsulta, $parametros);
    }

    /**
     * Busca os dados para a consulta
     * @param array $colunas
     * @return array
     */
    protected function buscaDadosConsulta(array $atributos) : array {
        return $this->getDados()->query($atributos);
    }

    /**
     * Monta a consulta para a tela
     * @param array $colunas
     * @param array $dados
     */
    protected function montaConsulta(string $classe, string $tela, array $colunas, array $dados, array $parametros = []) : string{
        $tabela = '<table border="1">';
        $tabela .= $this->montaCabecalho($colunas);
        $tabela .= $this->montaLinhas($classe, $tela, $colunas, $dados, $parametros);
        $tabela .= '</table>';
        return $tabela;
    }

    /**
     * Retorna o cabeçalho para a consulta
     * @param array $colunas
     * @return string
     */
    protected function montaCabecalho(array $colunas): string {
        $cabecalho = '<tr>';
        $titulos = array_map(function($coluna) {
            return $coluna[1];
        }, $colunas);
        foreach ($titulos as $titulo) {
            $cabecalho .= '<th>'.$titulo.'</th>';
        }
        $cabecalho .= '<th>Ação</th>';
        $cabecalho .= '</tr>';
        return $cabecalho;
    }

    /**
     * Retorna as linhas para a consulta
     * @param array $colunas
     * @param array $dadosLinhas
     * @return string
     */
    protected function montaLinhas(string $classe, string $tela, array $colunas, array $dadosLinhas, array $parametros = []) : string {
        $linhas = '';
        $atributos = array_map(function($coluna) {
            return $coluna[0];
        }, $colunas);
        foreach ($dadosLinhas as $linha) {
            $linhas .= $this->montaLinha($classe, $tela, $atributos, $linha, $parametros);
        }
        return $linhas;
    }

    /**
     * Monta uma linha para consulta
     * @param array $atributos
     * @param array $dadosLinha
     * @return string
     */
    protected function montaLinha(string $classe, string $tela, array $atributos, mixed $objetoLinha, array $parametros = []) : string {
        $linha = '<tr>';
        
        foreach ($atributos as $atributo) {
            $linha .= $this->montaColuna($this->getDados()->getValorModelo($objetoLinha, $atributo));
        }
        $linha .= $this->montaColuna($this->montaAcoesLinha($classe, $tela, $objetoLinha, $parametros));
        $linha .= '</tr>';
        return $linha;
    }

    /**
     * Monta uma coluna para uma linha
     * @param string $atributo
     * @param array $dadosLinha
     * @return string
     */
    protected function montaColuna(mixed $valor) : string {
        return '<td>'.$valor.'</td>';
    }

    /**
     * Monta as ações para cada linha da consulta
     * @param mixed $objetoLinha
     */
    protected function montaAcoesLinha(string $classe, string $tela, mixed $objetoLinha, array $parametros = []) : string {
        $valores = [];
        foreach ($this->getDados()->getChavesPrimarias() as $primaria) {
            $valores[] = 'c_'.$primaria->getAtributo().'='.$this->getDados()->getValorModelo($objetoLinha, $primaria->getAtributo());
        }
        $valores[] = $this->montaTelaConsultaRedirecionar($tela, $parametros);
        $valores[] = 'classeAcao='.$classe;
        $acoesLinha = '';
        foreach ($this->getAcoesConsulta() as $acao) {
            $acoesLinha .= $this->montaAcao($tela, $acao, $valores, $parametros);
        }
        return $acoesLinha;
    }

    /**
     * Monta o parâmetro da tela de consulta que a ação irá redirecionar após ser concluída
     * @param string $tela
     * @param array $parametros
     * @return string
     */
    protected function montaTelaConsultaRedirecionar(string $tela, array $parametros = []) {
        $parametroTela = 'tela=consulta'.ucfirst($tela).'.php';
        if (count($parametros) > 0) {
            $parametroTela .= '?'.implode('&', $parametros);
        }
        return $parametroTela;
    }

    /**
     * Retorna uma ação para uma coluna da consulta
     * @param string $tela
     * @param string $acao
     * @param array $valores
     * @param array $parametros
     * @return string
     */
    protected function montaAcao(string $tela, string $acao, array $valores, array $parametros) : string {
        $arquivo = in_array($acao, self::ACOES_CAD) ? 'cad'.$tela.'.php' : 'acao.php';
        $action  = $arquivo.'?'.implode('&', $valores).'&'.implode('&', $parametros);
        $action .= '&acao='.$acao;
        return '<a href='.$action.'>'.self::NOME_ACAO[$acao].'</a><br>';
    }

    /**
     * Função feita para ser sobrescrita quando se deseja adicionar condições à uma consulta
     */
    protected function filtraConsulta() {}

    /**
     * Função feita para se sobrescrita qunado se deseja adicionar ordenações à uma consulta
     */
    protected function ordenar() {}

    /**
     * Adiciona uma condição à consulta
     */
    protected function adicionaCondicao(string $atributo, string $operador, string $valor) {
        $this->getDados()->adicionaCondicaoConsulta($atributo, $operador, $valor);
    }

    /**
     * Adiciona uma condição complexa à consulta
     */
    protected function adicionaCondicaoComplexa(string $condicao) {
        $this->getDados()->adicionaCondicaoComplexa($condicao);
    }

    /**
     * Função que retorna quais ações podem ser utilizadas na consulta (a inclusão vem por padrão). 
     * Caso se deseje adicionar mais ações do que o padrão, basta sobrescrever este médodo e adicionar mais ações, 
     * dentro das permitidas no escopo da classe
     * @return array
     */
    protected function getAcoesConsulta() : array {
        if ($this->getAcaoAlterar()) {
            $acoes[] = $this->getAcaoAlterar();
        }
        if ($this->getAcaoExcluir()) {
            $acoes[] = $this->getAcaoExcluir();
        }
        $acoes[] = self::ACAO_VISUALIZAR;
        return $acoes;
    }

    /**
     * Chama o processamento da inclusão de dados
     */
    public function processaInclusao() {
        $sucesso = false;
        $this->antesExecutarInclusao();
        $sucesso = $this->executaInclusao();
        $this->depoisExecutarInclusao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma inclusão seja feita
     */
    protected function antesExecutarInclusao() {}

    /**
     * Processa a inclusão de dados
     * @return boolean
     */
    protected function executaInclusao() : bool {
        $sucesso = false;
        try {
            $sucesso = $this->getDados()->insert();
            if ($sucesso) {
                $this->getDados()->insertRelacionamentosAssociativos();
            }
        } catch (Throwable $th) {
            echo 'Ocorreu um erro ao tentar realizar a inclusão: ';
            echo $th->getMessage();
            echo $th->getTraceAsString();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma inclusão ser feita
     */
    protected function depoisExecutarInclusao() {}
    
    /**
     * Chama o processamento da alteração de dados
     * @return boolean
     */
    public function processaAlteracao() : bool {
        $sucesso = false;
        $this->antesExecutarAlteracao();
        $sucesso = $this->executaAlteracao();
        $this->depoisExecutarAlteracao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma alteração seja feita
     */
    protected function antesExecutarAlteracao() {}

    /**
     * Processa a alteração de dados
     */
    protected function executaAlteracao() : bool {
        $sucesso = false;
        try {
            $sucesso = $this->getDados()->update();
        } catch (\Throwable $th) {
            echo 'Ocorreu um erro ao tentar realizar a alteração: ';
            echo $th->getMessage();
            echo $th->getTraceAsString();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma alteração ser feita
     */
    protected function depoisExecutarAlteracao() {}
    
    /**
     * Chama o processamento da exclusão de dados
     * @return boolean
     */
    public function processaExclusao() : bool {
        $sucesso = true;
        $this->antesExecutarExclusao();
        $sucesso = $this->executaExclusao();
        $this->depoisExecutarExclusao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma exclusão seja feita
     */
    protected function antesExecutarExclusao() {}

    /**
     * Processa a exclusão de dados
     */
    public function executaExclusao() : bool {
        $sucesso = false;
        try {
            $sucesso = $this->getDados()->delete();
        } catch (\Throwable $th) {
            echo 'Ocorreu um erro ao tentar realizar a exclusão: ';
            echo $th->getMessage();
            echo $th->getTraceAsString();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma exclusão ser feita
     */
    protected function depoisExecutarExclusao() {}

    /**
     * Chama o processamento da ativação de um registro
     * @return boolean
     */
    public function processaAtivacao() : bool {
        $sucesso = false;
        $this->antesExecutarAtivacao();
        $sucesso = $this->executarAtivacao();
        $this->depoisExecutarAtivacao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma ativação seja feita
     */
    protected function antesExecutarAtivacao() {}

    /**
     * Processa a ativação de um registro
     */
    protected function executarAtivacao() : bool {
        $sucesso = false;
        try {
            $sucesso = $this->getDados()->ativar();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a ativação: ';
            echo $th->getMessage();
            echo $th->getTraceAsString();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma ativação ser feita
     */
    protected function depoisExecutarAtivacao() {}

    /**
     * Chama o processamento da ativação de um registro
     * @return boolean
     */
    public function processaDesativacao() : bool {
        $sucesso = false;
        $this->antesExecutarDesativacao();
        $sucesso = $this->executarDesativacao();
        $this->depoisExecutarDesativacao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma desaativação seja feita
     */
    protected function antesExecutarDesativacao() {}

    /**
     * Processa a desativação de um registro
     */
    protected function executarDesativacao() : bool {
        $sucesso = false;
        try {
            $sucesso = $this->getDados()->desativar();
        } catch (\Throwable $th) {
            echo 'Ocorreu um erro ao tentar realizar a desativação: ';
            echo $th->getMessage();
            echo $th->getTraceAsString();
        }
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo após uma desativação ser feita
     */
    protected function depoisExecutarDesativacao() {}

    /**
     * Get the value of Dados
     */ 
    public function getDados() : DadosBase {
        return $this->Dados;
    }

    /**
     * Set the value of Dados
     * @return  self
     */ 
    public function setDados(DadosBase $Dados) {
        $this->Dados = $Dados;
        return $this;
    }

    /**
     * Retorna a ação de alterar de acordo com os priviégios de usuário
     * @return mixed
     */
    protected function getAcaoAlterar() {
        if (in_array($_SESSION['tipo'], [Usuario::PERFIL_ADMIN, Usuario::PERFIL_PROFESSOR])) {
            return self::ACAO_ALTERAR;
        }
        return null;
    }

    /**
     * Retorna a ação de excluir de acordo com os priviégios de usuário
     * @return mixed
     */
    protected function getAcaoExcluir() {
        if (in_array($_SESSION['tipo'], [Usuario::PERFIL_ADMIN, Usuario::PERFIL_PROFESSOR])) {
            return self::ACAO_EXCLUIR;
        }
        return null;
    }


}