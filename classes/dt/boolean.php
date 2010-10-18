<?php

class DT_Boolean extends DT {

	protected $_config = array(
		'type' => 'boolean',
	);

	public function input($name, $attributes=NULL)
	{
		return Form::checkbox($name, 1, ($this->is_valid() ? $this->_value : NULL), $attributes);
	}
}
