<?php

class DT_Boolean extends DT {

	protected $_config = array(
		'type' => 'boolean',
	);

	public function input($name, $attributes=NULL)
	{
		return Form::checkbox($name, 1, ($this->is_valid() ? $this->_value : NULL), $attributes) 
				. ((isset($this->_config['msg']) AND $this->_config['msg']) ? '&nbsp;&nbsp;'.$this->_config['msg'] : '');
	}
}
