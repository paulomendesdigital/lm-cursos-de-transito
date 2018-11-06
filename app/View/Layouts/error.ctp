<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <script type="text/javascript">var Domain = '<?php echo Router::url('/', true); ?>';</script>
        
        <?php
            echo $this->Html->meta('icon');
            
            //CSS
            echo $this->Html->css('site/style');
            echo $this->Html->css('site/flexslider');
            
            echo $this->element("site/metatag");
            
            echo $this->Html->script('site/jquery');
            echo $this->Html->script('site/jquery.flexslider-min');
            echo $this->Html->script('site/actions');

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
    </head>
    <body class="error">

        <?php echo $this->fetch('content'); ?>

        <!-- ---------- GOOGLE ANALYTICS -------------- -->
        <script type="text/javascript">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php echo $Sistems['Analytics'];?>', '<?php echo Router::url('/', true); ?>');
        ga('send', 'pageview');

        </script>
        <!-- ---------- END GOOGLE ANALYTICS -------------- -->
        
    </body>
</html>