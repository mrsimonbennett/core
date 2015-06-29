<?php
namespace FullRent\Core\Property\Read\Subscribers;

use FullRent\Core\Contract\Events\ContractDraftedFromApplication;
use FullRent\Core\Infrastructure\Events\EventListener;
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
final class PropertyHistorySubscriber extends EventListener
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
     */
    public function whenPropertyAcceptingApplications(PropertyAcceptingApplications $propertyAcceptingApplications)
    {
        $this->db->table('property_history')->insert([
                                                         'id'             => UuidIdentity::random(),
                                                         'property_id'    => $propertyAcceptingApplications->getPropertyId(),
                                                         'event_name'     => 'Accepting Applicants',
                                                         'event_happened' => $propertyAcceptingApplications->getChangedAt(),
                                                     ]);
    }

    /**
     * @param PropertyClosedAcceptingApplications $propertyAcceptingApplications
     */
    public function whenPropertyCloseAcceptingApplications(
        PropertyClosedAcceptingApplications $propertyAcceptingApplications
    ) {
        $this->db->table('property_history')->insert([
                                                         'id'             => UuidIdentity::random(),
                                                         'property_id'    => $propertyAcceptingApplications->getPropertyId(),
                                                         'event_name'     => 'Closed Applicants',
                                                         'event_happened' => $propertyAcceptingApplications->getChangedAt(),
                                                     ]);
    }

    /**
     * @param ContractDraftedFromApplication $e
     */
    public function whenContractIsDrafted(ContractDraftedFromApplication $e)
    {
        $this->db->table('property_history')->insert([
                                                         'id'             => UuidIdentity::random(),
                                                         'property_id'    => $e->getPropertyId(),
                                                         'event_name'     => 'Contract Drafted',
                                                         'event_happened' => $e->getDraftedAt(),
                                                     ]);
    }

    /**
     * @return array
     */
    protected function register()
    {
        return [
            'whenPropertyWasListed'                  => NewPropertyListed::class,
            'whenPropertyAcceptingApplications'      => PropertyAcceptingApplications::class,
            'whenPropertyCloseAcceptingApplications' => PropertyClosedAcceptingApplications::class,
            'whenContractIsDrafted'                  => ContractDraftedFromApplication::class,
        ];
    }
}