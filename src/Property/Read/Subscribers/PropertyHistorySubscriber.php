<?php
namespace FullRent\Core\Property\Read\Subscribers;

use FullRent\Core\Contract\Events\ContractDrafted;
use FullRent\Core\Property\Events\AmendedPropertyAddress;
use FullRent\Core\Property\Events\ImageAttachedToProperty;
use FullRent\Core\Property\Events\NewPropertyListed;
use FullRent\Core\Property\Events\PropertyAcceptingApplications;
use FullRent\Core\Property\Events\PropertyClosedAcceptingApplications;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use SmoothPhp\Contracts\EventDispatcher\Projection;
use SmoothPhp\Contracts\EventDispatcher\Subscriber;

/**
 * Class PropertyEventsSubscriber
 * @package FullRent\Core\Property\Read\Subscribers
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertyHistorySubscriber implements Subscriber, Projection
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
        $this->db->table('property_history')
                 ->insert([
                              'id'             => uuid(),
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
        $this->db->table('property_history')
                 ->insert([
                              'id'             => uuid(),
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
        $this->db->table('property_history')
                 ->insert([
                              'id'             => uuid(),
                              'property_id'    => $propertyAcceptingApplications->getPropertyId(),
                              'event_name'     => 'Closed Applicants',
                              'event_happened' => $propertyAcceptingApplications->getChangedAt(),
                          ]);
    }

    /**
     * @param ContractDrafted $e
     */
    public function whenContractIsDrafted(ContractDrafted $e)
    {
        $this->db->table('property_history')
                 ->insert([
                              'id'             => uuid(),
                              'property_id'    => $e->getPropertyId(),
                              'event_name'     => 'Contract Drafted',
                              'event_happened' => $e->getDraftedAt(),
                          ]);
    }

    /**
     * @param ImageAttachedToProperty $e
     */
    public function whenImageHasBeenAttached(ImageAttachedToProperty $e)
    {
        $this->db->table('property_history')
                 ->insert([
                              'id'             => uuid(),
                              'property_id'    => $e->getPropertyId(),
                              'event_name'     => 'Image Uploaded',
                              'event_happened' => $e->wasAttachedAt(),
                          ]);
    }

    /**
     * @param AmendedPropertyAddress $e
     */
    public function whenAmendedPropertyAddress(AmendedPropertyAddress $e)
    {
        $this->db->table('property_history')
                 ->insert([
                              'id'             => uuid(),
                              'property_id'    => $e->getId(),
                              'event_name'     => 'Property Address Amended',
                              'event_happened' => $e->getAmendedAt(),
                          ]);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            NewPropertyListed::class                   => ['whenPropertyWasListed'],
            PropertyAcceptingApplications::class       => ['whenPropertyAcceptingApplications'],
            PropertyClosedAcceptingApplications::class => ['whenPropertyCloseAcceptingApplications'],
            ContractDrafted::class                     => ['whenContractIsDrafted'],
            ImageAttachedToProperty::class             => ['whenImageHasBeenAttached'],
            AmendedPropertyAddress::class              => 'whenAmendedPropertyAddress',
        ];
    }


}