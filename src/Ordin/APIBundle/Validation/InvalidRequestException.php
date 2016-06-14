<?php
namespace Ordin\APIBundle\Validation;

/**
 * Description of InvalidRequestException
 */
class InvalidRequestException extends \Exception{
	
	public function __construct($message, $errors = array()) {
		parent::__construct($message);
		$this->errors = $errors;
	}
	
	private $errors = array();
	
	function getErrors() {
		return $this->errors;
	}
	
	function addError($message, $property = null){
		$this->errors[] = array(
			'property' => $property,
			'message' => $message
		);
	}
	
	function assert(){
		if(count($this->errors) > 0){
			throw $this;
		}
	}
}
