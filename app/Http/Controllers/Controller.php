<?php
namespace FullRent\Core\Application\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 * @package FullRent\Core\Application\Http\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
class Controller extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;
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