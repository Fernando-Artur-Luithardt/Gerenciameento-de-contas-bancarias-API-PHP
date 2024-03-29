<?php

require('./../../auth.php');
require('./../../banco.php');
require('./../../constantes.php');
require('./../../contaVsUsuario.php');

$receitasArr = array();
$userId = $_SESSION['usuario']['id'];
$codConta = isset($_POST['codConta'])? $_POST['codConta']: "";

if(empty($codConta)) {
    $response = array('mensagem' => "necessário codConta para listar receitas");
    $responseJson = json_encode($response);
    http_response_code(400);
    echo $responseJson;
    exit;
}

$sql = "SELECT tipoReceita, codConta, dataEntrada, dataPrevista, descricao, valor, ativo FROM `receitas` WHERE codConta = $codConta";   
$consultaReceitas = mysqli_query($conn,$sql);

while ($receitas = mysqli_fetch_array($consultaReceitas)) {
    $receitasArr[] = [
        'tipoReceita' => $tiposReceitas[$receitas['tipoReceita']],
        'codConta' => $receitas['codConta'],
        'dataEntrada' => $receitas['dataEntrada'],
        'dataPrevista' => $receitas['dataPrevista'],
        'descricao' => $receitas['descricao'],
        'valor' => $receitas['valor'],
        'ativo' => $receitas['ativo'],
    ];
}

echo json_encode($receitasArr);

?>