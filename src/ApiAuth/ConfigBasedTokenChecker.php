<?php
namespace FullRent\Core\ApiAuth;

use FullRent\Core\ApiAuth\Exceptions\InvalidApiToken;
use Illuminate\Config\Repository;

/**
 * Class ConfigBasedTokenChecker
 * @package FullRent\Core\ApiAuth
 * @author Simon Bennett <simon@bennett.im>
 */
final class ConfigBasedTokenChecker implements TokenChecker
{
    const TimeRange = 10;

    /** @var */
    private $config;

    /**
     * ConfigBasedTokenChecker constructor.
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }
    /**
     * @param $token
     * @param $requestUri
     * @return void
     * @throws InvalidApiToken
     */
    public function check($token, $requestUri)
    {
        for ($time = time() - self::TimeRange; $time < time() + self::TimeRange; $time++) {
            $hashes[] = $this->hash($time, $this->config->get('api.token'), $requestUri);
        }

        if(!in_array($token,$hashes))
        {
            throw new InvalidApiToken();
        }
    }

    /**
     * @param $time
     * @param $token
     * @param $requestUri
     * @return string
     */
    public function hash($time, $token, $requestUri)
    {
        return sha1($token . $time . $requestUri);
    }
}