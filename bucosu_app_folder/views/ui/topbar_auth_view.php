<?php 
  $navs = $nav_menu['menu_items'];
  $buttons = $nav_menu['buttons'];
  $nav_active = $nav_menu['active'];
?>
   <!-- Start: Topbar -->
      <header id="topbar" class="ph10 hidden-print">
        <div class="topbar-left">
          <ul class="nav nav-list nav-list-topbar pull-left">
          <?php foreach ($navs as $key => $value): ?>
            <?php if ($key == $nav_active): ?>
              <li class="active">
            <?php else:?>
              <li>
            <?php endif ?>
              <a href="<?php echo $value['url'];?>"><?php echo $value['label'];?></a>
            </li>
          <?php endforeach; ?>
          </ul>
        </div>
        <div class="topbar-right hidden-xs hidden-sm">
        <?php if ($buttons): ?>
          <?php foreach ($buttons as $button): ?>
            <a href="<?php echo $button['url'];?>" class="btn btn-default btn-sm light fw600 ml10">
              <span class="fa <?php echo (!isset($button['logo'])) ? 'fa-plus' : $button['logo'];?> pr5"></span> <?php echo $button['label'];?></a>
          <?php endforeach; ?>
        <?php endif; ?>
        </div>
      </header>
      <!-- End: Topbar -->

      <?php
