<?php

namespace JesseVsouza\JucapizzasRefatorado\models;

class Pizza {

    private $conn;
    private $tabela = "pizzas";

    public $idPizza;
    public $nome;
    public $ingredientes;
    public $valor;

    public function __construct($db) {
        $this->conn = $db;
    }

        public function getall() {
            // Salvando a query em SQL em uma variável
        $query = "SELECT idPizza, nome, ingredientes, valor FROM " . $this->tabela;

            // Preparando a query para ser executada, ou seja, vinculado à ele a conexão com o banco de dados
        $stmt = $this->conn->prepare($query);

        $stmt->execute(); // Executando a query no BD
        
        return $stmt;

    }

    public function get() {
        // Query SQL para buscar uma pizza específica
        $query = 'SELECT 
            idPizza,
            nome,
            ingredientes,
            valor
        FROM 
            ' . $this->tabela . ' 
        WHERE 
            idPizza = ?
        LIMIT 1';

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Vinculando o ID da pizza à query
        $stmt->bindParam(1, $this->idPizza);

        // Executando a query
        $stmt->execute();

        // Buscando a linha retornada pela query
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Atribuindo os valores retornados às propriedades do objeto
        $this->nome = $row['nome'];
        $this->ingredientes = $row['ingredientes'];
        $this->valor = $row['valor'];
    }

    public function add() {
        // Query SQL para inserir uma nova pizza
        $query = 'INSERT INTO ' . $this->tabela . ' SET nome = :nome, ingredientes = :ingredientes, valor = :valor';

        // Preparando a query
        $stmt = $this->conn->prepare($query);

        // Limpando os dados para evitar SQL Injection
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));

        // Vinculando os valores à query
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);

        // Executando a query e verificando se foi bem-sucedida
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

      public function update() {
        // Query de atualização
        $query = 'UPDATE ' . $this->tabela . ' SET nome=:nome, ingredientes=:ingredientes, valor=:valor WHERE idPizza=:id';
 
        // Preparar a query
        $stmt = $this->conn->prepare($query);
 
        // Limpar os dados
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ingredientes = htmlspecialchars(strip_tags($this->ingredientes));
        $this->valor = htmlspecialchars(strip_tags($this->valor));
        $this->idPizza = htmlspecialchars(strip_tags($this->idPizza));
 
        // Vincular os parâmetros
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ingredientes', $this->ingredientes);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':id', $this->idPizza);
 
        // Executar a query
        if($stmt->execute()) {
            return true;
        }
     
        return false;
    }

        public function delete() {

   
    $query = 'DELETE FROM ' . $this->tabela . ' WHERE idPizza = :id';

    $stmt = $this->conn->prepare($query);

    $this->idPizza = htmlspecialchars(strip_tags($this->idPizza));

    $stmt->bindParam(':id', $this->idPizza);

    if($stmt->execute()) {
        return true;
    }

    return false;
}

    }


