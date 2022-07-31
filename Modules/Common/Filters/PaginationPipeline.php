<?php


namespace Modules\Common\Filters;

use Closure;

class PaginationPipeline
{
    public function handle($request, Closure $next)
    {
        if (! request()->has('per_page')) {
            return $next($request)->paginate(10);
        }
        return $next($request)->paginate(request('per_page'));
    }
}