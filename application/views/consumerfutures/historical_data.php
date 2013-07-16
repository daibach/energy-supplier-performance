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
    <link href="/css/consumer-futures-embed.css" rel="stylesheet">

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
      <h1>Data since October 2012</h1>

      <p>This graph &amp; table show historical supplier performance on a three month rolling average since October 2012</p>

      <div id="graph" style="width:750px;"></div>

      <table class="table">
        <thead>
          <tr>
            <th class="monthname">Month</th>
            <?php foreach($suppliers as $supplier) : ?>
              <th class="suppliername"><?php echo $supplier->supplier_short_name; ?><?php if($supplier->supplier_slug == 'scottish-and-southern') : ?><sup>1</sup><?php elseif($supplier->supplier_slug == 'british-gas') : ?><sup>2</sup><?php endif; ?></th>
            <?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach($historical_period_data as $period) : ?>
            <tr>
              <th class="monthname"><?php echo $period['month_name']." ".$period['year']; ?></th>
              <?php foreach($suppliers as $supplier) : ?>
                <td class="suppliervalue"><?php echo $period['data'][$supplier->id]['value']; ?>
                  <?php if( $supplier->supplier_slug != 'average') : ?>
                    <br/><span class="badge badgelight"><?php echo add_ordinal_suffix($period['data'][$supplier->id]['ranking']); ?></span>
                  <?php endif; ?>
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <hr/>

      <ol>
        <li>Includes Atlantic, Scottish Hydro Electric, Southern Electric, SWALEC</li>
        <li>Includes Scottish Gas</li>
        <li>Consumer Futures has created a proxy for performance based on the number of consumers 
          that have contacted an independent organisation for advice or support with an energy 
          problem. The companies have been ranked on the number of customer contacts to the Citizens
          Advice Consumer Service, Consumer Futures and the Ombudsman Services: Energy in relation to their
          market share during the last quarter</li>
        <li>The different types of complaint have been weighted to reflect the seriousness of the 
          complaint and the time and effort spent by the consumer to get their problem resolved.
      </ol>
        
      <!--<footer>
        <p><a href="<?php echo site_url(); ?>" target="_new">View this data in detail</a> (opens in a new window).</p>
      </footer>-->

    </div> <!-- /container -->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="<?php echo site_url('charts/historical.js'); ?>"></script>
  </body>
</html>