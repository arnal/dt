<?php

class DT_Enum extends DT_String {

	protected $_possible_values = array();

	protected function _regex()
	{
		return '('.join($this->_possible_values,'|').')';
	}

	public function input($name)
	{
		$values = $this->_possible_values;
		if((isset($this->config['allow_null']) AND ($this->config['allow_null'] == TRUE) OR !isset($this->config['allow_null'])))
		{
			$values = array_merge(array('' => '-- no select --'), $values);
		}
		return Form::select($name, $values, ($this->is_valid() ? $this->_value : NULL));
	}
}
