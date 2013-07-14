<h2>Performance Figures for <?php echo $period->period_year.", ".format_quarter_name($period->period_quarter); ?></h2>

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
          <th rowspan="2">Quarter Avg</th>
          <th rowspan="2">Ranking</th>
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
            <?php if($supplier->ranking==1):?> class="success"<?php endif; ?>
          >
            <th><a href="<?php echo site_url(array('supplier',$supplier->supplier_slug)); ?>"><?php echo $supplier->supplier_name; ?></a>
              <?php if($supplier->supplier_annotation != '') : ?>
                <br/><span class="supplier-includes"><?php echo $supplier->supplier_annotation; ?></span>
              <?php endif; ?>
            </th>
            <td><?php echo $supplier->month1; ?></td>
            <td><?php echo $supplier->month2; ?></td>
            <td><?php echo $supplier->month3; ?></td>
            <td><?php echo $supplier->period_average; ?></td>
            <?php if(! is_null($supplier->ranking)) : ?>
              <td class="ranking"><span class="badge badge-<?php echo ranking_css_class($supplier->ranking); ?>"><?php echo add_ordinal_suffix($supplier->ranking); ?></span></td>
            <?php else : ?>
              <td>&nbsp;</td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </div>
  <div class="span3">
    <div class="well">
      <h4>Download this data</h4>
      <ul>
        <li><a href="#">CSV</a></li>
        <li><a href="#">JSON</a></li>
      </ul>
      <p>This data is published under the Open Government Licence.</p>
    </div>
  </div>
</div>