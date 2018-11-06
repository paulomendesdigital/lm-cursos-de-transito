<?php

@ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);

//DETRAN-SE
$URL_DETRAN_SE = 'http://172.28.64.58:8089/wsIntegracaoEAD?wsdl';


set_error_handler(function ($errno, $errstr) {
    echo "<pre>Erro PHP: $errno - $errstr</pre>";
});

register_shutdown_function(function () {
    $last_error = error_get_last();
    if ($last_error) {
        echo '<table><tr><th class="h"><h2>PHP Shutdown Error</h2></th></tr><tr><td><pre>' . var_export($last_error, true) . '</pre></td></tr></table>';
    }
});

function verificaSimpleXML()
{
    $ret = class_exists('SimpleXmlElement');
    return $ret;
}

function verificaSoap()
{
    $ret = class_exists('SoapClient');
    return $ret;
}

function verificaConexao($url)
{
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_HEADER, true);
    curl_setopt($handle, CURLOPT_NOBODY, false);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
    $output   = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    $result = [$httpCode, $output];

    $ok = ($result[0] == 200);

    echo ($ok ? 'OK - ' : '') . 'HTTP Status: '  . $result[0];
    echo ' - <a href="#" onclick="$(this).next().toggle()">Detalhes</a>
     <div class="ret" style="display: none">
        Retorno:<br><pre>' . htmlentities($result[1]) . '</pre></div>';

    return $ok;
}

function verificaPortasDoServico($url)
{
    $file = file_get_contents($url);

    $xml = new SimpleXmlElement($file);

    $query = "wsdl:service/wsdl:port";
    $address = $xml->xpath($query);

    $ok = false;
    if ($address) {
        echo '<table border="1"><tr><th>Porta</th><th>URL</th><th>Status</th></tr>';
        foreach ($address as $port) {
            if (isset($port[0]['name'])) {
                echo '<tr><td>' . $port[0]['name'] . '</td>';

                $loc = $port->xpath('*[@location]');
                if (isset($loc[0]['location'])) {
                    echo '<td>' . $loc[0]['location'] . '</td><td>';
                    if (verificaConexao($loc[0]['location'])) {
                        $ok = true;
                    }
                    echo '</td>';
                } else {
                    echo '<td>Inválido</td><td>Erro</td>';
                }
                echo '</tr>';
            }
        }
        echo '</table>';
    }
    return $ok;
}

function objToArray($obj=false)  {
    if (is_object($obj))
        $obj= get_object_vars($obj);
    if (is_array($obj)) {
        return array_map(__FUNCTION__, $obj);
    } else {
        return $obj;
    }
}

function testeConsumoDetranSE($url) {

    ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);

    $arrParametrosEnvio = [
        'COD-TRANSACAO' => 431,              //  3 caracteres - Consulta Processo do Aluno
        'CPF-ALUNO'     => '55002514065',    // 11 caracteres - CPF do Aluno
        'TIPO-AULA'     => 'R',              //  1 caracter   - R = Reciclagem
        'CATEGORIA'     => ' ',              //  1 caracter   - O campo categoria deve ser informado quando o tipo-aula for P
        'CODIGO-CURSO'  => '  ',             //  2 caracteres - Deve ser informado quando o tipo de aula for E
        'CODIGO-CFC'    => 'CFC037',         //  6 caracteres - Código do CFC
    ];

    $strMensagemEnvio = implode('', $arrParametrosEnvio);

    try {
        $client = new SoapClient("http://172.28.64.58:8089/wsIntegracaoEAD?wsdl", [
            "trace"          => 1,
            "exceptions"     => true,
            "location"       => "http://172.28.64.58:8089/wsIntegracaoEAD"
        ]);

        $arguments = [
            "pUsuario"  => "DET53003",
            "pSenha"    => "LM2017",
            "pAmbiente" => 'D',
            "pMensagem" => $strMensagemEnvio,
        ];

        $result = $client->executaTransacao($arguments);

        if ($result) {
            $arrReturn = explode(' ', trim($result->executaTransacaoResult), 2);
        } else {
            $arrReturn = ['',''];
        }

        echo 'Código: ' . $arrReturn[0] . ' Mensagem: ' . $arrReturn[1] . ' - <a href="#" onclick="$(this).next().toggle()">Detalhes</a>
         <div class="ret" style="display: none">
            Retorno:<br><pre>' . var_export($result, true) . '</pre></div>';

        return !empty($result);

    } catch (Exception $exception) {
        echo 'Exception: ' . $exception->getMessage();
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <title>Teste de Comunicação Detran-SE</title>
        <style>
            body {font-size: 12px; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif}
            h1 {font-size: 24px;}
            h2 {font-size: 14px;}
            table {width: 100%; margin-bottom: 20px; border-collapse: collapse;}
            th,td {text-align: left; border: 1px solid black; padding: 4px}
            th.h {background: #ccc;}
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>

        <h1>Testes de Comunicação com DETRAN-SE</h1>

        <table>
            <tr><th class="h"><h2>Servidor</h2></th></tr>
            <tr><th>Versão do PHP: <?php echo phpversion()?></th></tr>
            <tr><th>Extensão SimpleXML : <?php echo verificaSimpleXML() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>Extensão PHP SOAP : <?php echo verificaSoap() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>HTTP_HOST: <?php echo filter_input(INPUT_SERVER, 'HTTP_HOST')?></th></tr>
        </table>

        <table>
            <tr><th class="h" colspan="2"><h2>Detran SE - Homologação e Produção</h2></th></tr>
            <tr>
                <th>Conectividade<br><?php echo $URL_DETRAN_SE?></th>
                <td><?php $ok1 = verificaConexao($URL_DETRAN_SE);?></td>
            </tr>
            <tr>
                <th>Teste SOAP Client</th>
                <td><?php testeConsumoDetranSE($URL_DETRAN_SE); ?></td>
            </tr>
        </table>
    </body>
</html>
