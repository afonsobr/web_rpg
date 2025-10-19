<?php
// send_message.php
// Envia um POST JSON para o endpoint informado usando cURL.

$endpoint = 'https://api.centraldeautorizacao.site:8443/send-message-via-bot?port=1785';

function gerarStringAleatoria($tamanho = 10)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $stringAleatoria = '';
    $max = strlen($caracteres) - 1; // Calcula o índice máximo para não ocorrer erro
    for ($i = 0; $i < $tamanho; $i++) {
        $stringAleatoria .= $caracteres[mt_rand(0, $max)]; // Adiciona um caractere aleatório à string
    }
    return $stringAleatoria;
}

// echo gerarStringAleatoria(15); // Gerar uma string com 15 caracteres

// Monta o payload conforme você mandou
$payload = [
    "botCode" => "BotAnun1wp",
    "message" => "*Formulário Preenchido:*\nID da Página: " . strtoupper(gerarStringAleatoria(10)) . "\n`Nomecompleto`: " . gerarStringAleatoria(mt_rand(1, 15)) . "\n`Data nascimento`: " . rand(1990, 2025) . "-" . rand(10, 12) . "-" . rand(10, 12) . "\n`Cpf`: " . rand(11111111111, 99999999999) . "\n`Email`: " . gerarStringAleatoria(mt_rand(1, 15)) . "@hotmail.com\n`Telefone`: 9" . rand(11111111, 99999999) . "\n`Dados bancarios`: Banco do Brasil\n`Recebimento pix`: CPF\n`Chave pix`: " . rand(11111111111, 99999999999) . "\n",
    "recipientNumber" => "120363404285270868@g.us"
];

var_dump($payload);

// Converte para JSON
$json = json_encode($payload, JSON_UNESCAPED_UNICODE);

if ($json === false) {
    echo "Erro ao gerar JSON: " . json_last_error_msg() . PHP_EOL;
    exit(1);
}

// Inicializa cURL
$ch = curl_init($endpoint);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json)
    ],
    CURLOPT_TIMEOUT => 15,   // timeout em segundos
    CURLOPT_CONNECTTIMEOUT => 10,
]);

// Se o servidor usar certificado autoassinado e você quiser permitir (não recomendado em produção),
// descomente as próximas duas linhas:
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// Tratamento da resposta
if ($curlError) {
    echo "cURL error: {$curlError}" . PHP_EOL;
    exit(1);
}

echo "HTTP Status: {$httpCode}" . PHP_EOL;
echo "Response: " . PHP_EOL . $response . PHP_EOL;

// Se quiser decodificar JSON de resposta:
// $respData = json_decode($response, true);
// var_export($respData);

?>
<script>
    setTimeout(() => {
        location.reload()
    }, 1);
</script>