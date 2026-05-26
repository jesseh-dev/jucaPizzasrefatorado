<?php

// CRIAÇÃO DA ROTA GETALL.PHP PARA BEBIDAS

// Headers obrigatórios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Incluir arquivos de banco de dados e modelo
include_once '../../config/Database.php';
include_once '../../models/Bebida.php';

// Instanciar o objeto Database e obter a conexão
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Bebida
$bebida = new Bebida($db);

// Verificar se o método HTTP é GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Chamar o método getall() para buscar as bebidas
    $stmt = $bebida->getall();

    $num = $stmt->rowCount();

    // Verificar se existem registros
    if ($num > 0) {

        // Array para armazenar todas as bebidas
        $bebidas_arr = array();

        // Percorrer os resultados da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            // Transformar índices do array em variáveis
            extract($row);

            // Criar array associativo da bebida
            $bebida_item = array(
                "id" => $idBebida,
                "nome" => $nome,
                "tipoBebida" => $tipoBebida,
                "categoria" => $categoria,
                "tamanho" => $tamanho,
                "valor" => $valor
            );

            // Adicionar bebida ao array principal
            array_push($bebidas_arr, $bebida_item);
        }

        // Retorno HTTP 200 OK
        http_response_code(200);

        // Retornar os dados em JSON
        echo json_encode($bebidas_arr);

    } else {

        // Nenhuma bebida encontrada
        http_response_code(404);

        echo json_encode(
            array("message" => "Nenhuma bebida encontrada.")
        );
    }

} else {

    // Método diferente de GET
    http_response_code(405);

    echo json_encode(
        array("message" => "Método não permitido.")
    );
}
?>