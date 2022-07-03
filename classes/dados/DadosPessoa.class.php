<?php
require_once('autoload.php');

class DadosPessoa extends DadosBase {

    /**
     * Define as chaves primárias da tabela
     */
    public function definePrimarias() {
        $this->integer('PESCodigo', 'codigo')->chavePrimaria();
    }

    /**
     * Define as chaves estrangeiras da tabela
     */
    public function defineEstrangeiras() {
        $this->integer('USUCodigo', 'Usuario.codigo')->chaveEstrangeira()->referencia('USUCodigo', 'codigo')->on('TBUsuario');
    }

    /**
     * Define as outras colunas da tabela
     */
    public function outrasColunas() {
        $this->varchar('PESNome'          , 'nome');
        $this->date   ('PESDataNascimento', 'dataNascimento');
        $this->varchar('PESCpf'           , 'cpf');
        $this->varchar('PESRg'            , 'rg');
    }

    /**
     * {@inheritdoc}
     */
    protected function adicionaJoins(): string {
        $join = parent::adicionaJoins();
        $join .= ' JOIN TBTipoUsuario'
                .  ' ON TBTipoUsuario.TUSCodigo = TBUsuario.TUSCodigo';
        return $join;
    }

    /**
     * Retorna o nome da tabela
     */
    public function getTabela() {
        return 'TBPessoa';
    }

    /**
     * Retorna o nome da tabela
     */
    public function getSiglaTabela() {
        return 'PES';
    }


}