<?php
namespace FullRent\Core\Company\Http\Controllers;

use FullRent\Core\CommandBus\CommandBus;
use FullRent\Core\Company\Commands\RegisterCompany;
use FullRent\Core\Company\ValueObjects\CompanyDomain;
use FullRent\Core\Company\ValueObjects\CompanyName;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class CompaniesWriteController
 * @package app\Http\Companies\Controllers
 * @author Simon Bennett <simon@bennett.im>
 */
final class CompaniesWriteController extends Controller
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @param CommandBus $bus
     */
    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    public function create(Request $request)
    {
        $command = new RegisterCompany(
            new CompanyName($request->get('company_name')),
            new CompanyDomain($request->get('company_domain'))
        );

        $this->bus->execute($command);
        dd($command->getCompanyId());
    }
}