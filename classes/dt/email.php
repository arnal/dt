<?php

class DT_Email extends DT_String {

	protected $_config = array(
		'rules' => array(
			array('email'),
		),
	);

}
