	        <?php
	        $html = '
	        <html>
	            <head>
	                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	                <title>Certificado - conclusão de curso</title>
	                <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet" type="text/css">
	                <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

	            <style type="text/css">
	                *{color: #3B3636;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-family: sans-serif;}

	                .base_verso{
	                    margin-top: 100px!important;
	                    background: url("http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/base_verso.png") no-repeat;
	                }
	                #parecer{
	                    float: left;
	                    color: #3B3636;
	                    width: 100%;
	                    font-size: 17px;
	                     line-height: 1;
	                    text-align: justify;
	                    font-family:"Open sans", Arial, sans-serif;
	                    padding: 0px 30px;
	                }
	                .width-full{width: 100%; float: left; font-family:"Open sans", Arial, sans-serif;}
	                #numero-certificado {
	                    margin-top: 15px;
	                    text-align: center;
	                    font-size: 20px;
	                    margin-bottom: 10px;
	                    color: #3B3636;
	                }
	                #data{
	                margin-top:40px;
	                    text-align: center;
	                    font-size: 18px;
	                    margin-bottom: 10px;
	                    color: #3B3636;
	                    font-weight: 700;
	                }

	                #assinaturas{
	                    width: 900px;;
	                    color: #848484;
	                    font-size: 15px;
	                    line-height: 1.7;
	                    margin-top: 90px;
	                }
	                .left{float: left;}
	                .right{ float: right}
	                .assinatura-left{
	                     margin-left: 90px;
	                    width: 200px;
	                    text-align: center;
	                    border-top: 1px solid #878787;
	                    padding-top: 11px;
	                    float: left;
	                    position: absolute;
	                    font-size: 14px;
	                    left: 10px;
	                    margin-top: 120px;
	                }
	                .assinatura-right{
	                    margin-right: 90px;
	                    width: 300px;
	                    text-align: center;
	                    border-top: 1px solid #878787;
	                    padding-top: 11px;
	                    float: right;
	                    position: absolute;
	                    font-size: 14px;
	                    right: 10px;
	                    margin-top: 120px;
	                }
	                .verso_number {
	                    line-height: 1.5;
	                    width: 400px;
	                }
	                strong#nm {
	                    font-size: 35px;
	                    margin-bottom: 20px;
	                      line-height: 1;
	                }
	                .aproveitamento-modulo{
	                    position: absolute;
	                    right: 10px
	                    line-height: 2.3;
	                    width: 420px;
	                    top: 30px
	                }
	                .lista-aproveitamento-modulo{
	                    float: left;
	                    list-style: none;
	                    padding: 0px;
	                    margin: 0px;
	                    height: 100px;
	                    width: 100%;
	                    line-height: 1.5
	                }
	                .lista-aproveitamento-modulo li{font-size: 13px;}
	                #conteudo-programatico{line-height: 1.2;  margin: 55px 0px 30px 0px; font-size: 15px;}

	                .lista-conteudo-programatico{margin-top: 10px;float: left;}
	                .lista-conteudo-programatico span{ margin: 10px 0px;}
	                .lista-conteudo-programatico ul{
	                    font-size: 15px;
	                    list-style: none;
	                    float: left;
	                    margin: 0px;
	                    padding: 0px;
	                    line-height: 1.9;
	                  }
	                .lista-conteudo-programatico-col-1{width: 400px;}
	                .lista-conteudo-programatico-col-2{width: 460px; position: absolute; right:20px; top: 215px;}
	                .lista-conteudo-programatico strong {font-size: 16px;}
	                #printCertificado{
	                    width: 100%;
	                    height: 640px;
	                    position: block;
	                    padding: 10px 20px;
	                    margin: 0px;
	                    border: 10px solid #333;
	                    page-break-inside: avoid;

	                }
	                #printCertificado-verso{
	                    width: 100%;
	                    height: 640px;
	                    position: relative;
	                    padding: 10px 20px;
	                    margin: 0px;
	                    border: 10px solid #333;
	                }
	                @media print {
	                    #ocultar{ display: none;}
	                    .page-break {page-break-after: always;}
	                }
	                /*page{ transform: rotate(-90deg);}*/
	            </style>
	        </head>
	        <body>
	            <div class="base" id="printCertificado">
	                <div class="width-full" style="text-align: center">
	                    <img style="width: 80%" src="http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/logo_curso_taxista.png">
	                </div>
	                <div class="width-full" id="numero-certificado">
	                    Nº $d_nota[result_id]
	                </div>

	                <div id="parecer">
		                	Certificamos que <strong style="text-transform: uppercase;">$usuario->name</strong> concluiu, com
		                	$d_nota[score]% de aproveitamento, o curso $node->title,
		                	com carga horária de $carga_horaria_total horas, realizado no período de $data_inicio a $data_fim;
	                </div>

	                <div id="data">
	                   $nome_municipio, $data_fim
	                </div>

	                <div class="assinatura-left">
	                    <img width="200" src="http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/ass_fernanda.png" style="margin-top: -125px;position: absolute;">
	                    FERNANDA SILVA PAIVA<br/>
	                    <span class="width-full">Diretora Executiva</span>
	                </div>

	                <div class="assinatura-right">
	                    <img width="300" src="http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/ass_macedo.png" style="margin-top: -99px;position: absolute;">
	                    LEANDRO MACHADO MACEDO
	                    <br/>
	                    <span class="width-full">Diretor Pedagógico</span>
	                </div>
	            </div>
	            <span></span>
	            <div class="page-break"></div>
	            <div id="printCertificado-verso">

	                <div class="verso_number left">
	                    <strong class="width-full" id="nm">Certificado nº. $d_nota[result_id]</strong>

	                    <div class="width-full">
	                        <strong>NOME:</strong>
	                        <span>$usuario->name</span>
	                    </div>

	                    <div class="width-full ">
	                        <strong>CPF:</strong>
	                        <span>webteria_custom_cpf_format($usuario->cpf)</span>
	                    </div>

	                </div>

	                <div class="width-full" id="conteudo-programatico">
		                		<strong class="width-full" style="text-transform: uppercase;">TREINAMENTO PARA TAXISTA CONFORME LEI 12468/11 E RESOLUÇÃO 456/13 DO CONTRAN</strong>

                		<br/><br/>
	                    <strong class="width-full">CARGA HORÁRIA: $carga_horaria_total HORAS</strong>
	                    <br/><br/>
	                </div>
	                <h3 style="margin-top: 20px; margin-bottom:10px; text-transform: uppercase">MÓDULOS DO CURSO</h3>
	                <div class="lista-conteudo-programatico width-full">

	                    <strong style="font-size: 18px; line-height: 1.9" class="width-full">$modulos->title</strong> <br/>
	                    <strong style="font-size: 18px; line-height: 1.9" class="width-full">$modulos->title</strong> <br/>
	                    <strong style="font-size: 18px; line-height: 1.9" class="width-full">$modulos->title</strong> <br/>

	                </div>
	                <div class="width-full" style="text-align: center;bottom: 0px;position: absolute;font-size: 14px;margin-bottom: 13px; font-weight:300px!important ">
	                	<strong style="font-weight:bold!important; margin-bottom: 5px!important">LM CURSOS DE TRÂNSITO</strong>
	                	<p style="font-weight:300px!important; margin: 0px!important">
		                	Rua Carolina Machado Nº 88, 3º andar - Cascadura, Rio de Janeiro - RJ<br>
							CNPJ: 18.657.198/0001-46
						</p>
	                </div>
	            </div>
	        </body>
	        </html>';
	        // App::import('Vendor', 'Dompdf.DOMPDF', true, array(), 'dompdf' . DS . 'dompdf_config.inc.php');

	        // $dompdf = new DOMPDF;

         //    $dompdf->load_html($html, 'UTF-8');
         //    $dompdf->set_paper('A4', 'landscape');
         //    $dompdf->render();
         //    // This does not save the pdf field and instead it opens a dialog box asking whether you have to save the pdf or not
         //    $dompdf->stream("certificado_".date('d-m-Y-H-i').".pdf",array('Attachment'=> 0));

	        echo $html;
	        ?>