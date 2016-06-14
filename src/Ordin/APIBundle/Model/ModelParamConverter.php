<?php
namespace Ordin\APIBundle\Model;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use FOS\RestBundle\Request\RequestBodyParamConverter;
use NOS\APIBundle\Validation\InvalidRequestException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ModelParamConverter implements ParamConverterInterface {
	
	public function __construct($serializer, $validator) {		
		$this->fosConverter = new RequestBodyParamConverter($serializer, null, null, $validator, 'validationErrors');
	}
	
	/**
	 * @var RequestBodyParamConverter
	 */
	private $fosConverter;
	
	public function apply(Request $request, ParamConverter $configuration) {
		$result = $this->fosConverter->apply($request, $configuration);
		
		if ($request->attributes->has('validationErrors')) {
			$errors = $request->attributes->get('validationErrors');
			if ($errors && $errors->count() > 0) {
				$invalidRequest = new InvalidRequestException("One or more validation errors occurred.");
				foreach ($errors as $error) {
					$invalidRequest->addError($error->getMessage(), $error->getPropertyPath());
				}
				throw $invalidRequest;
			}
		}
		
		return $result;
	}
	//it would be a good idea to only do this on models that extend a base model, that way this param converter will ignore anything thats not a model
	public function supports(ParamConverter $configuration) {
		return $this->fosConverter->supports($configuration);
	}
}
