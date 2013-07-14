<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <?php if(isset($page_title) && $page_title != "") :?>
      <title><?php echo $page_title ?> - <?php echo SITE_NAME; ?></title>
    <?php else : ?>
      <title><?php echo SITE_NAME; ?></title>
    <?php endif; ?>

    <meta name="viewport"    content="width=device-width, initial-scale=1.0">
    <meta name="keywords"    content="">
    <meta name="description" content="">
    <meta name="Author"      content="Dafydd Vaughan, Cedyrn Creative (<?php echo date('Y'); ?>), cedyrn.com">
    <meta name="robots"      content="nofollow,noindex">

    <?php if(isset($canonical)) : ?>
    <link rel="canonical" href="<?php echo $canonical; ?>">
    <?php endif;?>


    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/css/core.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php if (GA_CODE != "") : ?>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?php echo GA_CODE; ?>']);
      _gaq.push(['_trackPageview']);
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <?php endif; ?>

  </head>
  <body>

    <div class="container">
      <h1><a href="http://www.consumerfutures.org.uk">Consumer Futures</a></br/><span>Energy Supplier Complaint Handling</span></h1>

      <div class="navbar">
        <div class="navbar-inner">
          <ul class="nav">
            <li <?php if(isset($page_section) && $page_section=='latest') : ?>class="active"<?php endif; ?>><a href="<?php echo site_url(); ?>">Latest data</a></li>
            <li <?php if(isset($page_section) && $page_section=='suppliers') : ?>class="active"<?php endif; ?>><a href="<?php echo site_url('suppliers'); ?>">Energy suppliers</a></li>
            <li <?php if(isset($page_section) && $page_section=='historical') : ?>class="active"<?php endif; ?>><a href="<?php echo site_url('historical'); ?>">Historical data</a></li>
            <li <?php if(isset($page_section) && $page_section=='about') : ?>class="active"<?php endif; ?>><a href="#">About the data</a></li>
          </ul>
        </div>
      </div>