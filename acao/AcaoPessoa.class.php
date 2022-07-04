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