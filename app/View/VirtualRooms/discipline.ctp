<?php $block_count_downt_time = false;?>
<?php $get_num_content = isset($this->params['pass'][2])?$this->params['pass'][2]:0;?>
<div class="container">
	<div class="page-section">
		<div class="row">
			<div class="col-md-12">
				<p class="text-light text-caption">
					<i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'meus-cursos', 'action' => 'index']); ?>
					<i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link($course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]]); ?>
					<i class="fa fa-fw  fa-angle-right"></i><?php echo $module_discipline['Module']['name'];?> 
				</p>
				<div class="page-section padding-top-none">
					<div class="media v-middle">
					    <div class="media-body">
					        <h1 class="text-display-1 margin-none title-unidade-page">
					        	<?php echo $module_discipline['Module']['name'];?>
					        	<input type="hidden" id="token" value="<?php echo $token;?>" /> 
					        	<small>
					        		<?php echo $module_discipline['ModuleDiscipline']['name'];?> <br /> 
					        	</small>
				        	</h1>
					        <p class="text-subhead"></p>
					        <?php if( !$module_discipline['Module']['is_introduction'] and $module_discipline['ModuleDiscipline']['value_time'] > 0 ):?>
						        <h4 class="text-left text-light"><i class="fa fa-fw fa-clock-o"></i>Carga Horária da Unidade: <?php echo $module_discipline['ModuleDiscipline']['value_time'];?>h</h4>
						    <?php endif;?>
					    </div>
					</div>
				</div>
			</div>
		</div>

	    <div class="row">
	    	<div class="col-md-8">
	    		<?php /** CONTEUDO EM SLIDE **/ ?>

				<?php $t_slider = count($module_discipline['ModuleDisciplineSlider']); ?>
				<?php if($t_slider > $get_num_content):?>
					<?php if($module_discipline['ModuleDisciplineSlider'][$get_num_content]['UserModuleLog']):$block_count_downt_time = true;endif;?>
		            <div class="panel panel-default">
					  <div class="panel-heading panel-heading-gray">
					     <div class="media">
					     	<!-- <div class="col-md-12 text-center hidden-md hidden-sm hidden-lg">
					           <span class="icon-block img-circle half"><?php //echo $get_num_content+1;?></span>
					        </div>
					        <div class="col-md-12 text-left hidden-xs">
					           <span class="icon-block img-circle half"><?php //echo $get_num_content+1;?></span>
					        </div> -->
					        <div class="media-body slide">
		        				<h4 class="text-headline">
		        					<span class="icon-block img-circle half"><?php echo $get_num_content+1;?></span>
		        					<?php echo $module_discipline['ModuleDisciplineSlider'][$get_num_content]['name'];?>
		        				</h4>
			           			<div class="slide-content">
			           				<?php echo $module_discipline['ModuleDisciplineSlider'][$get_num_content]['text'];?>
			           			</div>
					        </div>
					     </div>
					  </div>
					</div>
				<?php endif;?>

				<?php /** CONTEUDO EM VÍDEO **/ ?>

				<?php $t_player = count($module_discipline['ModuleDisciplinePlayer']); ?>
				<?php if($t_player > $get_num_content):?>
					<?php if($module_discipline['ModuleDisciplinePlayer'][$get_num_content]['UserModuleLog']):$block_count_downt_time = true;endif;?>
		            <div class="panel panel-default">
					  <div class="panel-heading panel-heading-gray">
					     <div class="media">
					        <div class="media-left">
					           <span class="icon-block img-circle half"><?php echo $get_num_content+1;?></span>
					        </div>
					        <div class="media-body">
					           <h4 class="text-headline"><?php echo $module_discipline['ModuleDisciplinePlayer'][$get_num_content]['name'];?></h4>
					           <div class="row">
					           	<div class="col-md-10">
				           			<div class="responsive-video"><?php echo $module_discipline['ModuleDisciplinePlayer'][$get_num_content]['embed_player'];?></div> 
					           	</div>
					           </div>
					        </div>
					     </div>
					  </div>
					</div>
				<?php endif;?>
	    	</div>
	    	<div class="col-md-4">
	    		<div class="panel panel-default">
	    			<div class="panel-heading panel-heading-gray">
					    <div class="media">
				        	<div class="media-body">
				        		<?php if(isset($module_discipline['ModuleDisciplineSlider'][$get_num_content]['audio'])):?>
				    				<h5 class="text-subhead-2 text-light">
				    					<b><i class="fa fa-file-audio-o fa-fw"></i> Disponível em audio:</b>
				    				</h5>
			    	    			<?php echo $this->Utility->playerMp3($module_discipline['ModuleDisciplineSlider'][$get_num_content]['audio'], 'module_discipline_slider/audio/'.$module_discipline['ModuleDisciplineSlider'][$get_num_content]['id'].'/');?>
				        			<hr/>
				        		<?php endif;?>

				        		<h5 class="text-subhead-2 text-light"><b><i class="fa fa-clock-o fa-fw"></i> Carga horária de estudo:</b></h5>
				        		<div class="progress">
	                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
	                            </div>
	                            <div class="text-light text-caption" id="countdown">
									<span id="revese-countdown">Faltam <?php echo $course['Course']['min_time'];?> segundos mínimos.</span>
							    </div>

							    <hr/>
							    <h5 class="text-subhead-2 text-light"><b><i class="fa fa-folder-open fa-fw"></i> Material de estudo:</b></h5>
							    <ul class="slide-pagination pagination margin-top-none">

							    	<?php echo $this->Utility->__showPaginationSliderOrPlayer($module_discipline, $get_num_content ,$t_slider, 'ModuleDisciplineSlider');?>

							    	<?php echo $this->Utility->__showPaginationSliderOrPlayer($module_discipline, $get_num_content ,$t_slider, 'ModuleDisciplinePlayer');?>

				                </ul>
				                <div class="col-md-12">
				                	<?php echo $this->Html->link('Voltar para listagem dos módulos', ['action'=>'course',$this->params['pass'][0]],['class'=>'btn btn-warning btn-block']);?>
				                </div>
				        	</div>
			        	</div>
		        	</div>
	    		</div>
	    		
	    		<div class="panel panel-default">
	    			<div class="panel-heading panel-heading-gray">
	    				<div class="media">
				        	<div class="media-body">
	    						<h5 class="text-subhead-2 text-light margin-bottom-0">Próximos Módulos</h5>
          						
          						<?php echo $this->Element('site/lms/modules-col-right', ['course'=>$course, 'modules'=>$modules, 'poll'=>$poll]);?>

	    					</div>
	    				</div>
	    			</div>
	    		</div>

	    		<div class="panel panel-default">
	    			<div class="panel-heading panel-heading-gray">
	    				<div class="media">
				        	<div class="media-body">
	    						<h5 class="text-subhead-2 text-light">Meu bloco de anotações</h5>
							    <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
							        <div class="panel-body list-group">
							        	<div class="list-group list-group-menu">
								            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#formNotepadModal">
								             	<i class="fa fa-fw fa fa-edit"></i> Abrir
								            </button>
								        </div>
							        </div>
							    </div>
	    					</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	</div>
