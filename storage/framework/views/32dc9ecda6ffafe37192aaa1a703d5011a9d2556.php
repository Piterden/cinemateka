<nav>
  <div class="nav-wrapper">
    <a v-link="{ path: '/' }" class="brand-logo left">
      <img src="<?php echo e(config('app.logo.img')); ?>" alt="<?php echo e(config('app.logo.alt')); ?>">
    </a>
    <ul>
      <?php foreach($menuItems as $item): ?>
      <li>
        <a v-link="{ path: '/<?php echo e($item->link); ?>' }"><?php echo e($item->name); ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
    <a href="http://seance.ru" class="brand-logo right" target="_blank">
      <img src="<?php echo e(config('app.logo.s-img')); ?>" alt="<?php echo e(config('app.logo.alt')); ?>">
    </a>
  </div>
</nav>
