<?php
namespace FullRent\Core\Application\Http\Controllers;

use FullRent\Core\Application\Http\Helpers\JsonResponse;
use FullRent\Core\Application\Http\Requests\AcceptPropertyApplicationsHttpRequest;
use FullRent\Core\Application\Http\Requests\ListNewPropertyHttpRequest;
use FullRent\Core\Property\Queries\FindPropertyById;
use FullRent\Core\QueryBus\QueryBus;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use FullRent\Core\Images\Commands\StoreUploadedImage;
use FullRent\Core\Property\Commands\AcceptApplications;
use FullRent\Core\Property\Commands\AttachImage;
use FullRent\Core\Property\Commands\CloseApplications;
use FullRent\Core\Property\Commands\EmailApplication;
use FullRent\Core\Property\Commands\ListNewProperty;
use FullRent\Core\Property\Exceptions\PropertyAlreadyAcceptingApplicationsException;
use FullRent\Core\Property\Exceptions\PropertyAlreadyClosedToApplicationsException;
use FullRent\Core\Property\Read\PropertiesReadRepository;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\ImageId;
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
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @param CommandBus $bus
     * @param PropertiesReadRepository $propertiesReadRepository
     * @param JsonResponse $jsonResponse
     * @param QueryBus $queryBus
     */
    public function __construct(
        CommandBus $bus,
        PropertiesReadRepository $propertiesReadRepository,
        JsonResponse $jsonResponse,
        QueryBus $queryBus
    ) {
        $this->bus = $bus;
        $this->propertiesReadRepository = $propertiesReadRepository;
        $this->jsonResponse = $jsonResponse;
        $this->queryBus = $queryBus;
    }

    /**
     * @param ListNewPropertyHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listNewProperty(ListNewPropertyHttpRequest $request)
    {
        $address = new Address($request->get('address'),
                               $request->get('city'),
                               $request->get('county'),
                               $request->get('country'),
                               $request->get('postcode'));


        $command = new ListNewProperty($address,
                                       new CompanyId($request->get('company_id')),
                                       new LandlordId($request->get('landlord_id')),
                                       new BedRooms($request->get('bedrooms')),
                                       new Bathrooms($request->get('bathrooms')),
                                       new Parking($request->get('parking')),
                                       new Pets(true, false));

        $this->bus->execute($command);

        return $this->jsonResponse->success(['property_id' => (string)$command->getPropertyId()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->jsonResponse->success(['properties' => $this->propertiesReadRepository->getByCompany(new CompanyId($request->get('company_id')))]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $property = $this->queryBus->query(new FindPropertyById(new PropertyId($id)));

        return $this->jsonResponse->success(['property' => $property]);
    }

    /**
     * @param AcceptPropertyApplicationsHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function acceptApplication(AcceptPropertyApplicationsHttpRequest $request)
    {
        try {
            $this->bus->execute(new AcceptApplications(new PropertyId($request->get('property_id'))));
            $this->jsonResponse->success();
        } catch (PropertyAlreadyAcceptingApplicationsException $ex) {
            return $this->jsonResponse->error('Already Accepting Applications');
        }
    }

    public function closeApplication(AcceptPropertyApplicationsHttpRequest $request)
    {
        try {
            $this->bus->execute(new CloseApplications(new PropertyId($request->get('property_id'))));
            $this->jsonResponse->success();
        } catch (PropertyAlreadyClosedToApplicationsException $ex) {
            return $this->jsonResponse->error('Already Closed to Applications');

        }
    }

    /**
     * @param EmailApplicantHttpRequest $request
     */
    public function emailApplicant(Request $request)
    {
        $this->bus->execute(new EmailApplication($request->get('property_id'),$request->get('email')));
    }
    /**
     * @param $propertyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistory($propertyId)
    {
        return $this->jsonResponse->success(['property_history' => $this->propertiesReadRepository->getPropertyHistory(new PropertyId($propertyId))]);

    }

    /**
     * @param Request $request
     * @param int     $propertyId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachImage(Request $request, $propertyId)
    {
        try {
            $this->bus->execute(new StoreUploadedImage($imageId = uuid(), $request->file('image')));
            $this->bus->execute(new AttachImage($propertyId, $imageId));
            return $this->jsonResponse->success(['image_id' => $imageId]);
        } catch (\Exception $e) {
            // I imagine there will be a variety of exceptions we can catch here
            return $this->jsonResponse->error(['error' => $e->getMessage()]);
        }
    }
}