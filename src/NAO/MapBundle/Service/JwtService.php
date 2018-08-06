<?php
namespace NAO\MapBundle\Service;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
/**
 * Class JwtService
 * @package NAO\MapBundle\Service
 */
class JwtService{
    private $ts;
    /**
     * JwtService constructor.
     * @param TokenStorage $ts
     */
    public function __construct(TokenStorage $ts, $jwtManager){
        $this->ts           = $ts;
        $this->jwtManager   = $jwtManager;
    }
    /**
     * Create token acces
     * @return mixed
     */
    public function getToken(){
        if(!is_null($this->ts->getToken())){
            $user  = $this->ts->getToken()->getUser();
            if (is_object($user)) {
                return $this->jwtManager->create($user);
            }
            return null;
        }else{
            return null;
        }
    }
}