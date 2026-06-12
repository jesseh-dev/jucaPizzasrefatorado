<?php

namespace JesseVsouza\JucapizzasRefatorado\Models;

use PDO;
use Exception;

class Pizza {

    private $conn;
    private $tabela = "pizzas";

    public $idPizza;
    private $nome;
    public $ingredientes;
    private float $valor;

// Getters e Setters
    public function getValor(): float {
        return $this->valor;
    }
    public function setValor(float $valor): void {
        if ($valor<=0) {
            throw new Exception("Valor inválido. É necessário um valor maior que zero.");
        }
        $this->valor = $valor;
    }

  public function getNome(): string {
        return $this->nome;
    }
    public function setNome(string $nome): void {
       if (trim($nome) === '') {
            throw new Exception("Nome da pizza não pode ser vazio. Necessário preencher o nome da pizza.");
        }else if (strlen(trim($nome)) < 3) {
            throw new Exception("Valor inválido. O nome da pizza deve conter entre 3 caracteres.");
        }

        $this->nome = $nome;







    }


        







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


