<h1>User accounts</h1>

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

    <?php if($users) : ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>User</th>
            <th>Status</th>
            <th>Tools</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($users as $user) : ?>
            <tr<?php if($user->status=='inactive') : ?> class="warning"<?php endif; ?>>
              <td><?php echo $user->email; ?></td>
              <td><?php echo $user->status; ?></td>
              <?php if($user->id != $this->session->userdata('admin_userid')) : ?>
                <td>
                  <a class="btn btn-info btn-small" href="<?php echo site_url(array('manage','users','reset-password',$user->id)); ?>">Send new password</a>
                  <?php if($user->status=='active') : ?>
                    <a class="btn btn-warning btn-small" href="<?php echo site_url(array('manage','users','suspend',$user->id)); ?>">Suspend</a>
                  <?php else : ?>
                    <a class="btn btn-success btn-small" href="<?php echo site_url(array('manage','users','activate',$user->id)); ?>">Activate</a>
                  <?php endif; ?>
                  <a class="btn btn-danger btn-small" href="<?php echo site_url(array('manage','users','delete',$user->id)); ?>">Delete</a>
                </td>
              <?php else : ?>
                <td><span class="label label-info">This is you!</span></td>
              <?php endif ;?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert alert-info">There are currently no users</div>
    <?php endif; ?>

  </div>
  <div class="span4">
    <div class="well">
      <form action="<?php echo site_url('manage/users/create'); ?>" method="post">
        <h3>Create an account</h3>
        <div class="control-group">
          <label class="control-label" for="email">Email address:</label>
          <div class="controls">
            <input type="text" id="email" name="email" placeholder="Email">
          </div>
        </div>
        <div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary">Create new account</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
