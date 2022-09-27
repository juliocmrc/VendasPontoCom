<?php

/**
 * Este é um Código da Fábrica de Software
 * 
 * Coordenador: Elymar Pereira Cabral
 * 
 * Descrição de AtributosBD:
 * Atributos a serem usados para se conectar ao banco de dados.
 *
 * @date 18/05/2012
 *
 * @autor Elymar Pereira Cabral
 */
class AtributosBd {
    private $host    = "localhost";
    private $bdNome  = "VendasPontoCom";
    private $usuario = "root";
    private $senha   = "";


    function getHost () {
        return $this->host;
    }

    function getBdNome () {
        return $this->bdNome;
    }

    function getUsuario () {
        return $this->usuario;
    }

    function getSenha () {
        return $this->senha;
    }

    function getTipo () {
        return $this->tipo;
    }

    function setHost ($host): void {
        $this->host = $host;
    }

    function setBdNome ($bdNome): void {
        $this->bdNome = $bdNome;
    }

    function setUsuario ($usuario): void {
        $this->usuario = $usuario;
    }

    function setSenha ($senha): void {
        $this->senha = $senha;
    }

    function setTipo ($tipo): void {
        $this->tipo = $tipo;
    }

}
?>
