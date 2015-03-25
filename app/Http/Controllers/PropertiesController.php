<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Requests\ListNewPropertyHttpRequest;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Property\Commands\ListNewProperty;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\LandlordId;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use Illuminate\Routing\Controller;

/**
 * Class PropertiesController
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertiesController extends Controller
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function listNewProperty(ListNewPropertyHttpRequest $request)
    {
        $address = new Address($request->get('address'),
            $request->get('city'),
            $request->get('county'),
            $request->get('country'),
            $request->get('postcode'));


        $command = new ListNewProperty($address, new CompanyId($request->get('company_id')),
            new LandlordId($request->get('landlord_id')), new BedRooms($request->get('bedrooms')), new Bathrooms($request->get('bathrooms')), new Parking($request->get('parking')),
            new Pets(true, false));

        $this->bus->execute($command);
    }
}