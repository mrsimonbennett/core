<?php
namespace FullRent\Core\Property\Read;

use FullRent\Core\Property\Exceptions\PropertyNotFound;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\PropertyId;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use stdClass;

/**
 * Class MysqlPropertiesReadRepository
 * @package FullRent\Core\Property\Read
 * @author Simon Bennett <simon@bennett.im>
 * @deprecated Convert to Query Bus Please
 */
final class MysqlPropertiesReadRepository implements PropertiesReadRepository
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param CompanyId $companyId
     * @return mixed
     */
    public function getByCompany(CompanyId $companyId)
    {
        return $this->db->table('properties')->where('company_id', $companyId)->get();
    }

    /**
     * @param PropertyId $propertyId
     * @throws PropertyNotFound
     * @return stdClass
     */
    public function getById(PropertyId $propertyId)
    {
        if (is_null($property = $this->db->table('properties')->where('id', $propertyId)->first())) {
            throw new PropertyNotFound;
        }

        return $property;
    }

    /**
     * @param PropertyId $propertyId
     * @return stdClass
     */
    public function getPropertyHistory(PropertyId $propertyId)
    {
        return $this->db->table('property_history')->where('property_id', $propertyId)->orderBy('event_happened','desc')->get();
    }
}