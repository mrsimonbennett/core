<?php
namespace FullRent\Core\RentBook\Queries;

/**
 * Class FindRentBookByAuthorizationIdQuery
 * @package FullRent\Core\RentBook\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindRentBookByAuthorizationIdQuery
{
    /** @var string */
    private $preAuthorizationId;

    /**
     * FindRentBookByAuthorizationIdQuery constructor.
     * @param string $preAuthorizationId
     */
    public function __construct($preAuthorizationId)
    {
        $this->preAuthorizationId = $preAuthorizationId;
    }

    /**
     * @return string
     */
    public function getPreAuthorizationId()
    {
        return $this->preAuthorizationId;
    }
    
}