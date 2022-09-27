<?php
require_once 'modelabstract.class.php';

class ProdutoModel extends ModelAbstract {
    private $prodId            = null;
    private $prodNome          = null;
    private $prodDescricao     = null;
    private $prodValor         = null;
    private $prodQtdeEmEstoque = null;

    function __construct ($prodId = null, $prodNome = null,
                          $prodDescricao = null, $prodValor = null,
                          $prodQtdeEmEstoque = null) {
        parent::__construct ();

        $this->prodId            = $prodId;
        $this->prodNome          = $prodNome;
        $this->prodDescricao     = $prodDescricao;
        $this->prodValor         = $prodValor;
        $this->prodQtdeEmEstoque = $prodQtdeEmEstoque;
    }

    public function checaAtributos () {
        $atributosOk = true;

        //prodId
        //Apesar de ser obrigatório não é necessário checar pq é 
        //autoincrementável e não se deixa o usuário informá-lo.
        //prodNome
        //É obrigatório e com no máximo 45 caracteres.
        //prodDescrição
        //É obrigatório e com máximo de 500 caracteres.
        //prodValor
        //É obrigatório e numérico com casas decimais.
        //prodQtdeEmEstoque
        //Obrigatório, inteiro.

        return $atributosOk;
    }

    function getProdId () {
        return $this->prodId;
    }

    function getProdNome () {
        return $this->prodNome;
    }

    function getProdDescricao () {
        return $this->prodDescricao;
    }

    function getProdValor () {
        return $this->prodValor;
    }

    function getProdQtdeEmEstoque () {
        return $this->prodQtdeEmEstoque;
    }

    function setProdId ($prodId): void {
        $this->prodId = $prodId;
    }

    function setProdNome ($prodNome): void {
        $this->prodNome = $prodNome;
    }

    function setProdDescricao ($prodDescricao): void {
        $this->prodDescricao = $prodDescricao;
    }

    function setProdValor ($prodValor): void {
        $this->prodValor = $prodValor;
    }

    function setProdQtdeEmEstoque ($prodQtdeEmEstoque): void {
        $this->prodQtdeEmEstoque = $prodQtdeEmEstoque;
    }

}
?>