<?php $Sistems = Configure::read('Sistems');?>
<p>Você recebeu um email enviado pelo site interessado em <b>parceria</b>.</p>

<div style="text-align: left; border: 1px solid #E0E0E0;font-size: 12px;line-height: 16px;margin: 10px 0;padding: 13px 18px;background: #F9F9F9;">
    <p><strong>Dados Pessoais:</strong></p>
    Nome: <?php echo $data['content']['name'];?><br>
    Sexo: <?php echo $data['content']['sex'];?><br>
    Nascimento: <?php echo $data['content']['birth'];?><br>
    CPF: <?php echo $data['content']['cpf'];?><br>

    <p><strong>Endereço Comercial:</strong></p>

    Rua/Av: <?php echo $data['content']['street'];?><br>
    Nº: <?php echo $data['content']['number'];?><br>
    Complemento: <?php echo $data['content']['complement'];?><br>
    Bairro: <?php echo $data['content']['neighborhood'];?><br>
    CEP: <?php echo $data['content']['zip_code'];?><br>
    Cidade: <?php echo $data['content']['city'];?> - UF <?php echo $data['content']['state'];?><br>

    <p><strong>Contato:</strong></p>

    Telefone Res: <?php echo $data['content']['phone'];?><br>
    Telefone Cel: <?php echo $data['content']['cellphone'];?><br>
    E-mail: <?php echo $data['content']['email'];?><br>
</div>


<div style="text-align: left;">
    <p><strong>Mensagem:</strong></p>
    <p>
        <?php echo $data['content']['messenger'];?>
    </p>
</div>