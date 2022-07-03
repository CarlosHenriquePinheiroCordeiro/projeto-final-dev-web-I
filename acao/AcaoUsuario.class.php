<?php
require_once('autoload.php');

class AcaoUsuario extends AcaoBase {

    const USUARIO_ATIVADO   = 1;
    const TERMO_NAO_ACEITOU = 0;

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
        $this->setaAtivoTermo();
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
    protected function setaAtivoTermo() {
        $this->getDados()->getModelo()->setTermo(self::TERMO_NAO_ACEITOU);
        $this->getDados()->getModelo()->setAtivo(self::USUARIO_ATIVADO);
    }


}