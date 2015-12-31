<?php
namespace FullRent\Core\Application\Http\Controllers;

/**
 * Class Controller
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
class Controller extends \Illuminate\Routing\Controller
{
    /**
     * Helper to returning a JS notification to the admin UI
     * @param string $title
     * @param string $message
     * @return array
     */
    protected function notification($title, $message = '')
    {
        return ['notification' => ['title' => $title, 'message' => $message]];
    }
}