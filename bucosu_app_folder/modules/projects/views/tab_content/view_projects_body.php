<?php 
	if (isset($project_data)) {
		foreach ($project_data as $key => $value) {
			echo '<tr>';
			echo '<td class="pl20">' . $value->school_name . '</td>';
			echo '<td class="pl20">' . $value->item_description . '</td>';
			echo '<td class="pl20 hidden-xs">' . $value->purpose . '</td>';
			echo '<td class="pl20 hidden-xs">' . $value->type . '</td>';
			echo '<td class="text-center hidden-xs hidden-sm">' . $value->year_to_complete . '</td>';
			echo '<td class="text-center hidden-xs hidden-sm">' . $value->priority . '</td>';
			echo '<td class="text-center hidden-xs hidden-sm">' . $value->bcs_question_number . '</td>';
			echo '<td class="text-right pr20">$' . $value->cost . '</td>';
			echo '<td class="text-right pr40 hidden-xs hidden-sm">' . $value->status . '</td>';
			echo '<td class="text-center hidden-print"><a href="http://bucosu.com/projects/view_project?id=' . $value->id . '" id="edit_'.$value->id.'">Edit</a> | <a href="http://bucosu.com/projects/delete_project?id='. $value->id .'" class="project_delete_button text-danger" id="delete_'.$value->id.'">Delete</a></td>';
			echo '</tr>';		
		}	
	}
?>
