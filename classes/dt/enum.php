<?php

class DT_Enum extends DT_String {

	protected function _init_config()
	{
		return array(
			'possible_values' => array(),
			'rules' => array(
				array('regex', '/^('.join(array_keys($this->_config['possible_values']),'|').')$/'),
			),
		);
	}

	public function input($name, $attributes=NULL)
	{
		$values = $this->_config['possible_values'];
		if((isset($this->config['allow_null']) AND ($this->config['allow_null'] == TRUE) OR !isset($this->config['allow_null'])))
		{
			$values = array_merge(array('' => '-- no select --'), $values);
		}
		return Form::select($name, $values, ($this->is_valid() ? $this->_value : NULL), $attributes);
	}
}
