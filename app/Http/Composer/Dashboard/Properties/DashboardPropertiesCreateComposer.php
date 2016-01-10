<?php
namespace FullRent\Core\Application\Http\Composer\Dashboard\Properties;

use FullRent\Core\Application\Http\Composer\Composer;
use Illuminate\Contracts\View\View;

/**
 * Class DashboardPropertiesCreateComposer
 * @package FullRent\Core\Application\Http\Composer\Dashboard\Properties
 * @author Simon Bennett <simon@bennett.im>
 */
final class DashboardPropertiesCreateComposer implements Composer
{
    public function __construct()
    {
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        for ($i = 1; $i < 15; $i++) {
            $bedroomOptions[$i / 2 . ""] = $i / 2;
        }
        for ($i = 1; $i < 10; $i++) {
            $bathrooms[$i / 2 . ""] = $i / 2;
        }
        $view
             ->with('title', 'Create Property')
             ->with('bedrooms', $bedroomOptions)
             ->with('bathrooms', $bathrooms);    }
}