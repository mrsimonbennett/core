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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('dashboard.tenancies.show');
    }

    public function index()
    {
        return view('dashboard.tenancies.index');
    }
    public function draft()
    {
        return view('dashboard.tenancies.draft');
    }
}