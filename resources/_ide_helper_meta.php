<?php
namespace App {
    class User extends \DummyApp\User {

    }
}

namespace Tymon\JWTAuth\Facades {

    /**
     *
     *
     */
    class JWTAuth {

        /**
         * Find a user using the user identifier in the subject claim.
         *
         * @param bool|string $token
         * @return mixed
         * @static
         */
        public static function toUser($token = false)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->toUser($token);
        }

        /**
         * Generate a token using the user identifier as the subject claim.
         *
         * @param mixed $user
         * @param array $customClaims
         * @return string
         * @static
         */
        public static function fromUser($user, $customClaims = array())
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->fromUser($user, $customClaims);
        }

        /**
         * Attempt to authenticate the user and return the token.
         *
         * @param array $credentials
         * @param array $customClaims
         * @return false|string
         * @static
         */
        public static function attempt($credentials = array(), $customClaims = array())
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->attempt($credentials, $customClaims);
        }

        /**
         * Authenticate a user via a token.
         *
         * @param mixed $token
         * @return mixed
         * @static
         */
        public static function authenticate($token = false)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->authenticate($token);
        }

        /**
         * Refresh an expired token.
         *
         * @param mixed $token
         * @return string
         * @static
         */
        public static function refresh($token = false)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->refresh($token);
        }

        /**
         * Invalidate a token (add it to the blacklist).
         *
         * @param mixed $token
         * @return bool
         * @static
         */
        public static function invalidate($token = false)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->invalidate($token);
        }

        /**
         * Get the token.
         *
         * @return bool|string
         * @static
         */
        public static function getToken()
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->getToken();
        }

        /**
         * Get the raw Payload instance.
         *
         * @param mixed $token
         * @return \Tymon\JWTAuth\Payload
         * @static
         */
        public static function getPayload($token = false)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->getPayload($token);
        }

        /**
         * Parse the token from the request.
         *
         * @param string $query
         * @return \JWTAuth
         * @static
         */
        public static function parseToken($method = 'bearer', $header = 'authorization', $query = 'token')
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->parseToken($method, $header, $query);
        }

        /**
         * Set the identifier.
         *
         * @param string $identifier
         * @return \Tymon\JWTAuth\JWTAuth
         * @static
         */
        public static function setIdentifier($identifier)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->setIdentifier($identifier);
        }

        /**
         * Get the identifier.
         *
         * @return string
         * @static
         */
        public static function getIdentifier()
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->getIdentifier();
        }

        /**
         * Set the token.
         *
         * @param string $token
         * @return \Tymon\JWTAuth\JWTAuth
         * @static
         */
        public static function setToken($token)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->setToken($token);
        }

        /**
         * Set the request instance.
         *
         * @param \Tymon\JWTAuth\Request $request
         * @static
         */
        public static function setRequest($request)
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->setRequest($request);
        }

        /**
         * Get the JWTManager instance.
         *
         * @return \Tymon\JWTAuth\JWTManager
         * @static
         */
        public static function manager()
        {
            /** @var \Tymon\JWTAuth\JWTAuth $instance */
            return $instance->manager();
        }

    }

    /**
     *
     *
     */
    class JWTFactory {

        /**
         * Create the Payload instance.
         *
         * @param array $customClaims
         * @return \Tymon\JWTAuth\Payload
         * @static
         */
        public static function make($customClaims = array())
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->make($customClaims);
        }

        /**
         * Add an array of claims to the Payload.
         *
         * @param array $claims
         * @return \Tymon\JWTAuth\PayloadFactory
         * @static
         */
        public static function addClaims($claims)
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->addClaims($claims);
        }

        /**
         * Add a claim to the Payload.
         *
         * @param string $name
         * @param mixed $value
         * @return \Tymon\JWTAuth\PayloadFactory
         * @static
         */
        public static function addClaim($name, $value)
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->addClaim($name, $value);
        }

        /**
         * Build out the Claim DTO's.
         *
         * @return array
         * @static
         */
        public static function resolveClaims()
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->resolveClaims();
        }

        /**
         * Set the Issuer (iss) claim.
         *
         * @return string
         * @static
         */
        public static function iss()
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->iss();
        }

        /**
         * Set the Issued At (iat) claim.
         *
         * @return int
         * @static
         */
        public static function iat()
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->iat();
        }

        /**
         * Set the Expiration (exp) claim.
         *
         * @return int
         * @static
         */
        public static function exp()
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->exp();
        }

        /**
         * Set the Not Before (nbf) claim.
         *
         * @return int
         * @static
         */
        public static function nbf()
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->nbf();
        }

        /**
         * Set the token ttl (in minutes).
         *
         * @param int $ttl
         * @return \Tymon\JWTAuth\PayloadFactory
         * @static
         */
        public static function setTTL($ttl)
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->setTTL($ttl);
        }

        /**
         * Get the token ttl.
         *
         * @return int
         * @static
         */
        public static function getTTL()
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->getTTL();
        }

        /**
         * Set the refresh flow.
         *
         * @param bool $refreshFlow
         * @return \Tymon\JWTAuth\PayloadFactory
         * @static
         */
        public static function setRefreshFlow($refreshFlow = true)
        {
            /** @var \Tymon\JWTAuth\PayloadFactory $instance */
            return $instance->setRefreshFlow($refreshFlow);
        }

    }

}
