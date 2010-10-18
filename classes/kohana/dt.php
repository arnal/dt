<?php

class Kohana_DT {

	protected $_value = NULL;
	protected $_config = array(
		'allow_null' => TRUE,
		'regex' => NULL,
		'rendered_input_value' => FALSE,
	);

	static public function factory($class, $value=NULL, $config=array())
	{
		$class_name = 'DT_'.ucfirst($class);
		return new $class_name($value, $config);
	}

	public function __construct($value=NULL, $config=array())
	{
		$this->_config = array_merge($this->_config, $config);

		if($value !== NULL)
		{
			$this->set($value);
		}
	}

	public function set($value)
	{
		if(isset($this->_config['type']) AND (gettype($value) != $this->_config['type']))
		{
			settype(&$value, $this->_config['type']);
		}
		$this->_value = $value;
	}

	public function render()
	{
		if($this->is_null())
		{
			return NULL;
		}
		return $this->_value;
	}

	public function __toString()
	{
		return (string) $this->render();
	}

	protected function _regex()
	{
		if(isset($this->_config['regex']))
		{
			return $this->_config['regex'];
		}
		return NULL;
	}

	public function is_valid($value=NULL)
	{
		$value = ($value !== NULL) ? $value : $this->_value;

		if(isset($this->_config['allow_null']) 
				AND ($this->_config['allow_null'] == FALSE) 
				AND ($value === NULL))
		{
			return FALSE;
		}

		if($value !== NULL)
		{
			if(isset($this->_config['type']) AND gettype($value) != $this->_config['type'])
				return FALSE;

			if($regex = $this->_regex())
			{
				if(!preg_match("/$regex/", $value))
					return FALSE;
			}
		}

		return TRUE;
	}

	public function is_null()
	{
		if($this->_value === NULL)
			return TRUE;

		return FALSE;
	}

	protected function _input_value()
	{
		$value = $this->_value;
		if(isset($this->_config['rendered_input_value']) AND ($this->_config['rendered_input_value'] === TRUE))
		{
			$value = $this->render();
		}
		return $value;
	}

	public function input($name)
	{
		return Form::input($name, $this->_input_value()); 
	}
}
