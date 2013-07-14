
<?php if($is_industry_average) : ?>
  <h2>Industry Average Performance Figures (Big Six Suppliers)</h2>
<?php else : ?>
  <h2>Performance Figures for <?php echo $supplier->supplier_name; ?></h2>
  <p>Current ranking: <span class="badge badge-<?php echo ranking_css_class($ranking); ?>"><?php echo add_ordinal_suffix($ranking); ?></span> of 6</p>
<?php endif; ?>
<hr/>

<div class="row-fluid">
  <div class="span9">

    <div id="graph"></div>

    <table class="table">
      <thead>
        <tr>
          <th>Period</th>
          <th>Month</th>
          <th>Weighted cases per 100,000 customers</th>
          <th>Quarter Avg</th>
          <?php if(!$is_industry_average) : ?><th>Ranking</th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach($period_data as $period) : ?>
          <tr>
            <th rowspan="3"><a href="<?php echo site_url(array('historical',"$period->period_year-q$period->period_quarter")); ?>"><?php echo $period->period_year.' Q'.$period->period_quarter; ?></a></th>
            <th><?php echo identify_quarter_month($period->period_quarter,3)." ".$period->period_year; ?></th>
            <td><?php echo $period->month3; ?></td>
            <td rowspan="3"><?php echo $period->period_average; ?></td>
            <?php if(!$is_industry_average) : ?><td rowspan="3" class="ranking"><span class="badge badge-<?php echo ranking_css_class($period->ranking); ?>"><?php echo add_ordinal_suffix($period->ranking); ?></span> of 6</td><?php endif; ?>
          </tr>
          <tr>
            <th><?php echo identify_quarter_month($period->period_quarter,2)." ".$period->period_year; ?></th>
            <td><?php echo $period->month2; ?></td>
          </tr>
          <tr>
            <th><?php echo identify_quarter_month($period->period_quarter,1)." ".$period->period_year; ?></th>
            <td><?php echo $period->month1; ?></td>
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