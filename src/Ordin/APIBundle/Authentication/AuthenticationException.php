<?php
namespace Ordin\APIBundle\Authentication;

class AuthenticationException extends \Exception {
	
	public function __construct($message = "Authentication Failed", $code = 0, \Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
	
}