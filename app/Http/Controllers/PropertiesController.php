<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\ListNewPropertyHttpRequest;
use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Property\Commands\ListNewProperty;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\LandlordId;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use FullRent\Core\Property\ValueObjects\PropertyId;
use Illuminate\Http\Request;
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
     * @var PropertiesReadRepository
     */
    private $propertiesReadRepository;
    /**
     * @var JsonResponse
     */
    private $jsonResponse;

    /**
     * @param CommandBus $bus
     * @param PropertiesReadRepository $propertiesReadRepository
     */
    public function __construct(CommandBus $bus, PropertiesReadRepository $propertiesReadRepository, JsonResponse $jsonResponse)
    {
        $this->bus = $bus;
        $this->propertiesReadRepository = $propertiesReadRepository;
        $this->jsonResponse = $jsonResponse;
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
    public function index(Request $request)
    {
        return $this->jsonResponse->success(['properties' => $this->propertiesReadRepository->getByCompany(new CompanyId($request->get('company_id')))]);
    }

    public function show($id)
    {
        return $this->jsonResponse->success(['property' => $this->propertiesReadRepository->getById(new PropertyId($id))]);

    }
}