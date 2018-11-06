<?php if(isset($userQuestion['UserQuestionOption'])): ?>
    <?php $nota_minima = number_format($course['Course']['value_module_avaliation'], 0);?>
    <?php $nota = number_format($userQuestion['UserQuestion']['value_result'], 0);?>

    <div class="page-section half bg-white">
        <div class="container">
            <div class="section-toolbar">
                <div class="cell">
                    <div class="media width-100 v-middle margin-none">
                        <div class="media-left">
                            <div class="icon-block bg-grey-200 s25"><i class="fa fa-question"></i></div>
                        </div>
                        <div class="media-body">
                            <p class="text-body-2 text-light margin-none">Questões</p>
                            <p class="text-title text-primary margin-none"><?php echo count($userQuestion['UserQuestionOption']);?></p>
                        </div>
                    </div>
                </div>
                
                <div class="cell">
                    <div class="media width-110 v-middle margin-none">
                        <div class="media-left">
                            <div class="icon-block bg-grey-200 s25"><i class="fa fa-diamond"></i></div>
                        </div>
                        <?php if($course['Course']['value_module_avaliation']): ?>
                        <div class="media-body">
                            <p class="text-body-2 text-light margin-none">Nota Min.</p>
                            <p class="text-title text-primary margin-none"><?php echo $nota_minima;?> %</p>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>

                <div class="cell">
                    <div class="media width-110 v-middle margin-none">
                        <div class="media-left">
                            <?php if( $nota >= $nota_minima ):?>
                                <div class="icon-block bg-green-200 s25"><i class="fa fa-smile-o"></i></div>
                            <?php else:?>
                                <div class="icon-block bg-red-200 s25"><i class="fa fa-frown-o"></i></div>
                            <?php endif;?>
                        </div>
                        <?php if($userQuestion['UserQuestion']['value_result']): ?>
                            
                            <div class="media-body">
                                <p class="text-body-2 text-light margin-none">Minha Nota</p>
                                <p class="text-title text-primary margin-none"><?php echo $nota;?> %</p>
                            </div>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="cell">
                    <div class="media width-160 v-middle margin-none">
                        <div class="media-left">
                        </div> 
                        <div class="media-body">
                            <?php echo $this->Html->link('Lista de Módulos',['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]],['escape'=>false,'class'=>'btn btn-primary']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="split-vertical-body">
        <div class="split-vertical-cell">
            <div class="container height-100pc">
                <div class="page-section height-100pc">
                    <div class="row height-100pc">
                        <div class="col-md-12">

                        <p class="text-light text-caption">
                            <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'meus-cursos', 'action' => 'index']); ?>
                            <i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link($course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]]); ?>
                            <i class="fa fa-fw  fa-angle-right"></i> Resultado da avaliação
                          </p>

                        <div class="page-section padding-top-none">
    		                <div class="media v-middle">
    		                    <div class="media-body">
    		                        <h1 class="text-display-1 margin-none"> Resultado da avaliação</h1>
    		                        <p class="text-subhead"></p>
    		                    </div>
    		                </div>
    		            </div>
                            
                            <?php $key = 1; foreach ($userQuestion['UserQuestionOption'] as $userQuestionOption):?>
                            
    	                        <div class="panel panel-default paper-shadow" data-z="0.5">
    	                            <div class="panel-heading">
    	                                <h4 class="text-headline">Pergunta <?php echo $key; ?></h4>
    	                            </div>
    	                            <div class="panel-body">
    	                                <p class="text-body-2"><?php echo $userQuestionOption['QuestionAlternativeOptionUser']['QuestionAlternative']['text']; ?></p>

    	                                <div class="text-subhead-2 text-light">Resposta</div>

    	                                <div class="list-group">
    		                                <?php foreach ($userQuestionOption['QuestionAlternativeOptionUser']['QuestionAlternative']['QuestionAlternativeOption'] as $QuestionAlternativeOption):?>
    				                        	<?php
    				                        	$i = '';
    				                        	if($QuestionAlternativeOption['correct']):
    												//Se essa resposta for correta
    												if($userQuestionOption['QuestionAlternativeOptionUser']['correct']):
    													//Se o usuário acertou
    													$i = '<i class="fa fa-fw fa-lg fa-check text-green-300" alt="Resposta Certa"></i> ';
    												else:
    													$i = '<i class="fa fa-fw fa-lg fa-check" alt="Resposta Certa"></i> ';
    												endif;
    											else:
    												if($QuestionAlternativeOption['id'] == $userQuestionOption['QuestionAlternativeOptionUser']['question_alternative_option_id']):
    													//Se é a resposta do usuário
    													$i = '<i class="fa fa-fw fa-lg fa-close text-red-300" alt="Resposta Errada"></i> ';
    												endif;
    											endif;
    											?>
    											<span class="list-group-item"><?php echo $i.$QuestionAlternativeOption['name'];?></span>
    										<?php endforeach;?>
    									</div>
    	                            </div>
                                    <?php if( $userQuestionOption['QuestionAlternativeOptionUser']['QuestionAlternative']['feedback'] ): ?>
                                        <div class="panel-heading">
                                            <h4 class="text-headline text-light">Feedback</h4>
                                            <div class="text-body-2 text-light">
                                                <?php echo $userQuestionOption['QuestionAlternativeOptionUser']['QuestionAlternative']['feedback']; ?>
                                            </div>
                                        </div>
                                    <?php endif;?>
    	                        </div>
                    		  <hr/>
                    		<?php $key++; endforeach; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>