<?php

class DT_Enum extends DT_String {

	protected $_config = array(
		'display_type' => 'select',
    'null_title' => 'Nezadáno',
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
				$out[] = Form::radio($name, $key, ($this->_value == $key), array('id'=>$name.'_'.$key)).'&nbsp;&nbsp;<label for="'.$name.'_'.$key.'" style="display:inline;">'.$val.'</label>&nbsp;';
			}
			if((isset($this->_config['allow_null']) AND ($this->_config['allow_null'] == TRUE) OR !isset($this->_config['allow_null'])))
			{
        $key = '0';
				$out[] = Form::radio($name, 0, ($this->_value == NULL), array('id'=>$name.'_'.$key)).'&nbsp;&nbsp<label for="'.$name.'_'.$key.'" style="display:inline;">'.$this->_config['null_title'].'</label>';
			}
			return join('&nbsp;&nbsp;&nbsp;&nbsp;', $out);
		}
		else
		{
      // strip tags pokud je to select
      foreach($values as $k=>$v)
      {
        $values[$k] = strip_tags($v);
      }
			if((isset($this->_config['allow_null']) AND ($this->_config['allow_null'] == TRUE) OR !isset($this->_config['allow_null'])))
			{
				$values = array_merge(array('' => '-- vyberte --'), $values);
			}
			return Form::select($name, $values, ($this->is_valid() ? $this->_value : NULL), $attributes);
		}
	}

	public function render($html=FALSE)
	{
		return @$this->_config['possible_values'][$this->_value];
	}

	public function possible_value_title($key=NULL)
	{
		return $this->_config['possible_values'][($key == NULL ? $this->_value : $key)];
	}

	public function possible_values()
	{
		return $this->_config['possible_values'];
	}
}
