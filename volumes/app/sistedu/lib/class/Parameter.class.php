<?php

class Parameter {
    
    /**
     * Nombre
     * @var string
     */
    public $Name = "";
    /**
     * Valor
     * @var mixed
     */
    public $Value = null;
    /**
     * Tipo de parámetro
     * @var int
     */
    public $Type = pdo::PARAM_NULL;
    /**
     * Longitud
     * @var numeric 
     */
    public $Length = null;
    
    /**
     * Constructor
     * @param string $Name
     * @param mixed $Value
     * @param int $Type
     * @param numeric $Length
     */
    public function __construct($Name, $Value, $Type, $Length = null) {
        $this->Name = $Name;
        $this->Value = $Value;
        $this->Type = $Type;
        $this->Length = $Length;
    }
    
}