<?php

class Kohana_DT {

	protected $_value = NULL;
	protected $_config = array(
		'allow_null' => TRUE,
		'regex' => NULL,
		'rendered_input_value' => FALSE,
		'filters' => array(),
		'rules' => array(),
	);

	static public function factory($class, $value=NULL, $config=array())
	{
		$class_name = 'DT_'.ucfirst($class);
		return new $class_name($value, $config);
	}

	public function __construct($value=NULL, $config=array())
	{
		$this->_set_config($config);
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
		if(isset($this->_config['filters']))
		{
			foreach($this->_config['filters'] as $filter)
			{
				$value = call_user_func($filter, $value);
			}
		}
		$this->_value = $value;
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

			if(isset($this->_config['rules']))
			{
				foreach($this->_config['rules'] as $rule)
				{
					$func_name = $rule[0];
					if(! Validate::$func_name($value, @$rule[1], @$rule[2], @$rule[3]))
						return FALSE;
				}
			}
		}
		return TRUE;
	}

	public function is_null()
	{
		return ($this->_value === NULL);
	}

	public function input($name, $attributes=NULL)
	{
		return Form::input($name, $this->_input_value(), $attributes); 
	}


	public function render()
	{
		return (! $this->is_null()) ? $this->_value : NULL;
	}

	public function __toString()
	{
		return (string) $this->render();
	}

	protected function _set_config($config)
	{
		if(method_exists($this, '_init_config'))
		{
			$config = array_merge($config, $this->_init_config());
		}
		$this->_config = array_merge($config, $this->_config);
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
}
