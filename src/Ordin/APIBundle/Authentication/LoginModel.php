<?php
namespace Ordin\APIBundle\Authentication;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as JMS;

class LoginModel {

	/**
	 * @JMS\Type("string")
	 * @Assert\NotBlank(
	 *		message = "Username Required."
	 * )
	 * @Assert\Length(
	 *		max = 150,
	 *		maxMessage = "Username can only be 150 characters long.",
	 *		min = 1,
	 *		minMessage = "Username can not be blank."
	 * )
	 */
	public $username;
	
	/**
	 * @Assert\NotBlank(
	 *		message = "Password Required."
	 * )
	 * @Assert\Length(
	 *		min = 1,
	 *		minMessage = "Password can not be blank."
	 * )
	 * @JMS\Type("string")
	 *
	 */
	public $password;

}