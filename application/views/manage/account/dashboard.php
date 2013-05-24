
<h1>Dashboard</h1>
<p><strong>Welcome <?php echo $this->session->userdata('admin_username'); ?>.</strong></p>

<p>The following administration tools are available to you:</p>
<ul>
  <li><a href="<?php echo site_url('manage/users'); ?>">Manage admin accounts</a></li>
</ul>

<p>You can also:</p>
<ul>
  <li><a href="<?php echo site_url('manage/account/change-password'); ?>">Change your password</a></li>
  <li><a href="<?php echo site_url('manage/login/logout'); ?>">Log out</a></li>
</ul>