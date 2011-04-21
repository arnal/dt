<?php

class DT_Enum extends DT_String {

	protected $_config = array(
		'display_type' => 'select',
	);

	protected function _init_config()
	{
		return array(
			'rules' => array(
				array('regex', '/^('.join(array_keys($this->_config['possible_values']),'|').')$/'),
			),
		);
	}

	public function input($name, $attributes=NULL)
	{
		$values = $this->_config['possible_values'];
		if($this->_config['display_type'] == 'radio')
		{
			$out = array();
			foreach($values as $key=>$val)
			{
				$out[] = form::radio($name, $key, ($this->_value == $key), array('id'=>$name.'_'.$key)).'&nbsp;&nbsp;'.form::label($name.'_'.$key, $val);
			}
			if((isset($this->_config['allow_null']) AND ($this->_config['allow_null'] == TRUE) OR !isset($this->_config['allow_null'])))
			{
				$out[] = form::radio($name, 0, ($this->_value == NULL)).'&nbsp;&nbsp'.form::label($name.'_'.$key, 'nezadáno');
			}
			return join('&nbsp;&nbsp;&nbsp;&nbsp;', $out);
		}
		else
		{
			if((isset($this->_config['allow_null']) AND ($this->_config['allow_null'] == TRUE) OR !isset($this->_config['allow_null'])))
			{
				$values = array_merge(array('' => '-- vyberte --'), $values);
			}
			return Form::select($name, $values, ($this->is_valid() ? $this->_value : NULL), $attributes);
		}
	}

	public function render()
	{
		return @$this->_config['possible_values'][$this->_value];
	}

	public function possible_value_title($key=NULL)
	{
		return $this->_config['possible_values'][($key == NULL ? $this->_value : $key)];
	}
}
