<?php
namespace Ordin\APIBundle\Model;

/**
 * Description of User
 *
 * @author Luwdo
 */
abstract class User implements UserInterface{
	
	protected $id;
	
	protected $username;
	
	protected $password;
	
	protected $nonce;
	
	protected $passwordLastUpdated;
	
	protected $passwordRecoveryKey;
	
	protected $passwordRecoveredRequested;

	protected $failedLoginAttempts = 0;
	
	protected $lastLoggedIn;
	
	protected $locked;
	
	protected $created;
	
	public function getId() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getNonce() {
		return $this->nonce;
	}

	public function getPasswordLastUpdated() {
		return $this->passwordLastUpdated;
	}

	public function getPasswordRecoveryKey() {
		return $this->passwordRecoveryKey;
	}

	public function getPasswordRecoveredRequested() {
		return $this->passwordRecoveredRequested;
	}

	public function getFailedLoginAttempts() {
		return $this->failedLoginAttempts;
	}

	public function getLastLoggedIn() {
		return $this->lastLoggedIn;
	}

	public function getLocked() {
		return $this->locked;
	}

	public function getCreated() {
		return $this->created;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}

	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	public function setNonce($nonce) {
		$this->nonce = $nonce;
		return $this;
	}

	public function setPasswordLastUpdated($passwordLastUpdated) {
		$this->passwordLastUpdated = $passwordLastUpdated;
		return $this;
	}

	public function setPasswordRecoveryKey($passwordRecoveryKey) {
		$this->passwordRecoveryKey = $passwordRecoveryKey;
		return $this;
	}

	public function setPasswordRecoveredRequested($passwordRecoveredRequested) {
		$this->passwordRecoveredRequested = $passwordRecoveredRequested;
		return $this;
	}

	public function setFailedLoginAttempts($failedLoginAttempts) {
		$this->failedLoginAttempts = $failedLoginAttempts;
		return $this;
	}

	public function setLastLoggedIn($lastLoggedIn) {
		$this->lastLoggedIn = $lastLoggedIn;
		return $this;
	}

	public function setLocked($locked) {
		$this->locked = $locked;
		return $this;
	}

	public function setCreated($created) {
		$this->created = $created;
		return $this;
	}
}
