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
                    <div class="row">
                      <div class="col-xs-12">
                        <label for="project_details_heading" class="field-label">What is the BCS heading?:</label>
                      </div>
                      <div class="col-xs-12">
                        <div class="section">
                          <label class="field select">
                            <select id="project_details_heading" name="project_details_heading">
                            </select>
                            <i class="arrow"></i>
                          </label>
                        </div>
                      </div>
                      <div id="save_default_project_details_heading" class="col-xs-2 col-sm-1 col-md-2 col-lg-1 col-xl-1 text-danger">
                        <button  type="button" class="btn btn-default btn-rounded" data-toggle="tooltip" data-placement="top" title="Save As Default!">
                          <i class="fa fa-save fa-danger"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row">
                      <div class="col-xs-12">
                        <label for="project_direction_who_for" class="field-label">What is the BCS Profile?:</label>
                      </div>
                      <div class="col-xs-12">
                        <div class="section">
                          <label class="field select">
                            <select id="project_details_profile" name="project_details_profile">
                            </select>
                            <i class="arrow"></i>
                          </label>
                        </div>
                      </div>
                      <div id="save_default_project_details_profile" class="col-xs-2 col-sm-1 col-md-2 col-lg-1 col-xl-1 text-danger">
                        <button type="button" class="btn btn-default btn-rounded" data-toggle="tooltip" data-placement="top" title="Save As Default!">
                          <i class="fa fa-save fa-danger"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="project_filter_condition" class="field-label">Filter by condition:</label>
                  <div class="section">
                    <label class="field select">
                      <select id="project_filter_condition" name="project_filter_condition">
                        <option value="none" selected>None</option>
                        <option value="critical_failure">Critical</option>
                        <option value="non_functional">Non-Functional</option>
                        <option value="unsatisfactory">Unsatisfactory</option>
                        <option value="poor">Poor</option>
                      </select>
                      <i class="arrow"></i>
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="project_filter_remaining_useful_life" class="field-label">Filter by Remaining Useful Life:</label>
                  <div class="section">
                    <label class="field select">
                      <select id="project_filter_remaining_useful_life" name="project_filter_remaining_useful_life">
                        <option value="none" selected>None</option>
                        <option value="five_years_or_less">5 Years Or Less</option>
                        <option value="six_to_ten_years">6-10 Years</option>
                        <option value="greater_than_ten_years">11 Years Or More</option>
                      </select>
                      <i class="arrow"></i>
                    </label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-6 col-sm-7 col-md-8 col-lg-9 col-xl-10">
                </div>
                <div class="col-xs-6 col-sm-5 col-md-4 col-lg-3 col-xl-2">
                <button type="button" id="search_for_school_profiles" class="btn btn-rounded btn-block btn-success pull-right">Search</button>
                </div>
              </div>
            </div>
            <div id="bcs_info_profile_school_list">
              <div class="section-divider mb40" id="spy1">
                <span>Select the school profiles to create a project with!</span>
              </div>
              <!-- begin: .admin-panels -->
              <div class="admin-panels">
                <!-- begin: .row -->
                <div class="row">
                  <div class="col-md-12 admin-grid" id="bcs_profiles_school_results"></div>
                </div>
                <!-- end: .row -->
              </div>
              <!-- end: .admin-panels -->
            </div>
        </div>
        <div class="panel-footer">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="col-sm-9 col-md-9 col-lg-9">
                <div class="col-sm-12 col-md-12 col-lg-12 spacer35">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 pull-left">
                  <button type="button" id="new_project_btn-generate_project" class="btn btn-system">Generate Non BCS Project</button>
                </div>
              </div>
              <div class="col-sm-3 col-md-3 col-lg-3">
                <div id="how_many_profiles_chosen_panel" class="col-sm-12 col-md-12 col-lg-12 pull-right">
                  <div class="panel bg-warning light of-h mb10">
                    <div class="pn pl20 p5">
                      <div class="icon-bg">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <h2 class="mt15 lh15">
                        <b><span id="how_many_profiles_chosen">0</span></b>
                      </h2>
                      <h5 class="text-muted">Profile(s) Chosen</h5>
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