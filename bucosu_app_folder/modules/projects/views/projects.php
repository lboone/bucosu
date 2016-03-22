<div class="tray tray-center" style="height: 742px;">
	<div class="content-header">
	  <h2> With <b class="text-primary">BUCOSU - Projects</b>, 5 Years Plans are a snap!.</h2>
	  <p class="lead">Below, select the district & school events, to begin!</p>
	</div>


	<div class="admin-form theme-primary">
	  <div class="panel heading-border panel-primary">
	    <div class="panel-body bg-light">
	      <form method="post" action="" id="form-ui">
	        <div class="section-divider mb40" id="spy1">
	          <span id="projects_choose_title">Select School District & School BCS Events</span>
	        </div>
	        <!-- .section-divider -->

	        <!-- Multi Selects -->
	        <div class="row">
	          <div class="col-md-6" id="projects_choose_school_district">
	          	<label for="school_district_select" class="field-label">Choose your school district event:</label>
	            <div class="section">
	              <label class="field select">
	                <select id="school_district_select" name="school_district_select">
	                </select>
	                <i class="arrow"></i>
	              </label>
	            </div>
	          </div>
	          <div class="col-md-6" id="projects_choose_school">
	          	<label for="school_select" class="field-label">Choose your school event:</label>
	            <div class="section">
	              <label class="field select">
	                <select id="school_select" name="school_select">
	                </select>
	                <i class="arrow"></i>
	              </label>
	            </div>
	          </div>
	        </div>
	      </form>
	    </div>
	  </div>
	</div>

          <div class="page-tabs">
            <ul class="nav nav-tabs">
              <li <?php echo $active_tab['new_project']; ?>>
                <a href="/projects/new_project">New Project</a>
              </li>
              <li <?php echo $active_tab['view_projects']; ?>>
                <a href="/projects/view_projects">View Projects</a>
              </li>
              <li <?php echo $active_tab['view_project'];?>>
                <a href="/projects/view_project">View/Edit A Project</a>
              </li>
              <li <?php echo $active_tab['project_reports'];?>>
                <a href="/projects/project_reports">Project Reports</a>
              </li>
			  <li <?php echo $active_tab['project_report'];?>>
                <a href="/projects/project_report">Project Report</a>
              </li>
            </ul>
          </div>

          <div style="max-width: 100%;">
          	<div id="#<?php if (isset($container_div)){ echo $container_div;} else { echo 'default_container';}?>">

          		<!-- TAB - NEW PROJECT -->
          		<?php echo $tab_content['new_project']; ?>

          		<!-- TAB - VIEW PROJECTS -->
          		<?php echo $tab_content['view_projects']; ?>
				
				<!-- TAB - VIEW PROJECT -->
          		<?php echo $tab_content['view_project'] ?>

          		<!-- TAB - PROJECT REPORTS -->
          		<?php echo $tab_content['project_reports'] ?>

          		<!-- TAB - PROJECT REPORT -->
          		<?php echo $tab_content['project_report'] ?>

          	</div>
          </div>
 </div>


