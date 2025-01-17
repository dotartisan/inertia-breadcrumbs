<?php

namespace RobertBoes\InertiaBreadcrumbs;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use RobertBoes\InertiaBreadcrumbs\Collectors\BreadcrumbCollectorContract;

class Middleware
{
    public BreadcrumbCollectorContract $collector;

    public function __construct(BreadcrumbCollectorContract $collector)
    {
        $this->collector = $collector;
    }

    public function handle(Request $request, Closure $next)
    {
        $breadcrumbs = $this->collector->forRequest($request);

        if ($breadcrumbs->items()->isEmpty()) {
            return $next($request);
        }

        Inertia::share('breadcrumbs', $breadcrumbs);

        return $next($request);
    }
}
