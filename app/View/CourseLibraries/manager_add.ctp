<?php /**
 * @copyright Copyright 2018
 * @author Rafael Bordallo - www.rafaelbordallo.com.br
 * CourseLibraries View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Biblioteca Virtual<small><?php echo $courses[$course_id];?></small></h3>
    </div>
</div>

<?php echo $this->Html->link('<i class="icon-arrow-left"></i> Voltar ao curso', array('controller' => 'courses', 'action' => 'edit', $course_id), array('class' => 'btn btn-info', 'escape' => false)); ?>    
<br>
<br>
<?php echo $this->Form->create('CourseLibrary', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <li class=""><a href="#image" data-toggle="tab">Imagem</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
    			<?php
					echo $this->Form->input('course_id',  ['class'=>'form-control hide', 'label'=>false, 'value' => $course_id]);
					echo $this->Form->input('name',  ['class'=>'form-control', 'label'=>__('name')]);
					echo $this->Form->input('url',  ['class'=>'form-control', 'label'=>__('url'), 'placeholder' => 'Informe o link completo com http://']);
					echo $this->Form->input('status', ['class'=>'form-control','data-mask'=>'status','label'=>__('status'),'type'=>'checkbox','class'=>'switch','data-on'=>'success','data-off'=>'danger','data-on-label'=>'Sim','data-off-label' =>'Não']);
					echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder', 'label'=>__('text')));
				?>
            </div>
            <div class="tab-pane fade in" id="image">
                <?php
                echo $this->Form->input('image',  ['class'=>'form-control', 'label'=>__('Imagem') . '<small> (400x400)</small>','type'=>'file']);
                ?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
     <?php echo $this->Html->link('Cancelar', array('controller' => 'courses', 'action' => 'edit', $course_id), array('class' => 'btn btn-danger')); ?>    
    <input type="submit" class="btn btn-success" value="Salvar">
</div>


<?php echo $this->Form->end(); ?>

