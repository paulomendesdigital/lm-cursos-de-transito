<p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('<b>Página {:page} de {:pages}</b></br> Mostrando {:current} registro(s) de {:count} totais.')
    ));
    ?>  
</p>
<div align="right">
    
    <ul class="pagination">
        <?php
        echo $this->Paginator->prev('< ' . __('anterior'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('próximo') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </ul>
</div>