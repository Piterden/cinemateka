<script src="<?php echo e(asset('vendor/backpack/pnotify/pnotify.custom.min.js')); ?>"></script>

<?php /* Bootstrap Notifications using Prologue Alerts */ ?>
<script type="text/javascript">//111111
  jQuery(document).ready(function($) {

    PNotify.prototype.options.styling = "bootstrap3";
    PNotify.prototype.options.styling = "fontawesome";

    <?php foreach(Alert::getMessages() as $type => $messages): ?>
        <?php foreach($messages as $message): ?>

            $(function(){
              new PNotify({
                // title: 'Regular Notice',
                text: "<?php echo e($message); ?>",
                type: "<?php echo e($type); ?>",
                icon: false
              });
            });

        <?php endforeach; ?>
    <?php endforeach; ?>
  });
</script>
