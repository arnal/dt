Kohana DateType library
====================

Working with DT is pretty easy: 

	$value = new DT_String("some string");

	$valid = $value->is_valid(); 	// => TRUE
	$valid = $value->is_null(); 	// => FALSE
	print $value; 					// => "some string"

Other examples:

	$val = DT::factory('integer', 'some_string')->is_valid();	// => FALSE


