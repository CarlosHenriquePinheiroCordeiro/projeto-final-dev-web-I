<?php

interface InterfaceLista {

    /**
     * Retorna o objeto em formato de selecionável para algum tipo de listagem de objetos
     * @return Lista
     */
    public function toLista() : Lista;


}