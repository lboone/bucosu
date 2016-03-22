<?php

class Bcs_qs
{
	private $questions;
	private $question;
	private $type;

	public function __construct($qData = array()) {
	 	if (isset($qData)){
			$this->questions = $qData;
		} else {
		 	throw new Exception(__CLASS__ . ' error : You must provide the questions as an object array!');
		}
	}

	public function set_question($cQ){
		$this->question = $cQ;
		$this->type = $cQ->type;
	}

	public function html()
	{
			echo '<table>';
			foreach ($this->questions as $qVal) {
				echo '<tr>';
				$this->set_question($qVal);

				$this->render_question();
				$this->question_html();
				$this->render_description();
				echo '</tr>';
			}
			echo '</table>';		
	}

	public function question_html()
	{
		$qType = strtolower($this->type);
		$funct = 'render_' . $qType;
		$this->$funct();
	}

	private function render_yn(){
?>
		<td>
		<?php $rows = array(
						array('val'=>'yes',
							  'label'=>'Yes'),
						array('val'=>'no',
							  'label'=>'No'),
		)?>
		<?php foreach ($rows as $row): ?>
			<label class="radio-inline mr10">
				<input type="radio" name="<?php echo $this->question->slug;?>" id="radio_<?php echo $this->question->slug . '_' . $row['val']; ?>" value="<?php echo $row['val']; ?>"><?php echo trim($row['label']); ?>
			</label>	
		<?php endforeach; ?>
		</td>
<?php
	}

	private function render_text(){
?>
		<td>
			<textarea class="form-control" name="<?php echo $this->question->slug;?>" id="<?php echo $this->question->slug;?>" rows="1"></textarea>
		</td>
<?php
	}

	private function render_multi(){
?>
		<td>
	        <?php $rows = $this->get_values();?>
			<?php foreach ($rows as $row): ?>
				<div class="bs-component">
            		<div class="checkbox-custom mb5">
						<input type="checkbox" name="<?php echo $this->question->slug;?>[]" id="<?php echo $this->question->slug . '_' . $row['val']; ?>" value"<?php echo $row['val']; ?>">
        				<label for="<?php echo $this->question->slug . '_' . $row['val']; ?>"><?php echo trim($row['label']); ?></label>
        		   	</div>
        		</div>
			<?php endforeach; ?>
		</td>
<?php
	}

	private function render_single(){
?>
		<td>
		<?php $rows = $this->get_values();?>
		<?php foreach ($rows as $row): ?>
			<label for="radio_<?php echo $this->question->slug . '_' . $row['val']; ?>" class="radio-inline mr10">
				<input type="radio" name="<?php echo $this->question->slug;?>" id="radio_<?php echo $this->question->slug . '_' . $row['val']; ?>" value="<?php echo $row['val']; ?>">
				<span class="radio"></span>
				<?php echo trim($row['label']); ?>
			</label>	
		<?php endforeach; ?>
		</td>
<?php
	}

	private function render_number(){
?>
		<td>
			<div class="input-group">
				<input name="<?php echo $this->question->slug; ?>" id="<?php echo $this->question->slug; ?>" class="form-control" type="text" placeholder="Numbers">
				<span class="input-group-addon">00</span>
			</div>
		</td>
<?php
	}

	private function render_currency(){
?>
		<td>
			<div class="input-group">
                <span class="input-group-addon">
            		<i class="fa fa-usd"></i>
            	</span>
            	<input type="text" name="<?php echo $this->question->slug; ?>" id="<?php echo $this->question->slug; ?>" class="form-control money" maxlength="10" autocomplete="off" placeholder="000.000.000.000">
            </div>
		</td>
<?php
	}

	private function render_date(){
?>
		<td>
			<div class="input-group date" id="<?php echo $this->question->slug; ?>">
				<span class="input-group-addon cursor">
					<i class="fa fa-calendar"></i>
				</span>
				<input type="text" class="form-control" name="<?php echo $this->question->slug; ?>" id="<?php echo $this->question->slug; ?>">
			</div>
		</td>
<?php
	}

	private function render_paragraph(){
?>
		<td>
			<?php echo 'paragraph'; ?>
		</td>
<?php
	}

	private function render_file(){
?>
		<td>
			<?php echo 'file'; ?>
		</td>
<?php
	}

	private function render_image(){
?>
		<td>
			<?php echo 'image'; ?>
		</td>
<?php
	}

	private function render_phone_number(){
?>
		<td>
			<div class="input-group">
				<span class="input-group-addon">
					<i class="fa fa-phone"></i>
				</span>
				<input type="text" name="<?php echo $this->question->slug; ?>" id="<?php echo $this->question->slug; ?>" class="form-control phone" maxlength="10" autocomplete="off" placeholder="(999) 999-9999">
			</div>
		</td>
<?php
	}

	private function render_email(){
?>
		<td>
			<div class="input-group">
			  <span class="input-group-addon">
			    <i class="fa fa-envelope-o"></i>
			  </span>
			  <input class="form-control" name="<?php echo $this->question->slug; ?>" id="<?php echo $this->question->slug; ?>" type="text" placeholder="Email address">
			</div>
		</td>
<?php
	}


	private function render_question()
	{
		echo '<td>';
		echo $this->question->alpha;
		echo '</td>';
		echo '<td>';
		echo $this->question->text;
		if (!trim($this->question->reminder) == '') {
			echo'<span class="help-block mt5">';
            echo'<i class="fa fa-bell"></i> ';
            echo $this->question->reminder;
            echo '</span>';
		}
		echo '</td>';
	}

	private function render_description()
	{
		echo '<td>';
		if (intval($this->question->show_description)) {
			echo '<input type="text" id="' . $this->question->slug . '_description" class="form-control" placeholder="' . $this->question->description_placeholder . '...">';
		}
		echo '</td>';
	}
	private function get_values()
	{
		$values = explode(';',$this->question->values);
		foreach ($values as $v) {
			$r = explode('|',$v);
			$rows[] = array('label'=>$r[0], 'val'=>$r[1]);
		}
		return $rows;
	}

}  //End class
?>