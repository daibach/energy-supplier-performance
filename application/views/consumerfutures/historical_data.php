
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
