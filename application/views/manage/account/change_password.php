<h1>Change your password</h1>

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

<form class="form-horizontal" method="post" action="<?php echo site_url('manage/account/change-password'); ?>">
  <div class="control-group">
    <label class="control-label" for="currentPassword">Existing password</label>
    <div class="controls">
      <input type="password" id="currentPassword" name="currentPassword" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="newPassword">New password</label>
    <div class="controls">
      <input type="password" id="newPassword" name="newPassword" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="newPasswordAgain">Retype new password</label>
    <div class="controls">
      <input type="password" id="newPasswordAgain" name="newPasswordAgain" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary">Change password</button>
      <a class="btn" href="<?php echo site_url('manage/account/dashboard');?>">Cancel</a>
      <input type="hidden" name="action" value="changepassword">
    </div>
  </div>
</form>