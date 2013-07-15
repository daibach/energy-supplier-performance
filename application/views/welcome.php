

<h2>Complaint handling figures for <?php echo $period->period_year.", ".format_quarter_name($period->period_quarter); ?></h2>

<div class="row-fluid">
  <div class="span6">

    <div id="graph"></div>

  </div>
  <div class="span6">

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Supplier</th>
          <th>Weighted cases per 100,000 customers</th>
          <th>Ranking</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($period_data as $supplier) : ?>
        <tr<?php if($supplier->supplier_slug=='average'):?> class="info"<?php endif; ?>>
          <th><a href="<?php echo site_url(array('supplier',$supplier->supplier_slug)); ?>"><?php echo $supplier->supplier_name; ?></a>
            <?php if($supplier->supplier_annotation != '') : ?>
            <br/><span class="supplier-includes"><?php echo $supplier->supplier_annotation; ?></span>
          <?php endif; ?>
          </th>
          <td><?php echo $supplier->month3; ?></td>
          <?php if(! is_null($supplier->month3_ranking)) : ?>
            <td class="ranking"><span class="badge badge-<?php echo ranking_css_class($supplier->month3_ranking); ?>"><?php echo add_ordinal_suffix($supplier->month3_ranking); ?></span></td>
          <?php else : ?>
            <td>&nbsp;</td>
          <?php endif; ?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <p>View this quarter's data in <a href="<?php echo site_url(array('historical',"$period->period_year-q$period->period_quarter")); ?>">more detail</a>.</p>
  </div>
</div>
