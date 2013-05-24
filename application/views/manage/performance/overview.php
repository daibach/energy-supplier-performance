<h1>Energy supplier performance</h1>

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

<div class="row-fluid">
  <div class="span8">
    
    <?php if($periods) : ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Period</th>
            <th>Status</th>
            <th>Tools</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($periods as $period) : ?>
            <tr>
              <td><?php echo $period->period_year; ?> Q<?php echo $period->period_quarter; ?></td>
              <td><?php if($period->published=='yes') : ?><span class="label label-success">Published</label><?php else : ?><span class="label label-warning">Unpublished</span><?php endif; ?></td>
              <td>
                <a href="<?php echo site_url(array('manage','performance','view',$period->id));?>" class="btn btn-info btn-small">View data</a>
                <?php if($period->published=='no') : ?>
                  <a href="<?php echo site_url(array('manage','performance','edit',$period->id));?>" class="btn btn-info btn-small">Edit data</a>
                  <a href="<?php echo site_url(array('manage','performance','publish',$period->id));?>" class="btn btn-success btn-small">Publish data</a>
                  <a href="<?php echo site_url(array('manage','performance','delete',$period->id));?>" class="btn btn-danger btn-small">Delete data</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert alert-info">There is currently no performance data available</div>
    <?php endif; ?>

  </div>
  <div class="span4">

    <div class="well">
      <form action="<?php echo site_url('manage/performance/create-period'); ?>" method="post">
        <h3>Add performance period</h3>
        <div class="control-group">
          <label class="control-label" for="periodyear">Year:</label>
          <div class="controls">
            <select id="periodyear" name="periodyear">
              <?php foreach(range(2010,date('Y')+1) as $year) : ?>
                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="periodquarter">Quarter:</label>
          <div class="controls">
            <select id="periodquarter" name="periodquarter">
              <option value="1">Q1 (Jan, Feb, Mar)</option>
              <option value="2">Q2 (Apr, May, Jun)</option>
              <option value="3">Q3 (Jul, Aug, Sep)</option>
              <option value="4">Q4 (Oct, Nov, Dec)</option>
            </select>
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary">Add period</button>
          </div>
        </div>
      </form>
    </div>

  </div>
</div>