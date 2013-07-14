      <footer>
        <p>&copy; <?php echo date('Y'); ?> Consumer Futures</p>
      </footer>

    </div> <!-- /container -->

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <?php if(isset($page_scripts) && !empty($page_scripts)) :?>
      <?php foreach($page_scripts as $script) : ?>
        <script type="text/javascript" src="<?php echo $script; ?>"></script>
      <?php endforeach; ?>
    <?php endif; ?>
  </body>
</html>