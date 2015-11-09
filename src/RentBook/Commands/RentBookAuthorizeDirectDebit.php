<?php
namespace FullRent\Core\RentBook\Commands;

use FullRent\Core\Services\DirectDebit\AccessTokens;
use SmoothPhp\CommandBus\BaseCommand;

/**
 * Class RentBookAuthorizeDirectDebit
 * @package FullRent\Core\RentBook\Commands
 * @author Simon Bennett <simon@bennett.im>
 */
final class RentBookAuthorizeDirectDebit extends BaseCommand
{
    private $rentBookId;
    private $resourceId;
    private $resourceType;
    private $resourceUri;
    private $signature;
    /**
     * @var AccessTokens
     */
    private $accessTokens;

    /**
     * @param $rentBookId
     * @param $resourceId
     * @param $resourceType
     * @param $resourceUri
     * @param $signature
     * @param AccessTokens $accessTokens
     */
    public function __construct($rentBookId, $resourceId, $resourceType, $resourceUri,$signature, AccessTokens $accessTokens)
    {
        $this->rentBookId = $rentBookId;
        $this->resourceId = $resourceId;
        $this->resourceType = $resourceType;
        $this->resourceUri = $resourceUri;
        $this->signature = $signature;
        $this->accessTokens = $accessTokens;
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getRentBookId()
    {
        return $this->rentBookId;
    }

    /**
     * @return mixed
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * @return mixed
     */
    public function getResourceType()
    {
        return $this->resourceType;
    }

    /**
     * @return mixed
     */
    public function getResourceUri()
    {
        return $this->resourceUri;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return AccessTokens
     */
    public function getAccessTokens()
    {
        return $this->accessTokens;
    }


}