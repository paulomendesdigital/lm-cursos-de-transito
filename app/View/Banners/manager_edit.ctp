<?php /**
 * @copyright Copyright 2017
 * @author Rafael Bordallo - www.rafaelbordallo.com.br
 * Banner View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?><small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>
    </ul>
</div>

<?php echo $this->Form->create('Banner', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

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
                echo $this->Form->input('name',  ['class'=>'form-control', 'label'=>__('name')]);
                echo $this->Form->input('url',   ['class'=>'form-control', 'label'=>__('url')]);
                echo $this->Form->input('target',['class'=>'form-control', 'label'=>__('target'),'empty'=>'Selecione','options'=>[0=>'Mesma Janela',1=>'Nova Janela']]);
                echo $this->Form->input('status', ['class'=>'form-control','data-mask'=>'status','label'=>__('status'),'type'=>'checkbox','class'=>'switch','data-on'=>'success','data-off'=>'danger','data-on-label'=>'Sim','data-off-label' =>'Não']);
                ?>
            </div>
            <div class="tab-pane fade in" id="image">
                <?php
                echo $this->Form->input('image',  ['class'=>'form-control', 'label'=>__('image'). '(1140x100)','type'=>'file']);
                if( !empty($this->request->data['Banner']['image']) ){
                    echo $this->Html->image( Configure::read('Directory.Banner')."{$this->request->data['Banner']['id']}/xvga_{$this->request->data['Banner']['image']}",['class'=>'img-responsive']);
                }
                ?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
     <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" >
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>


<?php echo $this->Form->end(); ?>
