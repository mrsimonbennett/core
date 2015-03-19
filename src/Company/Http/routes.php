<?php
/** @var Router $router */
use FullRent\Core\Company\Http\Controllers\CompaniesWriteController;
use Illuminate\Routing\Router;

$router->post('companies', CompaniesWriteController::class . '@create');