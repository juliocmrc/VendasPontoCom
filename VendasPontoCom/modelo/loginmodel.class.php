<?php
require_once 'modelabstract.class.php';

class LoginModel extends ModelAbstract {
    
    private $clieCPF = null;

    function __construct ($clieCPF = null) {
        parent::__construct ();

        $this->clieCPF                   = $clieCPF;
    }
    
    function getClieCPF () {
        return $this->clieCPF;
    }

    function setClieCPF ($clieCPF) {
        $this->clieCPF = $clieCPF;
    }

    public function checaAtributos () {
        
        $atributosOk = true;

        if (is_null ($this->clieCPF) || trim ($this->clieCPF) == '') {
            $atributosOk = false;
            $this->adicionaMensagem ("Informe um CPF válido!");
        }

        return $atributosOk;
    }
}

?>