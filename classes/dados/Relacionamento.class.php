<?php
require_once('autoload.php');

class Relacionamento {

    const BIGINT   = PDO::PARAM_INT;
    const INTEGER  = PDO::PARAM_INT;
    const VARCHAR  = PDO::PARAM_STR;
    const DATE     = PDO::PARAM_STR;
    const BOOLEAN  = PDO::PARAM_BOOL;

    const VALOR_STRING = [
        self::VARCHAR,
        self::BOOLEAN
    ];

    /** @var boolean */
    private $primaria = false;

    /** @var boolean */
    private $estrangeira = false;

    /** @var boolean */
    private $chavePai = false;

    /** @var array */
    private $referencia = [];

    /** @var string */
    private $tabelaReferencia;

    /** @var int */
    private $tipo;

    /** @var string */
    private $coluna;

    /** @var string */
    private $atributo;

    /** @var array */
    public static $tipos = [
        self::INTEGER => 'number',
        self::VARCHAR => 'text',
        self::DATE    => 'date',
    ];
    
    public function __construct(string $coluna, string $atributo, int $tipo = 0) {
        $this->coluna    = $coluna;
        $this->atributo = $atributo;
        $this->tipo      = $tipo;
    }

    /**
     * Define que esta é uma chave primária
     * @return self
     */
    public function chavePrimaria() : self {
        $this->primaria = true;
        return $this;
    }

    /**
     * Define que esta é uma chave estrangeira
     * @return self
     */
    public function chaveEstrangeira() : self {
        $this->estrangeira = true;
        return $this;
    }

    /**
     * Define que esta é uma chave pai, em uma relação associativa
     * @return self
     */
    public function chavePai() : self {
        $this->chavePai = true;
        return $this;
    }

    /**
     * Define a referência da chave estrangeira
     * @return self
     */
    public function referencia(string $coluna, string $atributo) : self {
        if ($this->isEstrangeira()) {
            $this->referencia = ['col' => $coluna, 'att' => $atributo];
        }
        return $this;
    }

    /**
     * Define a tabela da referência da chave estrangeira
     * @return self
     */
    public function on(string $tabela) : self {
        if (count($this->getReferencia()) > 0) {
            $this->tabelaReferencia = $tabela;
        }
        return $this;
    }

    /**
     * Get the value of primaria
     * @return boolean
     */ 
    public function isPrimaria() : bool {
        return $this->primaria;
    }

    /**
     * Get the value of estrangeira
     * @return boolean
     */ 
    public function isEstrangeira() : bool {
        return $this->estrangeira;
    }

    /**
     * Get the value of chavePai
     */ 
    public function isChavePai() {
        return $this->chavePai;
    }

    /**
     * Get the value of referencia
     * @return array
     */ 
    public function getReferencia() : array {
        return $this->referencia;
    }

    /**
     * Get the value of tabelaReferencia
     * @return string
     */ 
    public function getTabelaReferencia() : string {
        return $this->tabelaReferencia;
    }

    /**
     * Get the value of tipo
     * @return int
     */ 
    public function getTipo() : int {
        return $this->tipo;
    }

    /**
     * Get the value of coluna
     * @return string
     */ 
    public function getColuna() : string {
        return $this->coluna;
    }

    /**
     * Get the value of atributo
     * @return string
     */ 
    public function getAtributo() : string {
        return $this->atributo;
    }


}