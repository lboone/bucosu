		<?php echo form_hidden(array('qid_'.$q->slug => $q->id)); ?>
		</div>
	</div>
	<?php if (isset($question_js)): ?>
		<div id="question_js_<?php echo $q->id;?>">
			<?php echo $question_js; ?>
		</div>		
	<?php endif ?>
</div>