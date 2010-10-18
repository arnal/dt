<?php

class DT_Date extends DT_String {

	protected $_config = array(
		'regex' => '^\d{4}-\d{2}-\d{2}$',
		'rendered_input_value' => TRUE,
	);

	public function set($value)
	{
		if(is_int($value))
		{
			$value = date('Y-m-d', $value);
		}
		elseif(! $this->is_valid($value))
		{
			if($time=strtotime($value))
			{
				$value = date('Y-m-d', $time);
			}
		}
		return parent::set($value);
	}

	public function render()
	{
		if($this->is_valid() AND ! $this->is_null())
		{
			return date('j.n.Y', strtotime($this->_value));
		}
		return NULL;
	}
}
