<aside class="tray tray-left sb-r-o tray320" data-tray-height="match" style="height: 981px;">
	<div class="tab-block mb25">
	  <ul class="nav nav-tabs tabs-border">
	    <li class="active">
	      <a href="#tab8_1" data-toggle="tab">BCS Event</a>
	    </li>
	    <li>
	      <a href="#tab8_2" data-toggle="tab"><i class="fa fa-bolt text-purple"></i> Default Settings</a>
	    </li>
	  </ul>
	  <div class="tab-content">
	    <div id="tab8_1" class="tab-pane active">	    	
		<!-- begin default_event_selection -->
			<?php if(isset($event_tree)){ echo $event_tree; } ?>
		<!-- end default_event_selection -->
	    </div>
	    <div id="tab8_2" class="tab-pane">
	      <!-- begin default_event_selection -->
		  <?php if(isset($default_event_selection)){ echo $default_event_selection; } ?>
		  <!-- end default_event_selection -->
	    </div>
	  </div>
	</div>
</aside>





