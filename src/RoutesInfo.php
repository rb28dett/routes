<?php

namespace RB28DETT\Routes;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use RB28DETT\Routes\Models\Route as RB28DETTRoute;

class RoutesInfo
{
    /**
     * The router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * An array of all the registered routes.
     *
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    /**
     * RoutesInfo constructor.
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @param string $sort
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllRoutes($sort = null)
    {
        $routes = collect($this->routes)->map(function ($route) {
            return $this->getRouteInformation($route);
        })->all();

        if ($sort) {
            $routes = $this->sortRoutes($sort, $routes);
        }

        return collect(array_filter($routes));
    }

    /**
     * Get paginated Routes.
     *
     * @param string $sort
     * @param int    $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getPaginatedRoutes($sort = 'name', $perPage = null)
    {
        return $this->paginate(
            $this->getAllRoutes($sort), $perPage
        );
    }

    /**
     * Get the route information for a given route.
     *
     * @param \Illuminate\Routing\Route as BaseRoute $route
     *
     * @return \RB28DETT\Routes\Models\Route
     */
    public function getRouteInformation(Route $route)
    {
        return new RB28DETTRoute([
            'host'       => $route->domain(),
            'method'     => implode('|', $route->methods()),
            'uri'        => $route->uri(),
            'name'       => $route->getName(),
            'action'     => $route->getActionName(),
            'middleware' => $this->getRouteMiddleware($route),
        ]);
    }

    /**
     * Sort the routes by a given element.
     *
     * @param string $sort
     * @param array  $routes
     *
     * @return array
     */
    protected function sortRoutes($sort, $routes)
    {
        return Arr::sort($routes, function ($route) use ($sort) {
            return $route[$sort];
        });
    }

    /**
     * Get before filters.
     *
     * @param \Illuminate\Routing\Route $route
     *
     * @return string
     */
    public function getRouteMiddleware($route)
    {
        return collect($route->gatherMiddleware())->map(function ($middleware) {
            return $middleware instanceof Closure ? 'Closure' : $middleware;
        })->implode(',');
    }

    /**
     * Paginate a laravel colletion or array of items.
     *
     * @param array    $items
     * @param int      $perPage
     * @param string   $pageName
     * @param int|null $page
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($items, $perPage = null, $pageName = 'page', $page = null)
    {
        if (is_array($items)) {
            $items = collect($items);
        }

        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $items[0]->getPerPage();

        $results = $items->forPage(Paginator::resolveCurrentPage(), $perPage);

        $total = $items->count();

        return new LengthAwarePaginator($results, $total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }
}
