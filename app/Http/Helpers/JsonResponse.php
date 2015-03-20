<?php
namespace FullRent\Core\Application\Http\Helpers;

use Illuminate\Http\JsonResponse as BaseJsonResponse;

/**
 * Class JsonResponse
 * @package FullRent\Core\Application\Http\Helpers
 * @author Simon Bennett <simon@bennett.im>
 */
final class JsonResponse
{
    /**
     * @param array $data
     * @return BaseJsonResponse
     */
    public function success($data = [])
    {
        $extraInfo = ['status' => 'success', 'signature' => md5(json_encode($data))];
        return new BaseJsonResponse(array_merge($extraInfo, $data), 200);
    }
}