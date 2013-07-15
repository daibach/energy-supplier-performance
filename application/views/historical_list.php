<h2>Historical supplier complaint handling figures</h2>

<hr/>

<div class="row-fluid">
  <div class="span9">

    <div id="graph"></div>

    <table class="table">
      <thead>
        <tr>
          <th class="monthname">Month</th>
          <?php foreach($suppliers as $supplier) : ?>
            <th><a href="<?php echo site_url(array('supplier',$supplier->supplier_slug)); ?>"><?php echo $supplier->supplier_short_name; ?></a></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($historical_period_data as $period) : ?>
          <tr>
            <th><a href="<?php echo site_url(array('historical',$period['year'].'-q'.$period['quarter'])); ?>"><?php echo $period['month_name']." ".$period['year']; ?></a></th>
            <?php foreach($suppliers as $supplier) : ?>
              <td class="suppliervalue"><?php echo $period['data'][$supplier->id]['value']; ?>
                <?php if( $supplier->supplier_slug != 'average') : ?>
                  <br/><span class="badge badge-<?php echo ranking_css_class($period['data'][$supplier->id]['ranking']); ?>"><?php echo add_ordinal_suffix($period['data'][$supplier->id]['ranking']); ?></span>
                <?php endif; ?>
              </td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
  <div class="span3">
    <div class="well">
      <!--<h4>Download this data</h4>
      <ul>
        <li><a href="#">CSV</a></li>
        <li><a href="#">JSON</a></li>
      </ul>-->
      <p class="ogl"><a href="http://www.nationalarchives.gov.uk/doc/open-government-licence/version/2"><img alt="OGL" src="/img/open-government-licence.png"></a>This data is published under the <a href="http://www.nationalarchives.gov.uk/doc/open-government-licence/version/2">Open Government Licence v2.0</a>.</p>
    </div>
  </div>
</div>
