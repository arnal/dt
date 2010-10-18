Kohana DateType library
====================

Working with DT is pretty easy: 

	$email = DT_Email("example@example.org");

	$email->is_valid(); 				// => TRUE
	$email->is_null(); 					// => FALSE
	print $value; 						// => "example@example.org"
	
	print $value->input('my_email');	
	// => "<input type='text' name='my_email' value='example@example.org' />
	

Other examples:

	DT_Email::factory('no-email')->is_valid(); // => FALSE

