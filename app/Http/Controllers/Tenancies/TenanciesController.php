<?php
namespace FullRent\Core\Application\Http\Controllers\Tenancies;

use FullRent\Core\Application\Http\Controllers\Controller;

/**
 * Class TenanciesController
 * @package FullRent\Core\Application\Http\Controllers\Tenancies
 * @author Simon Bennett <simon@bennett.im>
 */
final class TenanciesController extends Controller
{
    /**
     * @param $tenancyId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($tenancyId)
    {
        $this->authorize('view_tenancy',$tenancyId);

        return view('dashboard.tenancies.show');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('view_all_tenancies');

        return view('dashboard.tenancies.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function draft()
    {
        $this->authorize('view_all_tenancies');

        return view('dashboard.tenancies.draft');
    }
}