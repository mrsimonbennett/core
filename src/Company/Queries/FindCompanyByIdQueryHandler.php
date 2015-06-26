<?php
namespace FullRent\Core\Company\Queries;

use FullRent\Core\Infrastructure\Mysql\MySqlClient;

/**
 * Class FindCompanyByIdQueryHandler
 * @package FullRent\Core\Company\Queries
 * @author Simon Bennett <simon@bennett.im>
 */
final class FindCompanyByIdQueryHandler
{
    /**
     * @var MySqlClient
     */
    private $db;

    /**
     * @param MySqlClient $db
     */
    public function __construct(MySqlClient $db)
    {
        $this->db = $db;
    }

    /**
     * @param FindCompanyByIdQuery $query
     * @return mixed|static
     */
    public function handle(FindCompanyByIdQuery $query)
    {
        return $this->db->query()->table('companies')->where('id', $query->getCompanyId())->first();
    }
}