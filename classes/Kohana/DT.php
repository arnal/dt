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
	  $this->set($value);
	}

	public function to_db()
	{
		return $this->_value;
	}

  public function set_raw($value)
  {
    $this->set($value);
  }

	public function set($value)
	{
    // beforeset hook
    $value = $this->before_set($value);

    if($value == NULL)
    {
      return NULL;
    }

		if(isset($this->_config['type']) AND (gettype($value) != $this->_config['type']))
		{
			settype($value, $this->_config['type']);
		}
		if(isset($this->_config['filters']))
		{
			foreach($this->_config['filters'] as $filter)
			{
				$value = call_user_func($filter, $value);
			}
		}
		$this->_value = $value;
    
    // afterset hook
    $this->after_set();
	}

  public function after_set() {}
  public function before_set($value) {
    return $value;
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
					if(! Valid::$func_name($value, @$rule[1], @$rule[2], @$rule[3]))
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

	public function render($html = FALSE)
	{
		if($this->is_null())
			return NULL;

		return $html ? $this->_render_html() : $this->_render_string();
	}

	public function _render_string()
	{
		return $this->_value;
	}

	public function _render_html()
	{
		return $this->_render_string();
	}

	public function __toString()
	{
		return (string) $this->render(FALSE);
	}

	protected function _set_config($config)
	{
		$this->_config = array_merge($this->_config, $config);

		if(method_exists($this, '_init_config'))
		{
			$this->_config = array_merge($this->_config, $this->_init_config());
		}
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

	static public function factory_filter($value, $type)
	{
		$classname = 'DT_'.ucfirst($type);
		return new $classname($value);
	}

	public function raw()
	{
		return $this->_value;
	}

  public function set_raw($value)
  {
    $this->_value = $value;
  }

  public function config()
  {
    return $this->_config;
  }
}
