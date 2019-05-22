<?php

namespace RB28DETT\Routes\Controllers;

use App\Http\Controllers\Controller;
use RB28DETT\Routes\RoutesInfo;

class RoutesController extends Controller
{
    /**
     * The RoutesInfo instance.
     *
     * @var \RB28DETT\Routes\RoutesInfo
     */
    protected $routesInfo;

    /**
     * RoutesController constructor.
     */
    public function __construct(RoutesInfo $routesInfo)
    {
        $this->routesInfo = $routesInfo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function routes()
    {
        $routes = $this->routesInfo->getPaginatedRoutes();

        return view('rb28dett_routes::routes', ['routes' => $routes]);
    }
}
