<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Pizza.php';

// Instanciar o banco de dados e conectar
$database = new Database();
$db = $database->getConnection();

// Instanciar o objeto Pizza
$pizza = new Pizza($db);

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    try {

        // Obter os dados enviados
        $data = json_decode(file_get_contents("php://input"));

        // Verificar se o ID foi informado
        if (!empty($data->id)) {

            // Atribuir o ID
            $pizza->idPizza = $data->id;


        // Verificar se a pizza existe
        $pizza->get();

        if ($pizza->nome == null) {

        http_response_code(404);

        echo json_encode(
        array('Mensagem' => 'ID não existente')
        );

        exit;
    }

            // Tentar excluir
            if ($pizza->delete()) {

                http_response_code(200);

                echo json_encode(
                    array('Mensagem' => 'Pizza deletada com sucesso')
                );

            } else {

                http_response_code(500);

                echo json_encode(
                    array('Mensagem' => 'Não foi possível deletar a pizza')
                );
            }

        } else {

            // ID não informado
            http_response_code(400);

            echo json_encode(
                array('Mensagem' => 'ID da pizza não informado')
            );
        }

    } catch (Exception $e) {

        http_response_code(500);

        echo json_encode(
            array('Erro' => $e->getMessage())
        );
    }

} else {

    http_response_code(405);

    echo json_encode(
        array('Erro' => 'Método não suportado!')
    );
}

?>