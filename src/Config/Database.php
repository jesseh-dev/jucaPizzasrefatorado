<?php

namespace JesseVsouza\JucapizzasRefatorado\Config;

use PDO;
use PDOException; 
use Throwable;

class Database {
    private $host = 'localhost';
    private $db_name = 'jucapizzasdb';
    private $username = 'root';
    private $password = 'usbw';
    private $port = '3310';
    
    
    public $conn;

    public function getConnection(){

        $this->conn = null;

        try {

            // O try tenta executar um código potencialmente perigoso, ou seja, que pode gerar um erro
            // DSN (Data Source Name) é uma string que contém as informações necessárias para se conectar a um banco de dados usando PDO (PHP Data Objects).
            // Ela inclui o tipo de banco de dados, o nome do host, o nome do banco de dados e outras opções de conexão.
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name . ';charset=utf8';

            // Instancia o objeto PDO 
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Define o modo de erro do PDO para exceção
            // Isso faz com que o PDO lance exceções em caso de erro,
            // facilitando o tratamento
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            // Em caso de erro na conexão, exibe a mensagem de erro
            echo 'Erro de conexão: ' . $e->getMessage();
        } catch(Throwable $e) {
            echo 'Erro: ' . $e->getMessage();

        }

        return $this->conn;
    }
}