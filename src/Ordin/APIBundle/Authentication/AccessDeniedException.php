<?php
namespace Ordin\APIBundle\Authentication;

class AccessDeniedException extends \Exception {
	
	public function __construct($message = "Access Denied", $code = 0, \Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
	
}