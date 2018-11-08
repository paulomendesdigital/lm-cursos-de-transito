<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuemSomos View
 *
*/ ?>
<div id='who-we-are' class='page'>
	<div class='container'>
		<div class='box-who-we-are box-grey big-box col-md-12'>
			<span class='description'>
                
                <h2 class="text-center"><b>Nº do Certificado:</b> <?php echo str_pad($user['UserCertificate'][0]['id'], 6, '0', STR_PAD_LEFT); ?></h2>
                <br>

                <div class="col-md-6">
                    <b>Nome:</b> <?php echo ucwords($user['User']['name']); ?>
                </div>
                
                <div class="col-md-6">
                    <b>CPF:</b> <?php echo $user['User']['cpf']; ?>
                </div>
                
                <br>
                <br>

                <div class="col-md-6">
                    <b>Início Curso:</b> <?php echo date('d/m/Y', strtotime($user['UserCertificate'][0]['start'])); ?>
                </div>
                
                <div class="col-md-6">
                    <b>Término Curso:</b> <?php echo date('d/m/Y', strtotime($user['UserCertificate'][0]['finish'])); ?>
                </div>

			</span>																	
		</div>
	</div>
</div>