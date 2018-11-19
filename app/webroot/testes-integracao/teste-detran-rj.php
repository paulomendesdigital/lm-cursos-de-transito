<?php

@ini_set('display_errors', 'On');
error_reporting(E_ALL ^ E_NOTICE);

$URL_DETRAN_RJ_HOMOLOG = 'http://10.200.180.70:8080/wsstack/services/ENSINODI.wsdl';
$PASSWORD_DETRAN_RJ_HOMOLOG = 'COENSILM';

$URL_DETRAN_RJ      = 'http://10.200.180.71:8080/wsstack/services/ENSINODI.wsdl';
$PASSWORD_DETRAN_RJ = '6nVdgjNY';


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

function testeConsumoDetranRJ($url, $password) {

    $cpf       = '55002514065';
    $renach    = 'RJ123456789';
    $categoria = 'B';

    try {

        ini_set('soap.wsdl_cache_enabled',0);
        ini_set('soap.wsdl_cache_ttl',0);

        $client = new SoapClient($url, array(
            "trace"          => 1,
            "exceptions"     => true,
            "stream_context" => stream_context_create(
                array(
                    'ssl' => array(
                        'verify_peer'      => false,
                        'verify_peer_name' => false,
                    )
                )
            )
        ));

        $authvar = new SoapVar(
            array('exx-natural-security' => 'TRUE',
                  'exx-natural-library'  => 'LIBBRK',
                  'exx-rpc-userID'       => 'COENSILM',
                  'exx-rpc-password'     => $password
            ),
            SOAP_ENC_OBJECT);

        $header = new SoapHeader('urn:com.softwareag.entirex.xml.rt', 'EntireX', $authvar);

        $client->__setSoapHeaders($header);

        $arguments = array(
            'PARTE-FIXA'     => str_pad(date('H') . date('i') . date('s'), 6, '0', STR_PAD_LEFT) . '6304COENSILM   RJRJRJ0045 ' . date('z'),
            'PARTE-VARIAVEL' => array(
                0 => $cpf . '1' . $renach . '0' . 22 . date('d') . date('m') . date('Y') . 'RJ51970' . $categoria
            )
        );

        $result = $client->__soapCall("GTRN0003", array("parameters" => $arguments), null);

        if ($result) {
            $result = objToArray($result);

            if (isset($result['PARTE-VARIAVEL']['string']) && is_array($result['PARTE-VARIAVEL']['string'])) {
                $parteVariavel = explode(' ', $result['PARTE-VARIAVEL']['string'][0]);
            } elseif (isset($result['PARTE-VARIAVEL']['string']) && is_string($result['PARTE-VARIAVEL']['string'])) {
                $parteVariavel = explode(' ', $result['PARTE-VARIAVEL']['string']);
            } else {
                $parteVariavel = ['Não encontrado'];
            }

            $codigo = 'Código Retorno: ' . $parteVariavel[0];
        } else {
            $codigo = '';
        }

        echo $codigo . ' - <a href="#" onclick="$(this).next().toggle()">Detalhes</a>
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
        <title>Teste de Comunicação Detran-RJ</title>
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

        <h1>Testes de Comunicação com DETRAN-RJ</h1>

        <table>
            <tr><th class="h"><h2>Servidor</h2></th></tr>
            <tr><th>Versão do PHP: <?php echo phpversion()?></th></tr>
            <tr><th>Extensão SimpleXML : <?php echo verificaSimpleXML() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>Extensão PHP SOAP : <?php echo verificaSoap() ? 'OK' : 'Não Instalado';?></th></tr>
            <tr><th>HTTP_HOST: <?php echo filter_input(INPUT_SERVER, 'HTTP_HOST')?></th></tr>
        </table>

        <table>
            <tr><th class="h" colspan="2"><h2>Detran RJ - Homologação</h2></th></tr>
            <tr>
                <th>Conectividade<br><?php echo $URL_DETRAN_RJ_HOMOLOG?></th>
                <td><?php $ok1 = verificaConexao($URL_DETRAN_RJ_HOMOLOG);?>
            <tr>
                <th>Conectividade - Service Ports</th>
                <td><?php if ($ok1) { $ok2 = verificaPortasDoServico($URL_DETRAN_RJ_HOMOLOG); } else { $ok2 = false; echo 'Não foi possível conectar.';}?></td>
            </tr>
            <tr>
                <th>Teste SOAP Client</th>
                <td><?php testeConsumoDetranRJ($URL_DETRAN_RJ_HOMOLOG, $PASSWORD_DETRAN_RJ_HOMOLOG); ?></td>
            </tr>
        </table>

        <table>
            <tr><th class="h" colspan="2"><h2>Detran RJ - Produção</h2></th></tr>
            <tr>
                <th>Conectividade<br><?php echo $URL_DETRAN_RJ?></th>
                <td><?php $ok1 = verificaConexao($URL_DETRAN_RJ);?>
            <tr>
                <th>Conectividade - Service Ports</th>
                <td><?php if ($ok1) { $ok2 = verificaPortasDoServico($URL_DETRAN_RJ); } else { $ok2 = false; echo 'Não foi possível conectar.';}?></td>
            </tr>
            <tr>
                <th>Teste SOAP Client</th>
                <td><?php testeConsumoDetranRJ($URL_DETRAN_RJ, $PASSWORD_DETRAN_RJ); ?></td>
            </tr>
        </table>
    </body>
</html>
