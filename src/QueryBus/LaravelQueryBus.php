<?php
namespace FullRent\Core\QueryBus;

use Illuminate\Contracts\Foundation\Application;

/**
 * Class LaravelQueryBusServiceProvider
 * @package FullRent\Core\QueryBus
 * @author Simon Bennett <simon@bennett.im>
 */
final class LaravelQueryBus implements QueryBus
{
    /**
     * @var Application
     */
    private $application;
    /**
     * @var QueryTranslator
     */
    private $queryTranslator;

    /**
     * @param Application $application
     * @param QueryTranslator $queryTranslator
     */
    public function __construct(Application $application, QueryTranslator $queryTranslator)
    {
        $this->application = $application;
        $this->queryTranslator = $queryTranslator;
    }

    /**
     * @param $query
     * @return \stdClass
     */
    public function query($query)
    {
        return $this->application->make($this->queryTranslator->toQueryHandler($query))->handle($query);
    }
}