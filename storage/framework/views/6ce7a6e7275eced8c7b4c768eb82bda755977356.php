<!-- seporator field -->
<div class="separator col-md-<?php echo e(isset($field['colspan']) ? $field['colspan'] : 12); ?> <?php echo e(isset($field['cssclass']) ? $field['cssclass'] : ''); ?>"
	style="<?php echo e(isset($field['cssstyle']) ? $field['cssstyle'] : 'margin:15px 0 10px;'); ?>">
	<h3><?php echo e(isset($field['label']) ? $field['label'] : ''); ?></h3>
</div>
