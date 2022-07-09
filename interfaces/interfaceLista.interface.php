<?php

interface InterfaceLista {

    /**
     * Retorna o objeto em formato de option para select em HTML
     * @param string
     * @return string
     */
    public function toLista(string $valor = null) : string;


}