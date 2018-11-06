<?php $Sistems = Configure::read('Sistems');?>          
<p>Você recebeu um email enviado pelo site.</p>

<div style="text-align: left; border: 1px solid #E0E0E0;font-size: 12px;line-height: 16px;margin: 10px 0;padding: 13px 18px;background: #F9F9F9;">
    <p><strong>Informações:</strong></p>
    Nome: <?php echo $data['content']['name'];?><br>
    CPF: <?php echo $data['content']['cpf'];?><br>
    Email: <?php echo $data['content']['email'];?><br>
    Telefone: <?php echo $data['content']['phone'];?><br>    
    Endereço: <?php echo $data['content']['address'];?><br>        
    Assunto: <?php echo $data['content']['subject'];?><br><br>
    <div style="text-align: left;">
        <p><strong>Mensagem:</strong></p>
        <p>
            <?php echo $data['content']['messenger'];?>
        </p>
    </div>
</div>



