<?php
namespace FullRent\Core\Application\Http\Controllers\Properties;

use FullRent\Core\Application\Http\Controllers\Controller;
use FullRent\Core\Application\Http\Requests\Properties\UpdatePropertyHttpRequest;
use FullRent\Core\Property\Commands\UpdatePropertiesBasicInformation;
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

    /**
     * PropertiesController constructor.
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.properties.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('dashboard.properties.show');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('dashboard.properties.edit');
    }

    /**
     * @param $id
     * @param UpdatePropertyHttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdatePropertyHttpRequest $request)
    {
        $this->commandBus->execute(new UpdatePropertiesBasicInformation($id,
                                                                 $request->get('address'),
                                                                 $request->get('city'),
                                                                 $request->get('county'),
                                                                 $request->get('country'),
                                                                 $request->get('postcode'),
                                                                 $request->get('bedrooms'),
                                                                 $request->get('bathrooms'),
                                                                 $request->get('parking'), ''));

        return redirect('/properties/' . $id)->with($this->notification('Property Updated','Property address amended'));

    }
}