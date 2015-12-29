<?php
namespace FullRent\Core\Application\Http\Controllers\Properties;

use FullRent\Core\Application\Http\Controllers\Controller;

/**
 * Class PropertiesController
 * @package FullRent\Core\Application\Http\Controllers\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class PropertiesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.properties.index');
    }
}