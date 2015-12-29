<?php
namespace FullRent\Core\Application\Http\Composer;

use Illuminate\Contracts\View\View;

/**
 * Interface Composer
 * @package FullRent\Core\Application\Http\Composer
 * @author Simon Bennett <simon@bennett.im>
 */
interface Composer
{
    /**
     * @param View $view
     */
    public function compose(View $view);
}