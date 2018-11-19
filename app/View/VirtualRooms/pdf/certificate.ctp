<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Certificado View
 *
*/?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Certificado - conclusão de curso</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet" type="text/css">

	    <style type="text/css">
	        *{color: #3B3636;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;font-family: sans-serif;}
            body{margin: 0px;}
            .base{
                /* background: url('data:image/jpeg;base64,<?php echo $data['imgVersoBase64'];?>') no-repeat;
                background-size: 80%;*/
                border: 5px solid black;
            }


	        .base_verso{
	            margin-top: 100px!important;
	            /*background: url("http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/base_verso.png") no-repeat;*/
                background: url("<?php echo Router::url('/', true);?>img/certificate/base_verso.png") no-repeat;
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
            .right{ float: right;}
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
                margin-top: 0;
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
                right: 10px;
                line-height: 2.3;
                width: 420px;
                top: 30px;
            }
            .lista-aproveitamento-modulo{
                float: left;
                list-style: none;
                padding: 0px;
                margin: 0px;
                height: 100px;
                width: 100%;
                line-height: 1.5;
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
                /* width: 100%;
                height: 640px;
                position: block;
                padding: 10px 20px;
                margin: 0px;
                border: 10px solid #333;
                page-break-inside: avoid; */
            }
            #printCertificado-verso{
                /* width: 100%;
                height: 640px;
                position: relative;
                padding: 10px 20px;
                margin: 0px;
                border: 10px solid #333; */
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
                <img style="width: 50%" src="http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/logo_curso_taxista.png">
            </div>
            <div class="width-full" id="numero-certificado">
                Nº <?php echo $data['certificateNumber'];?>
            </div>

            <div id="parecer">
            	Certificamos que <strong style="text-transform: uppercase;"><?php echo $data['username'];?></strong> concluiu, com <?php echo $data['score'];?>% de aproveitamento, o curso <?php echo $data['courseTitle'];?>,
                	com carga horária de <?php echo $data['workload'];?> horas, realizado no período de <?php echo $this->Utility->__FormatDatePicker($data['startDate']);?> a <?php echo $this->Utility->__FormatDatePicker($data['finishDate']);?>
            </div>

            <div id="data">
               <?php echo $data['city'];?>, <?php echo $this->Utility->__FormatDatePicker($data['finishDate']);?>
            </div>

            <div class="assinatura-left">
                <img width="200" src="http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/ass_fernanda.png" style="margin-top: -125px;position: absolute;">
                FERNANDA SILVA PAIVA<br/>
                <span class="width-full">Diretora Executiva</span>
            </div>

            <div class="assinatura-right">
                <img width="300" src="http://lmcursosdetransito.com.br/sites/all/themes/lm_ctransito/imgs/ass_macedo.png" style="margin-top: -100px;position: absolute;">
                LEANDRO MACHADO MACEDO<br/>
                <span class="width-full">Diretor Pedagógico</span>
            </div>
        </div>

        <div class="page-break"></div>

        <div id="printCertificado-verso">

            <div class="verso_number left">
                <strong class="width-full" id="nm">Certificado nº. <?php echo $data['certificateNumber'];?></strong>

                <div class="width-full">
                    <strong>NOME:</strong>
                    <span><?php echo $data['username'];?></span>
                </div>

                <div class="width-full ">
                    <strong>CPF:</strong>
                    <span><?php echo $data['cpf'];?></span>
                </div>

            </div>

            <div class="width-full" id="conteudo-programatico">
                <strong class="width-full" style="text-transform: uppercase;">
                	<?php $data['description'];?>
            	</strong>
        		<br/><br/>
                <strong class="width-full">
                	CARGA HORÁRIA: <?php echo $data['workload'];?> HORAS
            	</strong>
                <br/><br/>
            </div>
            <h3 style="margin-top: 20px; margin-bottom:10px; text-transform: uppercase">MÓDULOS DO CURSO</h3>
            <div class="lista-conteudo-programatico width-full">
                <?php foreach ($data['Modules'] as $Module):?>
                    <strong style="font-size: 18px; line-height: 1.9" class="width-full">
                	   <?php echo $Module['module_name'];?>
        		    </strong> <br/>
                <?php endforeach;?>
            </div>
            <div class="width-full" style="text-align: center;bottom: 0px;position: absolute;font-size: 14px;margin-bottom: 13px; font-weight:300px!important ">
            	<strong style="font-weight:bold!important; margin-bottom: 5px!important">LM CURSOS DE TRÂNSITO</strong>
            	<p style="font-weight:300px !important; margin: 0px!important">
                	Rua Carolina Machado Nº 88, 3º andar - Cascadura, Rio de Janeiro - RJ<br>
					CNPJ: 18.657.198/0001-46
				</p>
            </div>
        </div>
    </body>
</html>