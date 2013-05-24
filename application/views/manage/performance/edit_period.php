<h1>Energy supplier performance</h1>
<h2>
  Edit Period:
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
          <tr>
            <th>Status</th>
            <td><span class="label label-warning">Unpublished</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="span8">
    <?php if($performance_data) : ?>

      <?php
        if ($this->session->flashdata('success')) {
          echo "<div class='alert alert-success'>";
          echo $this->session->flashdata('success');
          echo "</div>";
        }
        if ($this->session->flashdata('warning')) {
          echo "<div class='alert'>";
          echo $this->session->flashdata('warning');
          echo "</div>";
        }
        if ($this->session->flashdata('error')) {
          echo "<div class='alert alert-error'>";
          echo $this->session->flashdata('error');
          echo "</div>";
        }
        if (validation_errors()) {
          echo "<div class='alert alert-error'><h4>There were some problems:</h4><ul>";
          echo validation_errors();
          echo "</ul></div>";
        }
      ?>
    
      <form action="<?php echo site_url(array('manage','performance','edit',$period->id)); ?>" method="post">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Supplier</th>
              <th>Month 1</th>
              <th>Month 2</th>
              <th>Month 3</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($performance_data as $supplier) : ?>
              <tr>
                <th><?php echo $supplier->supplier_name; ?></th>
                <td><input type="text" id="supplier<?php echo $supplier->supplier_id; ?>A" name="supplier<?php echo $supplier->supplier_id; ?>A" placeholder="eg 0.0" value="<?php echo $supplier->month1; ?>" class="input-mini"></td>
                <td><input type="text" id="supplier<?php echo $supplier->supplier_id; ?>B" name="supplier<?php echo $supplier->supplier_id; ?>B" placeholder="eg 0.0" value="<?php echo $supplier->month2; ?>" class="input-mini"></td>
                <td><input type="text" id="supplier<?php echo $supplier->supplier_id; ?>C" name="supplier<?php echo $supplier->supplier_id; ?>C" placeholder="eg 0.0" value="<?php echo $supplier->month3; ?>" class="input-mini"></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <input type="hidden" name="action" value="save">
        <button type="submit" class="btn btn-primary">Save data</button>
      </form>
    <?php else : ?>
      <div class="alert alert-error">There is no performance data for this period. This shouldn't happen.</div>
    <?php endif; ?>
  </div>
</div>
<hr/>
<p><a href="<?php echo site_url('manage/performance'); ?>" class="btn">&larr; Back</a></p>