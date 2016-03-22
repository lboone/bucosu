<!-- begin: .admin-panels -->
<div class="admin-panels fade-onload">

  <!-- begin: .row -->
  <div class="row">

    <!-- begin: #dashboard-column-1 -->
    <div id="dashboard-column-1" class="col-md-6 admin-grid">

      <!-- begin: #dashboard-c1-p1 -->
      <div id="dashboard-c1-p1" class="panel panel-primary">
          <div class="panel-heading">
            <span class="panel-title">
              <span class="glyphicon glyphicon-map-marker"></span>School Locations</span>
          </div>
          <div class="panel-body">
            <div id="map_canvas3" class="map"></div>
          </div>
      </div>
      <!-- end: #dashboard-c1-p1 -->

      <!-- begin: #dashboard-c1-p2 -->
      <div id="dashboard-c1-p2" class="panel panel-success">
          <div class="panel-heading">
            <span class="panel-title">Estimated Cost</span>
          </div>
          <div class="panel-body panel-scroller scroller-lg scroller-pn pn">
            <table class="table mbn tc-list-1 tc-text-muted-2 tc-fw600-2">
              <thead>
                <tr class="">
                  <th class="w30"></th>
                  <th>School</th>
                  <th>Est. Cost</th>
                </tr>
              </thead>
              <tbody>
              	<?php $x = 1; ?>
              	<?php foreach ($costs as $cost): ?>
                  <tr>
                    <td><?php echo $x . "."; ?></td>
                    <td><a href="http://bucosu.com/bcs/event/<?php echo $cost['event_sd_id'];?>/<?php echo $cost['event_school_id'];?>"><?php echo $cost['school_name']; ?></a></td>
                    <td><?php echo $cost['estimated_cost']; ?></td>
                  </tr> 
                  <?php $x = $x + 1; ?>                   		
              	<?php endforeach ?>
              </tbody>
            </table>
          </div>    
      </div>
    <!-- end: #dashboard-c1-p2 -->

    </div>
    <!-- end: #dashboard-column-1 -->

    <!-- begin: #dashboard-column-2 -->
    <div id="dashboard-column-2" class="col-md-6 admin-grid">

      <!-- begin: #dashboard-c2-p1 -->
      <div id="dashboard-c2-p1" class="panel panel-alert">
         <div class="panel-heading">
            <span class="panel-title">BCS Complete Percent</span>
          </div>
          <div class="panel-body panel-scroller scroller-lg scroller-pn pn">
            <table class="table mbn tc-list-1 tc-text-muted-2 tc-fw600-2">
              <thead>
                <tr class="">
                  <th class="w30"></th>
                  <th>School</th>
                  <th>Count</th>
                  <th>Perc</th>
                </tr>
              </thead>
              <tbody>
               <?php $x = 1; ?>
              	<?php foreach ($completeds as $completed): ?>
                  <tr>
                    <td><?php echo $x . "."; ?></td>
                    <td><a href="http://bucosu.com/bcs/event/<?php echo $completed['event_sd_id'];?>/<?php echo $completed['event_school_id'];?>"><?php echo $completed['school_name']; ?></a></td>
                    <td><?php echo $completed['total_completed_bcs_profiles']; ?></td>
                    <td><?php echo $completed['percent_complete']; ?></td>
                  </tr> 
                  <?php $x = $x + 1; ?>                   		
              	<?php endforeach ?>
              </tbody>
            </table>
          </div>
      </div>
      <!-- end: #dashboard-c2-p1 -->

      <!-- begin: #dashboard-c2-p2 -->
      <div id="dashboard-c2-p2" class="panel panel-danger">
          <div class="panel-heading">
            <span class="panel-title">School Issues</span>
          </div>
          <div class="panel-body panel-scroller scroller-lg scroller-pn pn">
            <table class="table mbn tc-list-1 tc-text-muted-2 tc-fw600-2">
              <thead>
                <tr class="">
                  <th class="w30"></th>
                  <th>School</th>
                  <th><a href="#" data-toggle="tooltip" title="Unsatisfactory">U</a></th>
                  <th><a href="#" data-toggle="tooltip" title="Poor">P</a></th>
                  <th><a href="#" data-toggle="tooltip" title="Non-Functional">N</a></th>
                  <th><a href="#" data-toggle="tooltip" title="Critical">C</a></th>
                  <th>Tot</th>
                </tr>
              </thead>
              <tbody>
                  <?php $x = 1; ?>
              	<?php foreach ($issues as $issue): ?>
                  <tr>
                    <td><?php echo $x . "."; ?></td>
                    <td>
                      <a href="http://bucosu.com/bcs/event/<?php echo $issue['event_sd_id'];?>/<?php echo $issue['event_school_id'];?>"><?php echo $issue['school_name']; ?></a>
                    </td>
                    
                    <?php if ($issue['U'] > 0): ?>
                        <td><a href=""><?php echo $issue['U']; ?></a></td>  
                    <?php else: ?>
                        <td><?php echo $issue['U']; ?></td>
                    <?php endif ?>
                    
                    <?php if ($issue['P'] > 0): ?>
                        <td><a href=""><?php echo $issue['P']; ?></a></td>  
                    <?php else: ?>
                        <td><?php echo $issue['P']; ?></td>
                    <?php endif ?>

                    <?php if ($issue['N'] > 0): ?>
                        <td><a href=""><?php echo $issue['N']; ?></a></td>  
                    <?php else: ?>
                        <td><?php echo $issue['N']; ?></td>
                    <?php endif ?>

                    <?php if ($issue['C'] > 0): ?>
                        <td><a href=""><?php echo $issue['C']; ?></a></td>  
                    <?php else: ?>
                        <td><?php echo $issue['C']; ?></td>
                    <?php endif ?>

                    <?php if ($issue['issues_total'] > 0): ?>
                        <td><a href=""><?php echo $issue['issues_total']; ?></a></td>  
                    <?php else: ?>
                        <td><?php echo $issue['issues_total']; ?></td>
                    <?php endif ?>
                    
                  </tr> 
                  <?php $x = $x + 1; ?>                   		
              	<?php endforeach ?>
              </tbody>
            </table>
          </div>
      </div>
      <!-- end: #dashboard-c2-p2 -->

    </div>
    <!-- end: #dashboard-column-2 -->

  </div>
  <!-- end: .row -->

</div>
<!-- end: .admin-panel -->