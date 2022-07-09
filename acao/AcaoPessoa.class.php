<?php
require_once('autoload.php');

class AcaoPessoa extends AcaoBase {

    /**
     * {@inheritdoc}
     */
    protected function antesExecutarInclusao() {
        $this->getDados()->getModelo()->getUsuario()->setCodigo($this->incluiUsuario());
    }

    /**
     * {@inheritdoc}
     */
    protected function incluiUsuario() : string {
        $acaoUsuario = new AcaoUsuario();
        $dadosUsuario = new DadosUsuario();
        $dadosUsuario->setModelo($this->getDados()->getModelo()->getUsuario());
        $acaoUsuario->setDados($dadosUsuario);
        $acaoUsuario->processaInclusao();
        return $acaoUsuario->getDados()->getUltimoIdInserido();
    }

    /**
     * {@inheritdoc}
     */
    protected function depoisExecutarInclusao() {
        $this->incluiUsuarioTipo();
    }

    /**
     * Exclui o registro do usuário da tabela que representa o tipo do seu usuário
     */
    protected function incluiUsuarioTipo() {
        $acao = $this->getAcaoDadosUsuarioTipo($this->getDados()->getUltimoIdInserido());
        $acao->processaInclusao();
    }

    /**
     * Prepara uma classe de Dados contendo as classes referente a tabela que marca o tipo do usuário
     * @param int $codigoPessoa
     * @param string $operacao
     */
    protected function getAcaoDadosUsuarioTipo($codigoPessoa) : AcaoBase {
        $this->getDados()->getModelo()->setCodigo($codigoPessoa);
        $tipoUsuario = [
            Usuario::PERFIL_PROFESSOR   => 'Professor',
            Usuario::PERFIL_RESPONSAVEL => 'Responsavel',
            Usuario::PERFIL_ALUNO       => 'Aluno',
        ];
        $nomeObjeto = $tipoUsuario[$this->getDados()->getModelo()->getUsuario()->getTipoUsuario()->getCodigo()];
        $modelo = new $nomeObjeto();
        $modelo->setPessoa($this->getDados()->getModelo());
        $nomeDadosObjeto = 'Dados'.$nomeObjeto;
        $dados  = new $nomeDadosObjeto();
        $dados->setModelo($modelo);
        $nomeAcaoObjeto = 'Acao'.$nomeObjeto;
        $acao = new $nomeAcaoObjeto();
        $acao->setDados($dados);
        return $acao;
    }

    /**
     * {@inheritdoc}
     */
    protected function antesExecutarAlteracao() {
        $acaoUsuario = new AcaoUsuario();
        $dadosUsuario = new DadosUsuario();
        $dadosUsuario->setModelo($this->getDados()->getModelo()->getUsuario());
        $acaoUsuario->setDados($dadosUsuario);
        $acaoUsuario->processaAlteracao();
    }

    /**
     * {@inheritdoc}
     */
    protected function antesExecutarExclusao() {
        $this->getDados()->buscaDados();
        $this->excluiUsuarioTipo();
    }
    
    /**
     * Exclui o registro do usuário da tabela que representa o tipo do seu usuário
     */
    protected function excluiUsuarioTipo() {
       $acao = $this->getAcaoDadosUsuarioTipo($this->getDados()->getModelo()->getCodigo());
       $acao->getDados()->buscaDados();
       $acao->getDados()->delete();
    }

    /**
     * {@inheritdoc}
     */
    protected function depoisExecutarExclusao() {
        $this->excluiUsuario();
    }

    /**
     * Exclui o usuário que a pessoa era vinculada
     */
    protected function excluiUsuario() {
        $acaoUsuario = new AcaoUsuario();
        $dadosUsuario = new DadosUsuario();
        $dadosUsuario->setModelo($this->getDados()->getModelo()->getUsuario());
        $acaoUsuario->setDados($dadosUsuario);
        $acaoUsuario->processaExclusao();
    }

    /**
     * {@inheritdoc}
     */
    protected function executarAtivacao() : bool {
        $acaoUsuario = new AcaoUsuario();
        $dadosUsuario = new DadosUsuario();
        $this->getDados()->buscaDados();
        $dadosUsuario->setModelo($this->getDados()->getModelo()->getUsuario());
        $acaoUsuario->setDados($dadosUsuario);
        return $acaoUsuario->processaAtivacao();
    }

    /**
     * {@inheritdoc}
     */
    protected function executarDesativacao() : bool {
        $acaoUsuario = new AcaoUsuario();
        $dadosUsuario = new DadosUsuario();
        $this->getDados()->buscaDados();
        $dadosUsuario->setModelo($this->getDados()->getModelo()->getUsuario());
        $acaoUsuario->setDados($dadosUsuario);
        return $acaoUsuario->processaDesativacao();
    }

    /**
     * {@inheritdoc}
     */
    protected function getAcoesConsulta(): array {
        $acoes = parent::getAcoesConsulta();
        $acoes[] = self::ACAO_ATIVAR;
        $acoes[] = self::ACAO_DESATIVAR;
        return $acoes;
    }


}