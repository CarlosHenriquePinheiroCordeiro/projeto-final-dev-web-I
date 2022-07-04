<?php
require_once('autoload.php');

class AcaoUsuario extends AcaoBase {

    const USUARIO_ATIVADO   = 1;
    const TERMO_NAO_ACEITOU = 0;
    const TERMO_ACEITOU     = 1;

    /**
     * {@inheritdoc}
     */
    protected function getAcoesConsulta() : array {
        $acoes = parent::getAcoesConsulta();
        $acoes[] = self::ACAO_ATIVAR;
        $acoes[] = self::ACAO_DESATIVAR;
        return $acoes;
    }

    /**
     * {@inheritdoc}
     */
    protected function antesExecutarInclusao() {
        $this->setaSenhaSHA1();
        $this->setaTermoAtivo();
    }

    /**
     * {@inheritdoc}
     */
    protected function antesExecutarAlteracao() {
        // $this->setaTermoAtivo(self::TERMO_ACEITOU);
        // $this->setaSenhaSHA1();
    }

    /**
     * Seta a senha criptografada
     */
    protected function setaSenhaSHA1() {
        $senhaSha1 = sha1($this->getDados()->getModelo()->getSenha());
        $this->getDados()->getModelo()->setSenha($senhaSha1);
    }

    /**
     * Define os estados de Ativo e Termo para um novo usuário incluso
     */
    protected function setaTermoAtivo($termo = self::TERMO_NAO_ACEITOU, $ativo = self::USUARIO_ATIVADO) {
        $this->getDados()->getModelo()->setAtivo($ativo);
        $this->getDados()->getModelo()->setTermo($termo);
    }


}