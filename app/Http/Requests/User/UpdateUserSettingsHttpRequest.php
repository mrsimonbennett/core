<?php namespace FullRent\Core\Application\Http\Requests\User;

use FullRent\Core\Application\Http\Requests\Request;

/**
 * Class UpdateUserSettingsHttpRequest
 *
 * @author jrdn hannah <jrdn@jrdnhannah.co.uk>
 */
final class UpdateUserSettingsHttpRequest extends Request
{
    /**
     * @return string[]
     */
    public function rules()
    {
        $rules = [];
        foreach (config('user.settings') as $setting => $options) {
            $rules[$setting] = $options['rules'];
        }

        return $rules;
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}