<h2>Complaint handling figures for <?php echo $period->period_year.", ".format_quarter_name($period->period_quarter); ?></h2>

<hr/>

<div class="row-fluid">
  <div class="span9">

    <div id="graph"></div>

    <hr/>

    <table class="table">
      <thead>
        <tr>
          <th rowspan="2">Supplier</th>
          <th colspan="3">Weighted cases per 100,000 customers</th>
        </tr>
        <tr>
          <th><?php echo identify_quarter_month($period->period_quarter,1,'short')." ".$period->period_year; ?></th>
          <th><?php echo identify_quarter_month($period->period_quarter,2,'short')." ".$period->period_year; ?></th>
          <th><?php echo identify_quarter_month($period->period_quarter,3,'short')." ".$period->period_year; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($period_data as $supplier) :?>
          <tr
            <?php if($supplier->supplier_slug=='average'):?> class="info"<?php endif; ?>
            <?php if($supplier->ranking_average==1):?> class="success"<?php endif; ?>
          >
            <th><a href="<?php echo site_url(array('supplier',$supplier->supplier_slug)); ?>"><?php echo $supplier->supplier_name; ?></a>
              <?php if($supplier->supplier_annotation != '') : ?>
                <br/><span class="supplier-includes"><?php echo $supplier->supplier_annotation; ?></span>
              <?php endif; ?>
            </th>
            <td><?php echo $supplier->month1; ?>
              <?php if(! is_null($supplier->month1_ranking)) : ?>
              <br/><span class="badge badge-<?php echo ranking_css_class($supplier->month1_ranking); ?>"><?php echo add_ordinal_suffix($supplier->month1_ranking); ?></span>
              <?php endif; ?>
            </td>
            <td><?php echo $supplier->month2; ?>
              <?php if(! is_null($supplier->month2_ranking)) : ?>
              <br/><span class="badge badge-<?php echo ranking_css_class($supplier->month2_ranking); ?>"><?php echo add_ordinal_suffix($supplier->month2_ranking); ?></span>
              <?php endif; ?>
            </td>
            <td><?php echo $supplier->month3; ?>
              <?php if(! is_null($supplier->month3_ranking)) : ?>
              <br/><span class="badge badge-<?php echo ranking_css_class($supplier->month3_ranking); ?>"><?php echo add_ordinal_suffix($supplier->month3_ranking); ?></span>
              <?php endif; ?>
            </td>
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