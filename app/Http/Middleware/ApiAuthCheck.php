<?php
namespace FullRent\Core\Application\Http\Middleware;

use Closure;
use FullRent\Core\ApiAuth\Exceptions\InvalidApiToken;
use FullRent\Core\ApiAuth\TokenChecker;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ApiAuthCheck
 * @package FullRent\Core\Application\Http\Middleware
 * @author Simon Bennett <simon@bennett.im>
 */
final class ApiAuthCheck
{
    /** @var Repository */
    private $config;

    /** @var TokenChecker */
    private $tokenChecker;

    /**
     * ApiAuthCheck constructor.
     * @param Repository $config
     * @param TokenChecker $tokenChecker
     */
    public function __construct(Repository $config, TokenChecker $tokenChecker)
    {
        $this->config = $config;
        $this->tokenChecker = $tokenChecker;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->config->get('app.debug')) {
            return $next($request);
        }
        if ($this->checkTokensHaveBeenSent($request)) {
            try {
                $this->tokenChecker->check($request->headers->get('api-token'), $request->getUri());

                return $next($request);

            } catch (InvalidApiToken $ex) {
                return new JsonResponse(['message' => 'Api Tokens are not valid'], 401);
            }

        } else {
            return new JsonResponse(['message' => 'Missing [api-token] header'], 400);
        }

    }

    /**
     * @param Request $request
     * @return bool
     */
    private function checkTokensHaveBeenSent(Request $request)
    {
        return $request->headers->has('api-token');
    }
}