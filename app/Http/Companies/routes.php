<?php
/** @var Router $router */
use App\Http\Companies\Controllers\CompaniesWriteController;
use Illuminate\Routing\Router;

$router->post('companies', CompaniesWriteController::class . '@create');