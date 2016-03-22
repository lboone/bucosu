<div class="tray tray-center" style="height: 912px;">
  <!-- Begin: Admin Panel Wrapper -->
  <div class="admin-panels mw1200 center-block ui-sortable animated fadeIn" style="padding-bottom: 125px; height: 3183px;">

      <!-- AdminPanel Row - General Options -->
      <div class="row mt20">

        <div class="col-md-12 admin-grid" data-animate="["400","fadeIn"]" id="grid-0">

          <?php foreach ($types as $key => $values): ?>
            <!-- Basic AdminPanel - All features disabled except "minimized" option -->
            <div class="panel sort-disable mb50" id="<?php echo $key;?>" data-panel-color="false" data-panel-fullscreen="false" data-panel-remove="false" data-panel-title="false">
              <div class="panel-heading">
              <!-- Top of the heading -->
                <span class="panel-icon">
                  <i class="fa fa-question"></i>
                </span>
                <span class="panel-title"> <?php echo $keys[$key]; ?></span>

              <!-- Bottome of the heading-->
              </div>
              <div class="panel-body">
              <!-- Top of the body -->
                <div class="tab-block mb25">
                  <ul class="nav nav-tabs tabs-border nav-justified">
                    <?php $class = 'active'; $expanded="true"; ?>
                    <?php foreach ($values as $help): ?>
                      <li class="<?php echo $class; ?>">
                        <a href="#<?php echo $key . '_' . $help->id; ?>" data-toggle="tab" aria-expanded="<?php echo $expanded; ?>"><?php echo $help->title; ?></a>
                      </li>                             
                      <?php $class = ''; $expanded="false"; ?>     
                    <?php endforeach ?>                
                  </ul>

                  <div class="tab-content">
                    <?php $class = 'tab-pane active';?>
                    <?php foreach ($values as $help): ?>
                      <div id="<?php echo $key . '_' . $help->id; ?>" class="<?php echo $class; ?>">
                        <?php echo $help->help_text; ?>
                      </div>
                    <?php $class = 'tab-pane';?>    
                    <?php endforeach ?>                                
                  </div>
                </div>
              <!-- Bottom of the body -->
              </div>
           </div>          
          <?php endforeach ?>
        </div>
      </div>
  </div>
  <!-- End: Admin Panel Wrapper -->
</div>