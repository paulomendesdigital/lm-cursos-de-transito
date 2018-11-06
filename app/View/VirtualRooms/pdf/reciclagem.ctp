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
            body{margin: 0px; font-family:"Open sans", Arial, sans-serif; color: #3B3636;}
            
            .left{float: left;}
            .right{ float: right;}
            .width-full{width: 100%; float: left; }
            .uppercase{text-transform: uppercase;}
            .text-center{text-align: center;}
            
            .base{ background: url('data:image/jpeg;base64,<?php echo $data['imgVersoBase64'];?>'); background-size: 100%; background-position: center top; border: 5px solid black; height: 480px; padding: 10px; position: relative;
            }

            .base .box-logo{width: 100%; display: inline-block; margin: 0 auto; text-align: center;}
            .base .box-logo .logo{width: 50%;}

            .base .box-number-certificate { margin: 10px 0 10px 0; text-align: center; font-size: 20px;}

            .base .box-text{ width: 100%; text-align: center; font-size: 12px; line-height: 1; text-align: justify;
                font-family:"Open sans", Arial, sans-serif; margin: 5px; height: 145px;
            }
            .base .box-text p{margin-top: 20px;}

	        .base .box-data{ margin: 20px 0 5px 0; text-align: center; font-size: 18px; font-weight: 700;}

            .base .box-assinaturas{ width: 740px; margin: 0px; padding: 0px; background: url('data:image/jpeg;base64,<?php echo $data['imgAssinaturasBase64'];?>'); background-position: top center; height: 145px;}

            .verso_number { line-height: 1.5; width: 100%; text-align: left; font-size: 35px; margin-bottom: 20px;}
            .verso_name_cpf { line-height: 1; width: 100%; text-align: left; font-size: 18px; margin-bottom: 20px;}
            
            .verso_description{width: 100%; text-align: left; font-size: 15px;}
            .verso_workload{width: 100%; text-align: left; font-size: 15px;}
        
            .verso_conteudo_programatico{margin-top: 20px; text-transform: uppercase;}
            .verso_conteudo_programatico ul{ font-size: 12px;list-style: none; float: left; margin: 0px; padding: 0px; line-height: 1.5;}
            .verso_footer{text-align: center;bottom: 0px;position: absolute;font-size: 14px;margin-bottom: 13px;}
            .verso_footer p.corporate_name{font-weight: 700; margin-bottom: 0px;}
            .verso_footer p.address{font-size: 12px;}

            @media print {
                #ocultar{ display: none;}
                .page-break {page-break-after: always;}
            }
            /*page{ transform: rotate(-90deg);}*/
        </style>
    </head>
    <body>

        <div class="base">

            <div class="box-logo">
                <img class="logo" src="<?php echo Configure::read('Sistems.DomainImagesCertificate');?>/img/certificate/logo.png" />
            </div>

            <div class="box-number-certificate">
                Nº <?php echo $data['certificateNumber'];?>
            </div>

            <div class="box-text">
                Certificamos que <strong class="uppercase"><?php echo $data['username'];?></strong> concluiu o <?php echo $data['courseTitle'];?>, na modalidade a distância, totalizando carga horária de <?php echo $data['workload'];?> horas, subdivididas em, <?php echo $this->Utility->__ShowModulesInCertificate($data['Modules']);?>, ofertado pelo LM Cursos de Trânsito. Realizado no período de <?php echo $this->Utility->__FormatDatePicker($data['startDate']);?> a <?php echo $this->Utility->__FormatDatePicker($data['finishDate']);?>. Obteve na avaliação final <?php echo $data['score'];?>% de acertos.

                <p class="uppercase">
                    <b>INSTRUTOR RESPONSÁVEL</b>: <?php echo $data['Instructor']['name'];?> / CPF: <?php echo $data['Instructor']['cpf'];?>
                </p>
            </div>

            <div class="box-data">
               <?php echo $data['city'];?>, <?php echo $this->Utility->__FormatDatePicker($data['finishDate']);?>.
            </div>

            <div class="box-assinaturas">
                
            </div>
        </div>

        <div class="page-break"></div>

        <div class="base">

            <div class="verso_number">
                <strong class="width-full" id="nm">Certificado nº. <?php echo $data['certificateNumber'];?></strong>
            </div>

            <div class="verso_name_cpf">
                <strong>NOME:</strong>
                <span><?php echo $data['username'];?></span><br />

                <strong>CPF:</strong>
                <span><?php echo $data['cpf'];?></span>
            </div>

            <div class="verso_description">
                <?php echo $data['description'];?>
            </div>

            <div class="verso_workload">
                CARGA HORÁRIA: <?php echo $data['workload'];?> HORAS
            </div>
            
            <div class="verso_conteudo_programatico">
                <h3>MÓDULOS DO CURSO:</h3>
                <ul>
                    <?php $i=1; foreach ($data['Modules'] as $Module):?>
                        <li>
                           <?php echo "{$i}. {$Module['module_name']}";?>
                        </li>
                    <?php $i++; endforeach;?>
                </ul>
            </div>
            
            <div class="verso_footer">
            	<p class="corporate_name"><strong><?php echo Configure::read('Sistems.CorporateName');?></strong></p>
            	<p class="address">
                	<?php echo Configure::read('Sistems.AddressForCertificate');?><br>
					CNPJ: <?php echo Configure::read('Sistems.CNPJ');?>
				</p>
            </div>
        </div>
    </body>
</html>