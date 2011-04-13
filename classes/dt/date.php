<?php

class DT_Date extends DT_String {

	protected $_config = array(
		'allow_null' => TRUE,
		'rules' => array(
			array('regex', '/^(\d{4}-(\d{1,2}|\?\?)-(\d{1,2}|\?\?)|)$/'),
		),
		'rendered_input_value' => TRUE,
	);

	public function set($value)
	{
		if($value == '' OR $value === NULL OR $value == '0000-00-00')
		{
			$value = NULL;
		}
		elseif(is_int($value))
		{
			$value = date('Y-m-d', $value);
		}
		elseif(preg_match('/([\d\?]+).([\d\?]+).(\d{4})/', $value, $m))
		{
			$value = $m[3].'-'.$m[2].'-'.$m[1];
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
			if(strpos($this->_value,'?')>0)
			{
				preg_match('/(\d{4})-([\d\?]+)-([\d\?]+)/', $this->_value, $m);
				return $m[3].'.'.$m[2].'.'.$m[1];
			}
			else
			{
				return date('j.n.Y', strtotime($this->_value));
			}
		}
		return NULL;
	}
}
