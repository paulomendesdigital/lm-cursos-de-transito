<?php if( $course['Course']['avaliation']['show_certificate'] ):?>
  <div class="text-center bg-transparent margin-none">
    <p class="margin-none"><span class="fa fa-fw fa-star text-yellow-800 font-size-30"></span></p>
    <p>
    	<a href="<?php echo Router::url('/', true).'virtual_rooms/certificate/'.$this->params['pass'][0].'.pdf';?>" target="_blank" class="btn btn-success btn-lg text-center hidden-xs"><i class="fa fa-fw fa-check"></i> Clique aqui para finalizar o curso</a>
    	<a href="<?php echo Router::url('/', true).'virtual_rooms/certificate/'.$this->params['pass'][0].'.pdf';?>" target="_blank" class="btn btn-success btn-lg text-center visible-xs"><i class="fa fa-fw fa-check"></i> Finalizar Curso</a>
    </p>
    <p>
    	<?php if( isset($scheduling_link_detran) and !empty($scheduling_link_detran) ):?>
	    	<b>Clique no botão acima para que sua aprovação seja comunicada ao DETRAN RJ.</b><br />
	   		Após a comunicação, você estará apto para realizar o agendamento da prova presencial.<br />
			<a href="<?php echo $scheduling_link_detran;?>" class="btn btn-primary" target="_blank">
				AGENDAR PROVA PRESENCIAL
			</a>
		<?php endif;?>
    </p>
  </div>
<?php endif;?>