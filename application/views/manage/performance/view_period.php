<h1>Energy supplier performance</h1>
<h2>
  View Period:
  <span class="period-name"><?php echo $period->period_year." ".format_quarter_name($period->period_quarter); ?></span>

</h2>

<div class="row-fluid">
  <div class="span4">
    <div class="well">
      <table class="table">
        <tbody>
          <tr>
            <th>Period</th>
            <td><?php echo $period->period_year." ".format_quarter_name($period->period_quarter); ?></td>
          </tr>
          <?php if($period->published=='yes') : ?>
            <tr>
              <th>Status</th>
              <td><span class="label label-success">Published</span></td>
            </tr>
            <tr>
              <th>Published on</th>
              <td><?php echo $period->published_date; ?></td>
            </tr>
          <?php else : ?>
            <tr>
              <th>Status</th>
              <td><span class="label label-warning">Unpublished</span></td>
            </tr>
            <tr>
              <th>Tools</th>
              <td>
                <a href="<?php echo site_url(array('manage','performance','edit',$period->id));?>" class="btn btn-info btn-small">Edit</a>
                <a href="<?php echo site_url(array('manage','performance','publish',$period->id));?>" class="btn btn-success btn-small">Publish</a>
                <a href="<?php echo site_url(array('manage','performance','delete',$period->id));?>" class="btn btn-danger btn-small">Delete</a>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="span8">
    <?php if($performance_data) : ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Supplier</th>
            <th>Month 1</th>
            <th>Month 2</th>
            <th>Month 3</th>
            <th>Period Average</th>
            <th>Ranking Average</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($performance_data as $supplier) : ?>
            <tr>
              <th><?php echo $supplier->supplier_name; ?></th>
              <td><?php echo $supplier->month1; ?></td>
              <td><?php echo $supplier->month2; ?></td>
              <td><?php echo $supplier->month3; ?></td>
              <td><?php echo $supplier->period_average; ?></td>
              <td><?php echo add_ordinal_suffix($supplier->ranking_average); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert alert-error">There is no performance data for this period. This shouldn't happen.</div>
    <?php endif; ?>
  </div>
</div>
<hr/>
<p><a href="<?php echo site_url('manage/performance'); ?>" class="btn">&larr; Back</a></p>