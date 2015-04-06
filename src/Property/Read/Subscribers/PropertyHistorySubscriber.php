<?php
namespace FullRent\Core\Property\Read\Subscribers;

use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\Events\PropertyAcceptingApplications;
use FullRent\Core\Property\Events\PropertyClosedAcceptingApplications;
use FullRent\Core\ValueObjects\Identity\UuidIdentity;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;

/**
 * Class PropertyEventsSubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyHistorySubscriber
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @param DatabaseManager $db
     */
    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    /**
     * @param NewPropertyListed $newPropertyListed
     * @hears("FullRent.Core.Property.Events.NewPropertyListed")
     */
    public function whenPropertyWasListed(NewPropertyListed $newPropertyListed)
    {
        $this->db->table('property_history')->insert([
                                                         'id'             => UuidIdentity::random(),
                                                         'property_id'    => $newPropertyListed->getPropertyId(),
                                                         'event_name'     => 'Property was Created',
                                                         'event_happened' => $newPropertyListed->getListedAt(),
                                                     ]);
    }

    /**
     * @param PropertyAcceptingApplications $propertyAcceptingApplications
     * @hears("FullRent.Core.Property.Events.PropertyAcceptingApplications")
     */
    public function whenPropertyAcceptingApplications(PropertyAcceptingApplications $propertyAcceptingApplications)
    {
        $this->db->table('property_history')->insert([
                                                         'id'          => UuidIdentity::random(),
                                                         'property_id' => $propertyAcceptingApplications->getPropertyId(),
                                                         'event_name'  => 'Accepting Applicants',
                                                         'event_happened'  => $propertyAcceptingApplications->getChangedAt(),
                                                     ]);
    }

    /**
     * @param PropertyClosedAcceptingApplications $propertyAcceptingApplications
     * @hears("FullRent.Core.Property.Events.PropertyClosedAcceptingApplications")
     */
    public function whenPropertyCloseAcceptingApplications(PropertyClosedAcceptingApplications $propertyAcceptingApplications)
    {
        $this->db->table('property_history')->insert([
                                                         'id'          => UuidIdentity::random(),
                                                         'property_id' => $propertyAcceptingApplications->getPropertyId(),
                                                         'event_name'  => 'Closed Applicants',
                                                         'event_happened'  => $propertyAcceptingApplications->getChangedAt(),
                                                     ]);
    }
}