
<form class="form-signin" action="<?php echo site_url('manage/login'); ?>" method="post">
  <h2 class="form-signin-heading">Please sign in</h2>
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
  <input type="text" class="input-block-level" placeholder="Email address" id="txtEmail" name="email">
  <input type="password" class="input-block-level" placeholder="Password" id="txtPassword" name="password">
  <input type="hidden" name="action" value="login">
  <button class="btn btn-large btn-primary" type="submit">Sign in</button>
</form>
