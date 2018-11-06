<?php

@ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);

//DETRAN-SE
$URL_DETRAN_AL_CONSULTA = 'https://wsprd02.detran.al.gov.br/wsstack/services/CFCNW009?wsdl';
$URL_DETRAN_AL = 'https://wsprd02.detran.al.gov.br/wsstack/services/CFCNW020?wsdl';
$URL_DETRAN_AL_CERTIFICADO = 'https://wsprd02.detran.al.gov.br/wsstack/services/CFCNW045?wsdl';


set_error_handler(function ($errno, $errstr) {
    echo "<pre>Erro PHP: $errno - $errstr</pre>";
});

register_shutdown_function(function () {
    $last_error = error_get_last();
    if ($last_error) {
        echo '<table><tr><th class="h"><h2>PHP Shutdown Error</h2></th></tr><tr><td><pre>' . var_export($last_error, true) . '</pre></td></tr></table>';
    }
});

function verificaOpenssl()
{
    $ret = extension_loaded('openssl');
    return $ret;
}

function verificaHttpsWrapper()
{
    $w = stream_get_wrappers();
    return in_array('https', $w);
}

function verificaHttpWrapper()
{
    $w = stream_get_wrappers();
    return in_array('http', $w);
}

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
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 20);
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

function objToArray($obj=false)  {
    if (is_object($obj))
        $obj= get_object_vars($obj);
    if (is_array($obj)) {
        return array_map(__FUNCTION__, $obj);
    } else {
        return $obj;
    }
}

function testeConsumo($url) {

    ini_set('soap.wsdl_cache_enabled',0);
    ini_set('soap.wsdl_cache_ttl',0);

    try {
        $client = new SoapClient($url, [
            "trace"          => 1,
            "exceptions"     => true,
            "location"       => $url,
            'stream_context' => stream_context_create([
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ])
        ]);

        $authvar = new SoapVar([
            'exs-rpc-password' => '',
            'exx-rpc-userID'   => '',
        ], SOAP_ENC_OBJECT);

        $header = new SoapHeader('urn:com.softwareag.entirex.xml.rt', 'EntireX', $authvar);
        $client->__setSoapHeaders($header);

        $params = [
            'ENTRADA' => [
                'CPF-E'              => '22222222222',
                'CODIGO-CFC-E'       => '',
                'TIPO-CURSO-E'       => '',
                'CATEGORIA-CURSO-E'  => '',
                'CODIGO-CURSO-E'     => '',
                'MATRICULA-E'        => '95710'
            ]
        ];

        $result = $client->__soapCall("CFCNW020", [$params]);

        if ($result) {
            $result = objToArray($result);
            var_dump($result);
        }
        var_dump($client->__getLastRequest());

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
        <title>Teste de Comunicação Detran-AL</title>
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

        <h1>Testes de Comunicação com DETRAN-AL</h1>

        <table>
            <tr><th class="h"><h2>Servidor</h2></th></tr>
            <tr><th>Versão do PHP: <?php echo phpversion()?></th></tr>
            <tr><th>Extensão OpenSSL: <?php echo verificaOpenssl() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>Extensão SimpleXML : <?php echo verificaSimpleXML() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>Extensão PHP SOAP : <?php echo verificaSoap() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>Https Wrapper: <?php echo verificaHttpsWrapper() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>Http Wrapper: <?php echo verificaHttpWrapper() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>HTTP_HOST: <?php echo filter_input(INPUT_SERVER, 'HTTP_HOST')?></th></tr>
        </table>

        <table>
            <tr><th class="h" colspan="2"><h2>Detran AL - Homologação</h2></th></tr>
            <tr>
                <th>Conectividade Consulta<br><?php echo $URL_DETRAN_AL_CONSULTA?></th>
                <td><?php $ok1 = verificaConexao($URL_DETRAN_AL_CONSULTA);?></td>
            </tr>
            <tr>
                <th>Conectividade Matricula<br><?php echo $URL_DETRAN_AL?></th>
                <td><?php $ok1 = verificaConexao($URL_DETRAN_AL);?></td>
            </tr>
            <tr>
                <th>Conectividade Certificado<br><?php echo $URL_DETRAN_AL_CERTIFICADO?></th>
                <td><?php $ok1 = verificaConexao($URL_DETRAN_AL_CERTIFICADO);?></td>
            </tr>
            <tr>
                <th>Teste SOAP Client</th>
                <td><?php testeConsumo($URL_DETRAN_AL); ?></td>
            </tr>
        </table>
    </body>
</html>
