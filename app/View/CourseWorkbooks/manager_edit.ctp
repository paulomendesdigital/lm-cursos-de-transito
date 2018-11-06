<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseWorkbooks View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Apostilas Virtual<small><?php echo $this->request->data['Course']['name'];?></small></h3>
    </div>
</div>

<?php echo $this->Html->link('<i class="icon-arrow-left"></i> Voltar ao curso', array('controller' => 'courses', 'action' => 'edit', $this->request->data['Course']['id']), array('class' => 'btn btn-info', 'escape' => false)); ?>    
<br>
<br>
<?php echo $this->Form->create('CourseWorkbook', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <li class=""><a href="#image" data-toggle="tab">Imagem</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
    			<?php
					echo $this->Form->input('id');
					echo $this->Form->input('course_id',  ['class'=>'form-control hide', 'label'=>false]);
					echo $this->Form->input('name',  ['class'=>'form-control', 'label'=>__('name')]);
					echo $this->Form->input('filename',  ['class'=>'form-control', 'type'=>'file','label'=>__('Arquivo'), 'after'=>!empty($this->request->data['CourseWorkbook']['filename'])?'<small class="text-success"> arquivo enviado!</small>':'<small class="text-warning"> arquivo não enviado até o momento!</small>']);
					echo $this->Form->input('status', ['class'=>'form-control','data-mask'=>'status','label'=>__('status'),'type'=>'checkbox','class'=>'switch','data-on'=>'success','data-off'=>'danger','data-on-label'=>'Sim','data-off-label' =>'Não']);
					echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder', 'label'=>__('text')));
				?>
            </div>
            <div class="tab-pane fade in" id="image">
                <?php
                echo $this->Form->input('image',  ['class'=>'form-control', 'label'=>__('Imagem') . '<small> (400x400)</small>','type'=>'file']);
                if( !empty($this->request->data['CourseWorkbook']['image']) ){
                    echo $this->Html->image( "/files/course_workbook/image/{$this->request->data['CourseWorkbook']['id']}/vga_{$this->request->data['CourseWorkbook']['image']}",['class'=>'img-responsive']);
                }
                ?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
     <?php echo $this->Html->link('Cancelar', array('controller' => 'courses', 'action' => 'edit', $this->request->data['Course']['id']), array('class' => 'btn btn-danger')); ?>    
    <input type="submit" class="btn btn-success" value="Salvar">
</div>


<?php echo $this->Form->end(); ?>

