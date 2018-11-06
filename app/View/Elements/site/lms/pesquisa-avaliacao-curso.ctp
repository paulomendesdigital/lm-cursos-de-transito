
<div class="list-group-item media bg-grey-200 text-center" data-target="<?php echo $course['Course']['avaliation']['link_avaliation'];?>">
	<p>
		Caro (a) aluno (a), parabéns, você concluiu o seu curso! Para finalizar, pedimos a gentileza de responder o questionário a seguir. Sua opinião proporcionará a melhoria constante dos nossos serviços.
	</p>
	<p>
	    <a href="javascript:void(0);" class="btn btn-success btn-lg text-center" data-toggle="modal" data-target="#modalAvaliacao"><i class="fa fa-fw fa-asterisk"></i> Responder Agora</a>
	</p>
</div>


<div class="modal fade" id="modalAvaliacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Avaliação Institucional</h4>
            </div>
            <div class="modal-body">
                
                <?php echo $this->Form->create('PollResponse', array('action'=>'add'));?>
                	<?php $key = 0; foreach( $poll['PollQuestion'] as $question ): ?>
                		<div class="row">
                		<div class="panel panel-default paper-shadow" data-z="0.5">
                            <div class="panel-heading poll-question">
                                <h4 class=""><?php echo $question['name']; ?></h4>
                                <input type="hidden" name="data[<?php echo $key;?>][PollResponse][poll_id]" value="<?php echo $question['poll_id'];?>" />
                                <input type="hidden" name="data[<?php echo $key;?>][PollResponse][poll_question_id]" value="<?php echo $question['id'];?>" />
                                <input type="hidden" name="data[<?php echo $key;?>][PollResponse][user_id]" value="<?php echo $this->Session->read('Auth.User.id');?>" />
                            </div>
                            <div class="panel-body">
                                <p class="text-body-2"><?php //echo $question_alternative['text']; ?></p>
                                <div class="text-subhead-2 text-light"></div>
                                
                                <?php foreach ($question['PollQuestionAlternative'] as $pollQuestionAlternative):?>
                                	<div class="poll-alternatives">
                                        <input required="true" type="radio" name="data[<?php echo $key;?>][PollResponse][poll_question_alternative_id]" value="<?php echo $pollQuestionAlternative['id'];?>" />
                                        <label><?php echo $pollQuestionAlternative['name']; ?></label>
                                    </div>
								<?php endforeach;?>
                            </div>
                        </div>
                        </div>
                    <?php $key++; endforeach;?>
                    <div class="text-center bg-transparent margin-none">
	                	<button type="submit" class="btn btn-primary text-center">Enviar <i class="fa fa-fw fa-edit"></i></button>
	                </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>


                