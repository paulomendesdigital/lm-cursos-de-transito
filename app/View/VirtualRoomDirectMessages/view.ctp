<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * DirectMessage View
 *
*/ ?>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-9">
                <p class="text-light text-caption">
                    <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'meus-cursos', 'action' => 'index']); ?>
                    <i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link($course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]]); ?>
                    <i class="fa fa-fw  fa-angle-right"></i>Fale com Tutores
                </p>
                <div class="page-section padding-top-none">
                    <div class="media v-middle">
                        <div class="media-body">
                            <h1 class="text-display-1 margin-none"> Fale com Tutores</h1>
                            <p class="text-subhead text-light"><?php echo $course['Course']['name'];?></p>
                        </div>
                    </div>
                </div>

                <div class="media messages-container media-clearfix-xs-min media-grid">
                
                    <?php echo $this->Element('site/lms/direct-message-col-instructors', ['course' => $course, 'instructor_id' => $instructor_id]);?>

                    <div class="media-body">
                        <?php echo $this->Form->create('DirectMessage', array('url' => array('controller' => 'fale-com-instrutores', 'action' => 'add', $this->params['pass'][0], $this->params['pass'][1])));?>
                            <h4>Escreva sua mensagem:</h4>
                            <textarea class="form-control share-text" name="data[DirectMessage][text]" rows="6" style="background-color: #fff"></textarea>
                            <p>&nbsp;</p>
                            <p><button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Enviar</button></p>
                        <?php echo $this->Form->end();?>

                        <?php foreach($direct_messages as $direct_message):?>
                            <?php $author = $this->Utility->__getAuthor($direct_message['DirectMessage']['author']);?>
                            <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1" data-animated="">
                                <div class="panel-body">
                                    <div class="media v-middle">
                                        <div class="media-left">
                                            <?php 
                                            if( $author == 'User' ){
                                                echo $this->Utility->avatarUser($direct_message['User']['id'], $direct_message['User']['avatar'], 'media-object img-circle width-50');
                                            }else{
                                                echo $this->Utility->avatarUser($direct_message['Instructor']['User']['id'], $direct_message['Instructor']['User']['avatar'], 'media-object img-circle width-50');
                                            }?>
                                        </div>
                                        <div class="media-body message">
                                            <h4 class="text-subhead margin-none"><a href="#"><?php echo $direct_message[$author]['name'] ?></a></h4>
                                            <p class="text-caption text-light"><i class="fa fa-clock-o"></i> <?php echo $this->Utility->clockTimeDiff($direct_message['DirectMessage']['diff']); ?></p>
                                        </div>
                                    </div>
                                    <p><?php echo nl2br($direct_message['DirectMessage']['text']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php echo $this->Element('site/lms/course-col-right');?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $.ajax({
            type: 'POST',
            url: "<?php echo $this->Html->url(array('controller' => 'fale-com-instrutores','action' => 'update_view_user', $this->params['pass'][0], $this->params['pass'][1])); ?>",
            datatype:'json',
            cache: false,
            data: {},
            success: function(){},
            error: function(){}
        });
</script>
