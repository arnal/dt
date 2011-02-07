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
		if((isset($this->_config['allow_null']) AND ($this->_config['allow_null'] == TRUE) OR !isset($this->_config['allow_null'])))
		{
			$values = array_merge(array('' => '-- vyberte --'), $values);
		}
		return Form::select($name, $values, ($this->is_valid() ? $this->_value : NULL), $attributes);
	}

	public function render()
	{
		return @$this->_config['possible_values'][$this->_value];
	}
}
