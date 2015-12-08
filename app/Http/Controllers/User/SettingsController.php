<?php namespace FullRent\Core\Application\Http\Controllers\User;

use Log;
use Illuminate\Routing\Controller;
use FullRent\Core\QueryBus\QueryBus;
use FullRent\Core\User\Queries\FindUserSettings;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FullRent\Core\Application\Http\Helpers\JsonResponse;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

/**
 * Class SettingsController
 * @package FullRent\Core\Application\Http\Controllers\User
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class SettingsController extends Controller
{
    /** @var QueryBus */
    private $query;
    /** @var JsonResponse */
    private $json;

    /**
     * SettingsController constructor.
     *
     * @param QueryBus     $query
     * @param JsonResponse $json
     */
    public function __construct(QueryBus $query, JsonResponse $json)
    {
        $this->query = $query;
        $this->json  = $json;
    }

    /**
     * @param string $userId
     * @return array
     */
    public function viewSettings($userId)
    {
        $defaults = config('user.settings');

        foreach ($defaults as $key => $options) {
            $defaults[$key] = $options['default'];
        }

        $resolver = (new OptionsResolver)
            ->setDefaults($defaults)
            ->setRequired(array_keys($defaults));

        $settings = $resolver->resolve((array) $this->query->query(new FindUserSettings($userId)));

        foreach ($settings as $setting => $value) {
            $settings[$setting] = [
                'human_name' => trans('user-settings.' . $setting),
                'value'      => $value
            ];
        }

        return $settings;
    }
}