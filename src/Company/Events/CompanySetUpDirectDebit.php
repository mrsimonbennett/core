<?php
namespace FullRent\Core\Company\Events;

use Broadway\Serializer\SerializableInterface;
use FullRent\Core\Company\ValueObjects\CompanyId;
use FullRent\Core\ValueObjects\DateTime;

/**
 * Class CompanySetUpDirectDebit
 * @package FullRent\Core\Company\Events
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompanySetUpDirectDebit implements SerializableInterface
{
    /**
     * @var CompanyId
     */
    private $companyId;
    private $merchantId;
    private $accessToken;
    /**
     * @var DateTime
     */
    private $setupAt;

    /**
     * @param CompanyId $companyId
     * @param $merchantId
     * @param $accessToken
     * @param DateTime $setupAt
     */
    public function __construct(CompanyId $companyId, $merchantId, $accessToken, DateTime $setupAt)
    {
        $this->companyId = $companyId;
        $this->merchantId = $merchantId;
        $this->accessToken = $accessToken;
        $this->setupAt = $setupAt;
    }

    /**
     * @return CompanyId
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return mixed
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return DateTime
     */
    public function getSetupAt()
    {
        return $this->setupAt;
    }


    /**
     * @param array $data
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(new CompanyId($data['company_id']),
                          $data['merchant_id'],
                          $data['access_token'],
                          DateTime::deserialize($data['setup_at']));
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'company_id'   => (string)$this->companyId,
            'merchant_id'  => $this->merchantId,
            'access_token' => $this->accessToken,
            'setup_at'     => $this->setupAt->serialize()
        ];
    }
}