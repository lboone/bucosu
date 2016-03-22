<aside class="tray tray-left tray320" style="height: 867px;">

  <div class="" data-animate="["200","fadeIn"]">

    <h4> BUCOSU -<small>help documentation</small></h4>
    
    <div id="nav-spy">
      <ul class="nav tray-nav tray-nav-border affix-top" data-nav-animate="zoomIn" data-smoothscroll="-125" data-spy="affix" data-offset-top="240">
        <?php foreach ($types as $key => $value): ?>
          <li class="animated animated-short zoomIn active">
            <a href="#<?php echo $key;?>">
            <span class="fa fa-angle-double-right fa-lg"></span> <?php echo $keys[$key]; ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </div>

  </div>

</aside>