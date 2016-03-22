<div id="<?php echo $container_tab_div; ?>" class="admin-form <?php echo $tab_content_hidden['new_project'];?>" >
  <form method="post" action="/" id="form-wizard" novalidate="novalidate">
    <div class="admin-form theme-primary light">
      <div class="panel panel-primary light">
        <div class="panel-body bg-light">
            <div class="section-divider mb40" id="spy1">
              <span>Project Direction</span>
            </div>
            <!-- .section-divider -->
            <!-- Multi Selects -->
            <div class="row">
              <div class="col-md-6">
                <label for="project_direction_bcs_non" class="field-label">Is this a BCS project?:</label>
                <div class="section">
                  <label class="field select">
                    <select id="project_direction_bcs_non" name="project_direction_bcs_non">
                      <option value="non_bcs_project" selected>Non BCS Project</option>
                      <option value="bcs_project">BCS Project</option>
                    </select>
                    <i class="arrow"></i>
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <label for="project_direction_who_for" class="field-label">Is this a school or district project?:</label>
                <div class="section">
                  <label class="field select">
                    <select id="project_direction_who_for" name="project_direction_who_for">
                      <option value="district_project" selected>District Project</option>
                      <option value="school_project">School Project</option>
                    </select>
                    <i class="arrow"></i>
                  </label>
                </div>
              </div>
            </div>

            <div id="bcs_info_container">
              <div id="bcs_info_details">
                <div class="section-divider mb40" id="spy1">
                  <span>BCS Project Details</span>
                </div>
                <!-- .section-divider -->
                <!-- Multi Selects -->
                <div class="row">
                  <div class="col-md-6">
                    <label for="project_details_heading" class="field-label">What is the BCS heading?:</label>
                    <div class="section">
                      <label class="field select">
                        <select id="project_details_heading" name="project_details_heading">
                        </select>
                        <i class="arrow"></i>
                      </label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="project_direction_who_for" class="field-label">What is the BCS Profile?:</label>
                    <div class="section">
                      <label class="field select">
                        <select id="project_details_profile" name="project_details_profile">
                        </select>
                        <i class="arrow"></i>
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div id="bcs_info_profile_school_list">
                <div class="section-divider mb40" id="spy1">
                  <span>Select the school profiles to create a project with!</span>
                </div>
                <!-- .section-divider -->
                <!-- Multi Selects -->
                <div class="panel">
                  <div class="panel-heading">
                    <span class="panel-title">Select the profiles you want to add to the project!</span>
                  </div>
                  <div class="panel-body pl15 pr15 pt10 pb10">
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <div id="bcs_profiles_school_results"></div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
        </div>
      </div>
    </div>
  </form>
  <!-- End Account2 Form -->
</div>