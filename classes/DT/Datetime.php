<?php

class DT_DateTime extends DT_String {

	protected $_config = array(
		'allow_null' => TRUE,
		'rules' => array(
			array('regex', '/^(\d{4}-\d{2}-\d{2} \d{2}:\d{2}|)$/'),
		),
		'rendered_input_value' => TRUE,
	);

	public function input($name, $attributes=NULL)
	{
		return parent::input($name, array('class' => 'input-medium')); 
	}

	public function set($value)
	{
		if($value == '' OR $value === NULL)
		{
			$value = NULL;
		}
		elseif(is_int($value))
		{
			$value = date('Y-m-d H:i', $value);
		}
		elseif(! $this->is_valid($value))
		{
			if($time=strtotime($value))
			{
				$value = date('Y-m-d H:i', $time);
			}
		}
		return parent::set($value);
	}

	public function render($html=FALSE)
	{
		if($this->is_valid() AND ! $this->is_null())
		{
			return date('j.n.Y H:i', strtotime($this->_value));
		}
		return NULL;
	}
}