</div>

<script>
	 $(document).ready(function(){
	 	$('.slide-content img').each(function(){
	 		$(this).addClass('img-responsive width-full');
	 		//$(this).attr('style','width: 100%; height: 100%;');
	 	});
	 	//$('.slide-content img').addClass('img-responsive');
	 });
</script>

<?php if($block_count_downt_time === false && ($t_slider OR $t_player)):?>

	<script type="text/javascript">
		var count = <?php echo $course['Course']['min_time'];?>;
	    var fator = count*1666;
		$('#revese-countdown')
		  .prop('number', count)
		  .animateNumber({
		      number: 0,
		      numberStep: function(now, tween) {
		        var target = $(tween.elem),
		        	rounded_now = Math.round(now);
		        	newprogress = Math.round(rounded_now*(100/rounded_now));
		        	console.log(tween.end);
		        	console.log(now);

		        target.text(now === tween.end ? '' : 'Faltam '+rounded_now+' segundos mínimos.');
		        if(now === tween.end){
		        	 $('#countdown').html('<span class="text-green-300"><i class="fa fa-check fa-fw"></i> Carga horária completa!</span>');
					 $('.progress').remove();
		        	 send_log();
		        }else{
	        	// $('#theprogressbar').attr('aria-valuenow', newprogress).css('width',newprogress);
		        }
		      }
		    },
		    fator,
		    'linear'
		);

		function send_log(){
			var slide_id = '<?php echo isset($module_discipline['ModuleDisciplineSlider'][$get_num_content]['id'])?$module_discipline['ModuleDisciplineSlider'][$get_num_content]['id']:0;?>';
			var player_id = '<?php echo isset($module_discipline['ModuleDisciplinePlayer'][$get_num_content]['id'])?$module_discipline['ModuleDisciplinePlayer'][$get_num_content]['id']:0;?>';
			 $.ajax({
		        type: 'POST',
		        url: "<?php echo $this->Html->url(array('controller' => 'virtual_rooms','action' => 'user_module_logs', $this->params['pass'][0], $this->params['pass'][1])); ?>",
		        datatype:'json',
		        cache: false,
		        data: {
		        	'is_slider_id': slide_id,
		        	'is_player_id': player_id
		        },
		        success: function(){
		        	document.location.reload(true);
		        },
		        error: function(){}
		    });
		}

		// Contagem regressiva barra
		var i = 100;
		var fator_i = i/count;
		var counterBack = setInterval(function(){
		  i = i-fator_i;
		  if(i>0){
		  	$('div[role="progressbar"]').attr('aria-valuenow', i);
	    	$('div[role="progressbar"]').attr('style', 'width: '+i+'%;'); 
		  } else {
		    clearTimeout(counterBack);
		  }
		}, 1666);
	</script>
<?php else:?>
	<script type="text/javascript">
		$('#countdown').html('<span class="text-green-300"><i class="fa fa-check fa-fw"></i> Estudo do slide registrado!</span>');
		$('.progress').remove();
	</script>
<?php endif;?>
<script src="//api.handtalk.me/plugin/latest/handtalk.min.js"></script>
<script>
  var ht = new HT({
    token: "9e7ceda432a7b5945f3422a319a8e2d3"
  });
</script>

<?php if( $course['Course']['face_recognition'] ):?>
  <script>
    if( $('#token').length ){
      var tokenCourse = $('#token').val();
      setInterval( 'changeBiometria(tokenCourse)', <?php echo Configure::read('Sistems.TimeForBiometriaFacial');?>);
    }
  </script>
<?php endif;?>