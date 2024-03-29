<?php
require('./../../auth.php'); //verifica se está logado
require('./../../banco.php');
require('./../../contaVsUsuario.php');

$userId = $_SESSION['usuario']['id'];
$codConta = isset($_POST['codConta'])? $_POST['codConta']: "";
$idReceita = isset($_POST['idReceita'])? $_POST['idReceita']: "";

//validar se conta pertence ao usuario logado
$sql = "SELECT * FROM `conta` WHERE userId = '$userId' AND codConta = $codConta";
$contaVsUsuario = mysqli_query($conn, $sql);

//validar se receita pertence ao usuário logado
$sql = "SELECT * FROM `receitas` WHERE userId = '$userId' AND contaId = $codConta AND id = '$idReceita'";
$contaVsUsuario = mysqli_query($conn, $sql);

if (mysqli_num_rows($contaVsUsuario)==0) {
    $response = array('mensagem' => "receita não pertence a conta selecionada");
    $responseJson = json_encode($response);
    http_response_code(400);
    echo $responseJson;
    exit;
}

$sql = "DELETE from `receitas` WHERE userId = '$userId' AND contaId = $codConta AND id = '$idReceita'";

if (mysqli_query($conn,$sql)) {
    http_response_code(204);
    exit;
}

$response = array('mensagem' => "Erro ao deletar receita");
$responseJson = json_encode($response);
http_response_code(400);
echo $responseJson;
exit;

?>