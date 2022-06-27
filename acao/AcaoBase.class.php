<?php
/**
 * Classe base para as classes de Acao
 */
abstract class AcaoBase {

    /** @var mixed */
    protected $Dados;

    const ACAO_ALTERAR      = 'alterar';
    const ACAO_EXCLUIR      = 'exclusao';
    const ACAO_ATIVAR       = 'ativacao';
    const ACAO_DESATIVAR    = 'desativacao';

    const NOME_ACAO = [
        self::ACAO_ALTERAR    => 'Alterar',
        self::ACAO_EXCLUIR    => 'Excluir',
        self::ACAO_ATIVAR     => 'Ativar',
        self::ACAO_DESATIVAR  => 'Desativar'
    ];
    
    /**
     * Retorna a consulta de dados
     * @param string $classe
     * @param array $atributos
     * @return string
     */
    public function consulta(string $classe, array $consulta) : string {
        $atributos = array_map(function($linha) {
            return $linha[0];
        }, $consulta);
        $dadosConsulta = $this->buscaDadosConsulta($atributos);
        return $this->montaConsulta($classe, $consulta, $dadosConsulta);
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
    protected function montaConsulta(string $classe, array $colunas, array $dados) : string{
        $tabela = '<table border="1">';
        $tabela .= $this->montaCabecalho($colunas);
        $tabela .= $this->montaLinhas($classe, $colunas, $dados);
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
    protected function montaLinhas(string $classe, array $colunas, array $dadosLinhas) : string {
        $linhas = '';
        $atributos = array_map(function($coluna) {
            return $coluna[0];
        }, $colunas);
        foreach ($dadosLinhas as $linha) {
            $linhas .= $this->montaLinha($classe, $atributos, $linha);
        }
        return $linhas;
    }

    /**
     * Monta uma linha para consulta
     * @param array $atributos
     * @param array $dadosLinha
     * @return string
     */
    protected function montaLinha(string $classe, array $atributos, mixed $objetoLinha) : string {
        $linha = '<tr>';
        foreach ($atributos as $atributo) {
            $linha .= $this->montaColuna($this->getDados()->getValorModelo($objetoLinha, $atributo));
        }
        $linha .= $this->montaColuna($this->montaAcoesLinha($classe, $objetoLinha));
        $linha .= '</tr>';
        return $linha;
    }

    /**
     * Monta uma coluna para uma linha
     * @param string $atributo
     * @param array $dadosLinha
     * @return string
     */
    protected function montaColuna(string $valor) : string {
        return '<td>'.$valor.'</td>';
    }

    /**
     * Monta as ações para cada linha da consulta
     * @param mixed $objetoLinha
     */
    protected function montaAcoesLinha(string $classe, mixed $objetoLinha) : string {
        $valores = [];
        foreach ($this->getDados()->getChavesPrimarias() as $primaria) {
            $valores[] = $primaria->getAtributo().'='.$this->getDados()->getValorModelo($objetoLinha, $primaria->getAtributo());
        }
        $valores[] = 'tela=consulta'.$classe.'.php';
        $valores[] = 'classeAcao='.$classe;
        $acoesLinha = '';
        foreach ($this->getAcoesConsulta() as $acao) {
            $acoesLinha .= $this->montaAcao($classe, $acao, $valores);
        }
        return $acoesLinha;
    }

    /**
     * Retorna uma ação para uma coluna da consulta
     * @param string $acao
     * @param array $valores
     * @return string
     */
    protected function montaAcao(string $classe, string $acao, array $valores) : string {
        $arquivo = $acao == self::ACAO_ALTERAR ? 'cad'.$classe.'.php' : 'acao.php';
        $action  = $arquivo.'?'.implode('&', $valores);
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
     * Função que retorna quais ações podem ser utilizadas na consulta (a inclusão vem por padrão). 
     * Caso se deseje adicionar mais ações do que o padrão, basta sobrescrever este médodo e adicionar mais ações, 
     * dentro das permitidas no escopo da classe
     * @return array
     */
    protected function getAcoesConsulta() : array {
        return [self::ACAO_ALTERAR, self::ACAO_EXCLUIR];
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
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->insert();
            $this->getDados()->commit();
        } catch (Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a inclusão: '.$th->getMessage();
            echo $th->getMessage();
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
    protected function antesExecutarAlteracao() {

    }

    /**
     * Processa a alteração de dados
     */
    protected function executaAlteracao() : bool {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->update();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a alteração: '.$th->getMessage();
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
        $sucesso = false;
        $this->antesExecutarExclusao();
        $sucesso = $this->executaExclusao();
        $this->depoisExecutarExclusao();
        return $sucesso;
    }

    /**
     * Função feita para ser sobrescrita caso se queira realizar algum processo antes que uma exclusão seja feita
     */
    protected function antesExecutarExclusao() {

    }

    /**
     * Processa a exclusão de dados
     */
    public function executaExclusao() : bool {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->delete();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a exclusão: '.$th->getMessage();
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
    protected function executarAtivacao() {
        $sucesso = false;
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->ativar();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a ativação: '.$th->getMessage();
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
        $this->getDados()->begin();
        try {
            $sucesso = $this->getDados()->desativar();
            $this->getDados()->commit();
        } catch (\Throwable $th) {
            $this->getDados()->rollback();
            echo 'Ocorreu um erro ao tentar realizar a desativação: '.$th->getMessage();
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


}