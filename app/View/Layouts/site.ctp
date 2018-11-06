<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-N6PL3FJ');</script>
    <!-- End Google Tag Manager -->


  <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'></script>
  <script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
      appId: "df149b25-c7d5-4f27-ad73-61f69969d66d",
      autoRegister: true, /* Set to true to automatically prompt visitors */
      subdomainName: 'lmcursosdetransito',
      httpPermissionRequest: {
        enable: true
      },
      notifyButton: {
          enable: true /* Set to false to hide */
      },
welcomeNotification: {
        "title": "Obrigado!",
        "message": "Ao autorizar nossas notificações você ficará por dentro das novidades do site LM Cursos de Trânsito.",
        // "url": "" /* Leave commented for the notification to not open a window on Chrome and Firefox (on Safari, it opens to your webpage) */
    },
    notifyButton: {
        enable: true, /* Required to use the notify button */
        size: 'medium', /* One of 'small', 'medium', or 'large' */
        theme: 'default', /* One of 'default' (red-white) or 'inverse" (white-red) */
        position: 'bottom-left', /* Either 'bottom-left' or 'bottom-right' */
        offset: {
        left: '15px'
        },
        prenotify: true, /* Show an icon with 1 unread message for first-time site visitors */
        showCredit: false, /* Hide the OneSignal logo */
        text: {
            'tip.state.unsubscribed': 'Clique para ficar por dentro das novidades do site LM Cursos de Trânsito.',
            'tip.state.subscribed': "Você está inscrito para receber notificações",
            'tip.state.blocked': "Você bloqueou as notificações",
            'message.prenotify': 'Clique em INSCREVER para receber notificações',
            'message.action.subscribed': "Obrigado por se inscrever!",
            'message.action.resubscribed': "Você já está inscrito para receber notificações",
            'message.action.unsubscribed': "Você não receberá notificações novamente",
            'dialog.main.title': 'Deseja receber novidades ?',
            'dialog.main.button.subscribe': 'INSCREVER',
            'dialog.main.button.unsubscribe': 'CANCELAR',
            'dialog.blocked.title': 'Desbloquear Notificações',
            'dialog.blocked.message': "Siga as instruções para habilitar as notificações:"
        }
    }

    }]);
  </script>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700" rel="stylesheet"> 
    <!-- Compressed Vendor BUNDLE
    Includes vendor (3rd party) styling such as the customized Bootstrap and other 3rd party libraries used for the current theme/module -->
    <?php echo $this->Html->css('../themes/css/vendor.min');?>
    <!-- Compressed Theme BUNDLE
Note: The bundle includes all the custom styling required for the current theme, however
it was tweaked for the current theme/module and does NOT include ALL of the standalone modules;
The bundle was generated using modern frontend development tools that are provided with the package
To learn more about the development process, please refer to the documentation. -->
    <!-- Compressed Theme CORE
This variant is to be used when loading the separate styling modules -->
    <?php echo $this->Html->css('../themes/css/theme-core.min');?>   

    <?php //echo $this->Html->css('site/min/style.min');?>
    <link rel="stylesheet" href="/css/site/min/style.min.css?<?php echo time();?>">     

    <script>
        var Domain = "<?php echo Router::url('/',true); ?>";
    </script>

    <?php echo $this->Element("site/metatag", ['data'=>isset($course)?$course:false]); ?>
    <?php echo $this->Element("site/chat", ['show'=>$this->Utility->__isAllowedChat()]); ?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- If you don't need support for Internet Explorer <= 8 you can safely remove these -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min');?>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min');?>
<![endif]-->
</head>

<?php if( $this->params['controller'] == 'users' && $this->params['action'] != 'add'): ?>
    <body class="login">
<?php else: ?>
    <body>
<?php endif; ?>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6PL3FJ" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Facebook SDK -->
<script>
    var appId = '421480468339406'; //app oficial LM Cursos

    if (window.location.hostname.indexOf('dsconsultoria') !== -1) {
        appId = '990561117779850'; //app teste
    }

    window.fbAsyncInit = function() {
        FB.init({
            appId            : appId,
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v3.0'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- End Facebook SDK -->


    <?php //if($this->Session->read('Auth.User')):?>
        <?php //echo $this->element("site/header"); ?>
    <?php //endif;?>

    <?php echo $this->element("site/header-site"); ?>

    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>
    <?php echo (isset($cartInSession) and !empty($cartInSession)) ? $this->Element('site/fixed-bag-link') : ''; ?>
    <?php echo $this->element("site/footer-site"); ?>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min');?>-->
    



<!-- Inline Script for colors and config objects; used by various external scripts; -->
    <script>
        var colors = {
            "danger-color": "#e74c3c",
            "success-color": "#81b53e",
            "warning-color": "#f0ad4e",
            "inverse-color": "#2c3e50",
            "info-color": "#2d7cb5",
            "default-color": "#6e7882",
            "default-light-color": "#cfd9db",
            "purple-color": "#9D8AC7",
            "mustard-color": "#d4d171",
            "lightred-color": "#e15258",
            "body-bg": "#f6f6f6"
        };
        var config = {
            theme: "html",
            skins: {
                "default": {
                    "primary-color": "#42a5f5"
                }
            }
        };
    </script>
    
    <script src="/js/site/build/build.min.js?<?php echo time();?>"></script>
    <?php
    //echo $this->Html->script('site/build/build.min.js');
    echo $this->Html->script('global');
    echo $this->Html->script('site/jquery.animateNumber');
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</body>
</html>
