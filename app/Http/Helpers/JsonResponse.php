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

    public function notFound($data = [])
    {
        $extraInfo = ['status' => 'error', 'signature' => md5(json_encode($data))];

        return new BaseJsonResponse(array_merge($extraInfo, $data), 404);
    }

    /**
     * @param $message
     * @param array $data
     * @return BaseJsonResponse
     */
    public function error($message, $data = [])
    {
        $extraInfo = ['status' => 'error', 'signature' => md5(json_encode($data)), 'message' => $message];

        return new BaseJsonResponse(array_merge($extraInfo, $data), 400);
    }
}