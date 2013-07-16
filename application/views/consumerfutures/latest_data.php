
      <h1>How do the domestic energy suppliers compare on complaint handling?<sup>3</sup>
        <br/><span><?php echo $period->period_year.", ".format_quarter_name($period->period_quarter); ?></span></h1>

      <div id="graph"></div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>Supplier</th>
            <th>Weighted ratio per 100,000 customers</th>
            <th>Ranking</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($period_data as $supplier) : ?>
          <tr<?php if($supplier->supplier_slug=='average'):?> class="info"<?php endif; ?>>
            <th><?php echo $supplier->supplier_name; ?>
              <?php if($supplier->supplier_slug == 'scottish-and-southern') : ?><sup>1</sup>
              <?php elseif($supplier->supplier_slug == 'british-gas') : ?><sup>2</sup>
              <?php endif; ?>
            </th>
            <td><?php echo $supplier->month3; ?></td>
            <?php if(! is_null($supplier->month3_ranking)) : ?>
              <td class="ranking"><span class="badge"><?php echo add_ordinal_suffix($supplier->month3_ranking); ?></span></td>
            <?php else : ?>
              <td>&nbsp;</td>
            <?php endif; ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

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
          View the <a href="">full details of the model</a></li>
      </ol>
        
<!--
      <footer>
        <p><a href="<?php echo site_url(); ?>" target="_new">View this data in detail</a> (opens in a new window).</p>
      </footer>
-->