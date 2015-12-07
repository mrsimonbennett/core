<?php namespace FullRent\Core\Application\Http\Controllers\User;

use Illuminate\Routing\Controller;

/**
 * Class SettingsController
 * @package FullRent\Core\Application\Http\Controllers\User
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class SettingsController extends Controller
{
    /**
     * @param string $userId
     * @return array
     */
    public function viewSettings($userId)
    {
        $config = config('user.settings');

        foreach ($config as $setting => $value) {
            $config[$setting] = ['human_name' => trans('user-settings.' . $setting), 'value' => $value];
        }

        return $config;
    }
}