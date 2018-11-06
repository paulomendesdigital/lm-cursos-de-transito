<ul class="pagination margin-top-none">
    <?php
    echo $this->Paginator->prev('« ', array(), null, array('class' => 'prev disabled'));
    echo $this->Paginator->numbers(array('separator' => ''));
    echo $this->Paginator->next(' »', array(), null, array('class' => 'next disabled'));
    ?>
</ul>