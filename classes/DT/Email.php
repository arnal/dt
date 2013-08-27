<?php

class DT_Email extends DT_String {

	protected $_config = array(
		'rules' => array(
			array('email'),
		),
	);

  public function render($html=FALSE)
  {
    if($html)
    {
      return HTML::mailto($this->_value);
    }
    return parent::render($html);
  }
}
