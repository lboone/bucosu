      <!-- Start: Topbar -->
      <header id="topbar" class="hidden-print">
        <div class="topbar-left">
          <ol class="breadcrumb">
            <li class="crumb-active">
              <a href="<?php echo rtrim($bread_crumbs[count($bread_crumbs)-1]['url'],'/'); ?>"><?php echo strtoupper($bread_crumbs[count($bread_crumbs)-1]['label']); ?></a>
            </li>
            <li class="crumb-icon">
              <a href="<?php echo $bread_crumbs[0]['url']; ?>">
                <span class="glyphicon glyphicon-home"></span>
              </a>
            </li>

            <?php for ($i = 0; $i < count($bread_crumbs)-1; $i++): ?>
            <li class="crumb-link">
              <a href="<?php echo $bread_crumbs[$i]['url']?>"><?php echo $bread_crumbs[$i]['label']; ?></a>
            </li>
          <?php endfor; ?>
            <li class="crumb-trail"><?php echo $bread_crumbs[count($bread_crumbs)-1]['label']; ?></li>
          </ol>
        </div>

        <?php 
          if(isset($right_topbar)){
            echo $right_topbar;
          } 
        ?>

<!--      <div class="topbar-right">
          <div class="ib topbar-dropdown">
            <label for="topbar-multiple" class="control-label pr10 fs11 text-muted">Reporting Period</label>
            <select id="topbar-multiple" class="hidden">
              <optgroup label="Filter By:">
                <option value="1-1">Last 30 Days</option>
                <option value="1-2" selected="selected">Last 60 Days</option>
                <option value="1-3">Last Year</option>
              </optgroup>
            </select>
          </div>
          <div class="ml15 ib va-m" id="toggle_sidemenu_r">
            <a href="#" class="pl5">
              <i class="fa fa-sign-in fs22 text-primary"></i>
              <span class="badge badge-danger badge-hero">3</span>
            </a>
          </div>
        </div> -->
        <?php if (isset($show_right_view)): ?>
          <div class="topbar-right">
            <div class="ml15 ib va-m" id="toggle_sidemenu_r">
                <a href="#" class="pl5">
                  <i class="fa fa-sign-in fs22 text-primary"></i>
                </a>
              </div>
            </div>
          <!-- End: Topbar -->
        <?php endif ?>
      </header>