<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Chat Element
 *
*/?>

<?php if( $show ):?>
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
    var _smartsupp = _smartsupp || {};
  _smartsupp.key = 'f4692e94a11fd17b8291c8e872591c1f81dccab7';
  window.smartsupp||(function(d) {
    var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
    s=d.getElementsByTagName('script')[0];c=d.createElement('script');
    c.type='text/javascript';c.charset='utf-8';c.async=true;
    c.src='//www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
  })(document);
</script>
<script>
    //vendas
    smartsupp('group', 'RYsMweQozb');

    //suporte
    //smartsupp('group', 'aIUD8IgdC1');
    
    //tutor
    //smartsupp('group', '76YtSDEolz');
    
    //pedagogico
    //smartsupp('group', 'Dg2CGPfVbb');
</script>
<?php endif;?>