<?php $seoPage = $this->Utility->__getSeoPage($data);?>

<meta name="url" content="<?php echo Router::url('/', true); ?>" />
<base href="<?php echo Router::url('/', true); ?>" />

<meta name="language" content="pt-BR">    

<!-- ---------- META SITE -------------- -->
<title><?php echo $seoPage['title'];?></title>
<meta name="description" lang="pt-br" content="<?php echo $seoPage['description'];?>"/>
<meta name="keywords" lang="pt-br" content="<?php echo $seoPage['keyword'];?>"/>
<meta name="google-site-verification" content="<?php echo $Sistems['Verification'];?>" />
<meta name="author" content="<?php echo $Developer['Author'];?> <<?php echo $Developer['AuthorEmail'];?>>">
<meta name="company" content="<?php echo $Sistems['CorporateFantasy'];?>" />
<meta name="revisit-after" content="7" />
<meta http-equiv="pragma" content="cache">
<meta name="robots" content="index, follow" />
<meta name="robots" content="archive">
<link rev="made" href="mailto:<?php echo $Developer['Email'];?>" />
<!-- ---------- END META SITE -------------- -->

<meta property="og:locale" content="pt_BR">
<meta property="og:url" content="https://www.lmcursosdetransito.com.br/">
<meta property="og:title" content="LM Cursos de Trânsito">
<meta property="og:site_name" content="LM Cursos de Trânsito">
<meta property="og:description" content="A LM Cursos de Trânsito é uma entidade educacional especializada em cursos na área de trânsito, na modalidade à distância (EAD). Realize de forma rápida o Curso de Reciclagem para Condutores Infratores do Rio de Janeiro.">
<meta property="og:image" content="https://www.lmcursosdetransito.com.br/img/site/lmcursos.png">
<meta property="og:image:type" content="image/png">