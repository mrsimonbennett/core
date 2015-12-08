<?php namespace FullRent\Core\Application\Http\Controllers\User;

use Log;
use Illuminate\Routing\Controller;
use FullRent\Core\QueryBus\QueryBus;
use SmoothPhp\Contracts\CommandBus\CommandBus;
use FullRent\Core\User\Queries\FindUserSettings;
use FullRent\Core\User\Commands\UpdateUserSettings;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FullRent\Core\Application\Http\Helpers\JsonResponse;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use FullRent\Core\Application\Http\Requests\User\UpdateUserSettingsHttpRequest;

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
    /** @var CommandBus */
    private $bus;

    /**
     * SettingsController constructor.
     *
     * @param QueryBus     $query
     * @param JsonResponse $json
     * @param CommandBus   $bus
     */
    public function __construct(QueryBus $query, JsonResponse $json, CommandBus $bus)
    {
        $this->query = $query;
        $this->json  = $json;
        $this->bus = $bus;
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

    /**
     * @param UpdateUserSettingsHttpRequest $request
     * @param string                        $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSettings(UpdateUserSettingsHttpRequest $request, $userId)
    {
        $this->bus->execute(new UpdateUserSettings($userId, $request->request->all()));

        return $this->json->success(['user_id' => $userId]);
    }
}