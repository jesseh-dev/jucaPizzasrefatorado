<?php

namespace JesseVsouza\JucapizzasRefatorado\Models;

use PDO;

class Bebida {

    private $conn;
    private $tabela = "bebidas";

    public $idBebida;
    public $nome;
    public $tipoBebida;
    public $categoria;
    public $tamanho;
    public $valor;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getall() {

        $query = "SELECT
                    idBebida,
                    nome,
                    tipoBebida,
                    categoria,
                    tamanho,
                    valor
                  FROM " . $this->tabela;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function get() {

        $query = "SELECT
                    idBebida,
                    nome,
                    tipoBebida,
                    categoria,
                    tamanho,
                    valor
                FROM
                    " . $this->tabela . "
                WHERE
                    idBebida = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->idBebida);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->nome = $row['nome'];
        $this->tipoBebida = $row['tipoBebida'];
        $this->categoria = $row['categoria'];
        $this->tamanho = $row['tamanho'];
        $this->valor = $row['valor'];
    }

   public function add() {
        
        $query = 'INSERT INTO ' . $this->tabela . ' SET nome = :nome, tipoBebida = :tipoBebida, categoria = :categoria, tamanho = :tamanho, valor = :valor';

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->tipoBebida = htmlspecialchars(strip_tags($this->tipoBebida));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->valor = htmlspecialchars(strip_tags($this->valor));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':tipoBebida', $this->tipoBebida);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':tamanho', $this->tamanho);
        $stmt->bindParam(':valor', $this->valor);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update() {
       
        $query = 'UPDATE ' . $this->tabela . ' SET nome=:nome, tipoBebida=:tipoBebida, categoria=:categoria, tamanho=:tamanho, valor=:valor WHERE idBebida=:id';
 
      
        $stmt = $this->conn->prepare($query);
 
      
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->tipoBebida = htmlspecialchars(strip_tags($this->tipoBebida));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));
        $this->tamanho = htmlspecialchars(strip_tags($this->tamanho));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));
 
        
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':tipoBebida', $this->tipoBebida);
        $stmt->bindParam(':categoria', $this->categoria);
        $stmt->bindParam(':tamanho', $this->tamanho);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':id', $this->idBebida);
 
        // Executar a query
        if($stmt->execute()) {
            return true;
        }
     
        return false;
    }

    public function delete() {

    // Query de exclusão
    $query = 'DELETE FROM ' . $this->tabela . ' WHERE idBebida = :id';

    // Preparar a query
    $stmt = $this->conn->prepare($query);

    // Limpar os dados
    $this->idBebida = htmlspecialchars(strip_tags($this->idBebida));

    // Vincular o parâmetro
    $stmt->bindParam(':id', $this->idBebida);

    // Executar a query
    if($stmt->execute()) {
        return true;
    }

    return false;
}




}



