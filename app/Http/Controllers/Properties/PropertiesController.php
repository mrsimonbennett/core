<?php
namespace FullRent\Core\Application\Http\Controllers\Properties;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\Application\Http\Requests\ListNewPropertyHttpRequest;
use FullRent\Core\Application\Http\Requests\Properties\UpdatePropertyHttpRequest;
use FullRent\Core\Property\Commands\ListNewProperty;
use FullRent\Core\Property\Commands\UpdatePropertiesBasicInformation;
use FullRent\Core\Property\ValueObjects\Address;
use FullRent\Core\Property\ValueObjects\Bathrooms;
use FullRent\Core\Property\ValueObjects\BedRooms;
use FullRent\Core\Property\ValueObjects\CompanyId;
use FullRent\Core\Property\ValueObjects\LandlordId;
use FullRent\Core\Property\ValueObjects\Parking;
use FullRent\Core\Property\ValueObjects\Pets;
use Illuminate\Contracts\Auth\Guard;
use SmoothPhp\Contracts\CommandBus\CommandBus;

/**
 * Class PropertiesController
 * @package FullRent\Core\Application\Http\Controllers\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertiesController extends Controller
{
    /** @var CommandBus */
    private $commandBus;

    /** @var Guard */
    private $guard;

    /** @var CompanyModal */
    private $companyModal;

    /**
     * PropertiesController constructor.
     * @param CommandBus $commandBus
     * @param Guard $guard
     * @param CompanyModal $companyModal
     */
    public function __construct(CommandBus $commandBus, Guard $guard, CompanyModal $companyModal)
    {
        $this->commandBus = $commandBus;
        $this->guard = $guard;
        $this->companyModal = $companyModal;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view_all_properties');

        return view('dashboard.properties.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('list_property');

        return view('dashboard.properties.create');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($propertyId)
    {
        $this->authorize('view_property', $propertyId);

        return view('dashboard.properties.show');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($propertyId)
    {
        $this->authorize('edit_property', $propertyId);

        return view('dashboard.properties.edit');
    }

    public function listProperty(ListNewPropertyHttpRequest $request)
    {
        $this->authorize('list_property');


        $address = new Address($request->get('address'),
                               $request->get('city'),
                               $request->get('county'),
                               $request->get('country'),
                               $request->get('postcode'));


        $command = new ListNewProperty($address,
                                       new CompanyId($this->companyModal->id),
                                       new LandlordId($this->guard->user()->id),
                                       new BedRooms($request->get('bedrooms')),
                                       new Bathrooms($request->get('bathrooms')),
                                       new Parking($request->get('parking')),
                                       new Pets(true, false));

        $this->commandBus->execute($command);

        sleep(2);

        return redirect('/properties/' . (string)$command->getPropertyId())->with($this->notification('Property Listed',
                                                                                                      'Property listed'));
    }

    /**
     * @param $propertyId
     * @param UpdatePropertyHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($propertyId, UpdatePropertyHttpRequest $request)
    {
        $this->authorize('edit_property', $propertyId);

        $this->commandBus->execute(new UpdatePropertiesBasicInformation($propertyId,
                                                                        $request->get('address'),
                                                                        $request->get('city'),
                                                                        $request->get('county'),
                                                                        $request->get('country'),
                                                                        $request->get('postcode'),
                                                                        $request->get('bedrooms'),
                                                                        $request->get('bathrooms'),
                                                                        $request->get('parking'), ''));

        return redirect('/properties/' . $propertyId)->with($this->notification('Property Updated',
                                                                                'Property address amended'));

    }
}