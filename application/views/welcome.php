

<h2>Complaint Figures for <?php echo $period->period_year.", ".format_quarter_name($period->period_quarter); ?></h2>

<div class="row-fluid">
  <div class="span6">

    <div id="graph"></div>

  </div>
  <div class="span6">

    <table class="table table-striped">
      <thead>
        <tr>
          <th>Supplier</th>
          <th>Complaints per 100,000 customers</th>
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
</div>
