<?php
namespace FullRent\Core\Application\Http\Middleware;

use Closure;
use FullRent\Core\Application\Http\Models\CompanyModal;
use FullRent\Core\Company\Queries\FindCompanyByDomainQuery;
use FullRent\Core\QueryBus\QueryBus;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Class InjectCompanyMiddleware
 * @package FullRent\Core\Application\Http\Middleware
 * @author Simon Bennett <simon@bennett.im>
 */
final class InjectCompanyMiddleware
{
    /** @var QueryBus */
    private $queryBus;

    /** @var Application */
    private $application;

    /** @var Repository */
    private $cache;

    /**
     * InjectCompanyMiddleware constructor.
     * @param QueryBus $queryBus
     * @param Application $application
     * @param Repository $cache
     */
    public function __construct(QueryBus $queryBus, Application $application, Repository $cache)
    {
        $this->queryBus = $queryBus;
        $this->application = $application;
        $this->cache = $cache;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $companyName = $this->getSubDomain($request);

        $company = $this->cache->remember($companyName . '-check',
                                          5,
            function () use ($companyName) {
                return $this->queryBus->query(new FindCompanyByDomainQuery($companyName));
            }
        );

        $this->application->bind(CompanyModal::class,
            function () use ($company) {
                return CompanyModal::fromStdClass($company);
            });

        /** @var Factory $view */
        $view = $this->application->make(Factory::class);
        $view->composer('dashboard.*',
            function (View $view) use ($company) {
                $view->with('currentCompany', $company);
            });

        return $next($request);
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getSubDomain(Request $request)
    {
        return explode('.', $request->server('HTTP_HOST'))[0];
    }
}