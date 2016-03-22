<?php
class Questions_model extends MY_Model 
{
	protected $_table_name = 'bcs_questions';
	protected $_order_by = 'order';

	public function __construct()
	{
		parent::__construct();
	}


	protected function _get_questions($active=TRUE){
		// Look up the bcs_headings and requrn them as objects.
	}

	protected function _get_question($questionSlug = NULL)
	{

	}	


}