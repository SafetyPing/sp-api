<?php
namespace Ordin\APIBundle\Model;

/**
 * Description of UserInterface
 *
 * @author Luwdo
 */
interface UserInterface {
	
	public function getId();

	public function getUsername();

	public function getPassword();

	public function getNonce();

	public function getPasswordLastUpdated();

	public function getPasswordRecoveryKey();

	public function getPasswordRecoveredRequested();

	public function getFailedLoginAttempts();

	public function getLastLoggedIn();

	public function getLocked();

	public function getCreated();

	public function setId($id);

	public function setUsername($username);

	public function setPassword($password);

	public function setNonce($nonce);

	public function setPasswordLastUpdated($passwordLastUpdated);

	public function setPasswordRecoveryKey($passwordRecoveryKey);

	public function setPasswordRecoveredRequested($passwordRecoveredRequested);

	public function setFailedLoginAttempts($failedLoginAttempts);

	public function setLastLoggedIn($lastLoggedIn);

	public function setLocked($locked);

	public function setCreated($created);
}
