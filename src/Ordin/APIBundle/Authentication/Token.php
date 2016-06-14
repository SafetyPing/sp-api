<?php
namespace Ordin\APIBundle\Authentication;
use Firebase\JWT\JWT;

/**
 * 
 */
class Token {
	/**
	 * issuer
	 * @var type 
	 */
	private $iss;
	
	/**
	 * audience
	 * @var type 
	 */
	private $aud;
	
	/**
	 * time token was issued issued
	 * @var type 
	 */
	private $iat;
	
	/**
	 * time token can be used
	 * @var type 
	 */
	private $nbf;
	
	/**
	 * time token expires
	 * @var type 
	 */
	private $exp;
	
	/**
	 * @var integer
	 */
	private $userId;
	
	/*
	 * encription key
	 * @var string
	 */
	private $key;
	
	public static function create($key, $tokenString)
    {
		JWT::$leeway = 60; // $leeway in seconds
		$payload = JWT::decode($tokenString, $key, array('HS256'));
        return new static($key, $payload->iss, $payload->aud, $payload->userId, $payload->iat, $payload->nbf, $payload->exp);
    }
	
	public function __construct(
			$key,
			$iss,
			$aud,
			$userId,
			$iat = null,
			$nbf = null,
			$exp = null){
		
		$this->userId = $userId;
		$this->key = $key;
		$this->iss = $iss;
		$this->aud = $aud;
		
		$this->iat = time();
		if($iat){
			$this->iat = $iat;
		}
		
		$this->nbf = time();
		if($nbf){
			$this->nbf = $nbf;
		}
		
		$this->exp = strtotime('+3 day', time());
		if($exp){
			$this->exp = $exp;
		}
	}
	
	public function encode(){
		JWT::$leeway = 60; // $leeway in seconds
		
		$payload = array(
			"iss" => $this->iss,//issuer
			"aud" => $this->aud,//audience
			"iat" => $this->iat,//time token was issued issued
			"nbf" => $this->nbf, //time token can be used
			"exp" => $this->exp,
			"user" => $this->userId
		);
		
		return JWT::encode($payload, $this->key, 'HS256');
	}
	
	function getIss() {
		return $this->iss;
	}

	function getAud() {
		return $this->aud;
	}

	function getIat() {
		return $this->iat;
	}

	function getNbf() {
		return $this->nbf;
	}

	function getExp() {
		return $this->exp;
	}

	function getUserId() {
		return $this->userId;
	}

	function getKey() {
		return $this->key;
	}
}