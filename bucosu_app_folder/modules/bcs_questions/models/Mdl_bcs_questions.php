<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Mdl_bcs_questions extends MY_Model {
											// DEFAULTS:
	protected $_table_name = 'bcs_questions';			// ALWAYS ADD 
	protected $_order_by = 'q_order';				// ----------

	protected $_primary_key = 'id';			// REMOVE IF SAME / CHANGE IF DIFFERENT
	protected $_primary_filter = 'intval';	// ------------------------------------
	protected $_timestamps = TRUE;			// ------------------------------------
	

	function __construct(){
		parent::__construct();
	}



	function question_answers($type='result'){
		/*
		 * $this->db->select("select bucosu-bcs.bcs_questions.id AS id,bcs_questions.text AS text,bcs_questions.slug AS slug,bcs_questions.type AS type,
		 * bcs_questions.kind AS kind,bcs_questions.rule AS rule,bcs_questions.q_order AS q_order,bcs_questions.profile_id AS profile_id,
		 * bcs_questions.bcs_question_number AS bcs_question_number,bcs_questions.alpha AS alpha,bcs_questions.values AS values,bcs_questions.reminder AS reminder,
		 * bcs_questions.is_bcs AS is_bcs,bcs_questions.is_capital_planning AS is_capital_planning,bcs_questions.show_description AS show_description,
		 * bcs_questions.description_placeholder AS description_placeholder,bcs_questions.active AS active,bcs_questions_school.profile_school_id AS profile_school_id,
		 * bcs_questions_school.answer AS answer,bcs_questions_school.description AS description from 
		 * (bcs_questions join bcs_questions_school on((bcs_questions.id = bcs_questions_school.question_id))) order by bcs_questions.id");
		 */
		
		$this->db->select('*');
		$this->db->from('bcs_questions');
		$this->db->join('bcs_questions_school','bcs_questions_school.question_id = bcs_questions.id');		
		return $this->db->get()->$type();
	}
}