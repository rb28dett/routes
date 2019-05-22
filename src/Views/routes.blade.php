@extends('rb28dett::layouts.master')
@section('icon', 'ion-soup-can')
@section('title', __('rb28dett_routes::general.routes'))
@section('subtitle', __('rb28dett_routes::general.routes_desc'))
@section('breadcrumb')
    <ul class="uk-breadcrumb">
        <li><a href="{{ route('rb28dett::index') }}">@lang('rb28dett_routes::general.home')</a></li>
        <li><span>@lang('rb28dett_routes::general.routes')</span></li>
    </ul>
@endsection
@section('content')
    <div class="uk-container uk-container-large">
        <div uk-grid>
            <div class="uk-width-1-1">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        @lang('rb28dett_routes::general.routes')
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-overflow-auto">
                            <table class="uk-table uk-table-striped">
                                <thead>
                                    <tr>
                                        <th>@lang('rb28dett_routes::general.name')</th>
                                        <th>@lang('rb28dett_routes::general.method')</th>
                                        <th>@lang('rb28dett_routes::general.uri')</th>
                                        <th>@lang('rb28dett_routes::general.action')</th>
                                        <th>@lang('rb28dett_routes::general.middleware')</th>
                                        <th>@lang('rb28dett_routes::general.host')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($routes as $route)
                                        <tr>
                                            <td>{{ $route->name }}</td>
                                            <th>{{ $route->method }}</th>
                                            <th>{{ $route->uri }}</th>
                                            <th>{{ $route->action }}</th>
                                            <th>{{ $route->middleware }}</th>
                                            <th>{{ $route->host }}</th>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $routes->links('rb28dett::layouts.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
