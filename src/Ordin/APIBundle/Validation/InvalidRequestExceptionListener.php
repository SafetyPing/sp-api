<?php
namespace Ordin\APIBundle\Validation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


class InvalidRequestExceptionListener {
	
	public function onKernelException(GetResponseForExceptionEvent $event) {
		if ($event->getException() instanceof InvalidRequestException) {
            $event->setResponse(new Response(json_encode(array(
				'message' => 'Invalid Request',
				'errors' => $event->getException()->getErrors()
			)), 400));
		}
	}
}
