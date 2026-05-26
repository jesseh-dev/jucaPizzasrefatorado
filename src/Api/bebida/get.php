<?php

// CRIAÇÃO ROTA GET.PHP PARA BEBIDAS

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

// Receber o ID pela URL
$bebida->idBebida = isset($_GET['id']) ? $_GET['id'] : null;

// Verificar se o método HTTP é GET
if ($_SERVER['REQUEST_METHOD'] == 'GET')    {

    // Verificar se o ID foi informado
    if ($bebida->idBebida) {

        // Buscar a bebida
        $bebida->get();
         
        if ($bebida->nome) {
        // Criar array de resposta
        $bebida_arr = array(
            "id" => $bebida->idBebida,
            "nome" => $bebida->nome,
            "tipoBebida" => $bebida->tipoBebida,
            "categoria" => $bebida->categoria,
            "tamanho" => $bebida->tamanho,
            "valor" => $bebida->valor
        );

            http_response_code(200);
            echo json_encode($bebida_arr, JSON_PRETTY_PRINT);

         } else {
            http_response_code(404);
            echo json_encode(
                array("Mensagem" => "Bebida não encontrada.")
            );

         }

    } else {

        // ID não informado
        http_response_code(400);

        echo json_encode(
            array("message" => "ID da bebida não informado.")
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