<?php
namespace Ordin\APIBundle\Authentication;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


class AccessDeniedExceptionListener {
	
	public function onKernelException(GetResponseForExceptionEvent $event) {
		if ($event->getException() instanceof AccessDeniedException) {
            $event->setResponse(new Response(json_encode(array(
				'message' => $event->getException()->getMessage()
			)), 403));
		}
	}
}
