<div id="project_purposes_table_container"><?php if(isset($project_purposes_table)){echo $project_purposes_table;}?></div>


<div id="dialog-form-project_purpose" title="Create new project purpose">
  <p class="validateTips">All form fields are required.</p>
  <form>
    <fieldset>
      <label for="project_purpose">Project Purpose</label>
      <input type="text" name="project_purpose" id="project_purpose_field" value="" class="text ui-widget-content ui-corner-all">

      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>