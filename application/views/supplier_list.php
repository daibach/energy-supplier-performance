<h2>Energy suppliers</h2>

<p>Select a supplier to view their complaint handling data:</p>

<ul>
  <?php foreach($suppliers as $supplier) : ?>
    <li><a href="<?php echo site_url(array('supplier',$supplier->supplier_slug)); ?>"><?php echo $supplier->supplier_name; ?></a>
      <?php if($supplier->supplier_annotation != '') : ?>
        (<span class="supplier-includes"><?php echo $supplier->supplier_annotation; ?></span>)
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>