<?php 
$note = 100;
$qt_questions = count($questions['QuestionAlternative']);
$qt_questions = isset($qt_questions)?$qt_questions:1;
$note_question = round($note / $qt_questions);
$limite_time = $course['Course']['max_time_module_avaliation']; 
?>
<input type="hidden" name="questoes_restantes" />
<div class="page-section half bg-white fixed-bar-simulated">
    <div class="container">
        <div class="section-toolbar">
            <div class="col-md-4 col-xs-6">
                <div class="cell">
                    <div class="media width-100 v-middle margin-none">
                        <div class="media-left">
                            <div class="icon-block bg-grey-200 s25"><i class="fa fa-question"></i></div>
                        </div>
                        <div class="media-body">
                            <p class="text-body-2 text-light margin-none">Questões</p>
                            <p class="text-title text-primary margin-none qt_questions">
                                <?php echo $qt_questions;?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-6">
                <div class="cell">
                    <div class="media width-110 v-middle margin-none">
                        <div class="media-left">
                            <div class="icon-block bg-grey-200 s25"><i class="fa fa-diamond"></i></div>
                        </div>
                        <?php if($course['Course']['value_module_avaliation']): ?>
                        <div class="media-body">
                            <p class="text-body-2 text-light margin-none">Nota Min.</p>
                            <p class="text-title text-primary margin-none"><?php echo number_format($course['Course']['value_module_avaliation'], 0);?>%</p>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if($course['Course']['max_time_module_avaliation']): ?>
                <div class="col-md-4 col-xs-12" style="margin-top: 10px;">
                    <div class="cell">
                        <div class="media width-110 v-middle margin-none">
                            <div class="media-left">
                                <div class="icon-block bg-grey-200 s25"><i class="fa fa-clock-o"></i></div>
                            </div>
                            <?php if($course['Course']['value_module_avaliation']): ?>
                            <div class="media-body">
                                <input type="hidden" name="time" value="<?php echo $limite_time;?>">
                                <div class="hidden" id="revese-countdown"></div>
                                <!-- <p class="text-body-2 text-light margin-none">Finalizar</p> -->
                                <p class="text-title text-primary margin-none tk-countdown"></p>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</div>

<div class="split-vertical-body avaliation-body">
    <div class="split-vertical-cell">
        <div class="container height-100pc">
            <div class="page-section height-100pc">
                <div class="row height-100pc">
                    <div class="col-md-12">

                    <p class="text-light text-caption">
                        <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'meus-cursos', 'action' => 'index']); ?>
                        <i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link($course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]],['id'=>'link-course']); ?>
                        <i class="fa fa-fw  fa-angle-right"></i> Avaliação do módulo
                      </p>

                    <div class="page-section padding-top-none">
		                <div class="media v-middle">
		                    <div class="media-body">
		                        <h1 class="text-display-1 margin-none"> Avaliação de módulo
		                        <small> - <?php echo $questions['Module']['name'];?></small></h1>
		                        <p class="text-subhead"></p>
		                    </div>
		                </div>
		            </div>

                    <?php echo $this->Form->create('QuestionAlternativeOptionUser', array('url' => array('controller' => 'virtual_rooms', 'action' => 'question_alternative_option_users',$this->params['pass'][0], $this->params['pass'][1])));?>
                        
                        <?php foreach ($questions['QuestionAlternative'] as  $key => $question_alternative):?>
                        	<?php echo $this->Form->input($key.'.QuestionAlternativeOptionUser.question_alternative_id', ['type' => 'hidden' ,'value' => $question_alternative['id']]);?>

	                        <div class="panel panel-default paper-shadow" data-z="0.5">
	                            <div class="panel-heading">
	                                <h4 class="text-headline">Pergunta <?php echo $key+1; ?></h4>
	                            </div>
	                            <div class="panel-body">
	                                <p class="text-body-2"><?php echo $question_alternative['text']; ?></p>

	                                <div class="text-subhead-2 text-light">Responda</div>

	                                <input type="hidden" name="data[<?php echo $key;?>][QuestionAlternativeOptionUser][question_alternative_option_id]" id="<?php echo $key;?>QuestionAlternativeOptionUserQuestionAlternativeOptionId_" value="">
	                                <?php foreach ($question_alternative['QuestionAlternativeOption'] as $question_alternative_option):?>
	                                	<div class="radio radio-primary">
	                                        <input required="required" data-id="data_<?php echo $key;?>_QuestionAlternativeOptionUser_question_alternative_option_id" type="radio" name="data[<?php echo $key;?>][QuestionAlternativeOptionUser][question_alternative_option_id]" id="radio<?php echo $key;?><?php echo $question_alternative_option['id'];?>" value="<?php echo $question_alternative_option['id'];?>">
	                                        <label for="radio<?php echo $key;?><?php echo $question_alternative_option['id'];?>"><?php echo $question_alternative_option['name']; ?></label>
	                                    </div>
									<?php endforeach;?>
	                            </div>
	                        </div>
                		<hr/>
                		<?php endforeach; ?>
                		<div class="text-right">
                            <button type="submit" disabled="disabled" class="btn btn-success"><i class="fa fa-save fa-fw"></i> Salvar avaliação</button>
                        </div>
                        <div class="text-right text-danger">
                			<small><i class="fa fa-warning"></i> O botão ativará assim que responder todas as questões!</small>
                		</div>
            		<?php echo $this->Form->end();?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if( $limite_time ): ?>
<script type="text/javascript">
    var count = <?php echo $limite_time*60;?>;
    var fator = count*1666;

    $('#revese-countdown---')
      .prop('number', count)
      .animateNumber(
        {
          number: 0,
          numberStep: function(now, tween) {
            var target = $(tween.elem),
                rounded_now = Math.round(now);

            target.text(rounded_now+' s');
            if(now === tween.end){
                 send_log();
            }
          }
        },
        fator,
        'linear'
      );
     function send_log(){
        $('button[type="submit"]').attr('disabled', 'disabled');

        var is_confirm = confirm('Sua avaliação não é mais válida. Você ultrapassou o tempo permitido para responder! Quer iniciar uma nova avaliação?');
        if(is_confirm){
            location.reload();
        }
     }
</script>
<?php endif; ?>
<script>
$(document).ready(function(){
    var qt_questions = <?php echo $qt_questions;?>;
    var cont = 0;
    var data = new Array();
    var questoes_restantes = qt_questions;

    //zero os radios se der reload na pagina
    $('input[type="radio"]').prop('checked', false);
    $('input[type="radio"]').on('change',function (e){
        var item = $(this).attr('data-id');
        var aLength = data.length;
        var isExists = false;
        
        for (var i=0; i < aLength; i++) {
            if( item == data[i] ){
                isExists = true;
            }
        }
        if( !isExists ){
            data[cont] = item;
            cont++;
        }
        questoes_restantes = qt_questions - data.length;
        
        $('.qt_questions').text( questoes_restantes );
        
        if( questoes_restantes == 0 ){
            $('button[type="submit"]').attr('disabled', false);
        }
    });
});
</script>