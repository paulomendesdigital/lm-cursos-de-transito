<section id='accredition-section'>
    <div class='container'>
        <div class='row'>
        <?php 
        if ($recycle && $state_id == 9) {
            echo $this->Html->image("site/Detran-GO-200.png",['data-toggle' => 'modal', 'data-target' =>'#credenciamentoGO', 'class'=>'center-block img-responsive', 'style' => 'cursor: pointer']);
            ?>
            <!-- Modal -->
            <div class="modal fade" id="credenciamentoGO" tabindex="-1" role="dialog" aria-labelledby="credenciamentoGOLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="credenciamentoGOLabel"><b>Credencial - Detran GO</b></h4>
                        </div>
                        <div class="modal-body">
                            <?php echo $this->Html->image("site/credenciamentos/credenciamento-go.jpg",['class'=>'center-block img-responsive']); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        </div>			
    </div>
</section>