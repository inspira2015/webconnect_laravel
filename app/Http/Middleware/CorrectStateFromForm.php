<?php

namespace App\Http\Middleware;
use App\Models\BailConfiguration;

use Closure;

class CorrectStateFromForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!isset($request->non_us_state)) {
            return $next($request);
        }

        if (is_numeric($request->m_surety_state)) {
            $state = BailConfiguration::GetStateAbvById($request->m_surety_state);
            $request->merge(['m_surety_state' => $this->getCorrectStringState($request, $state)]);
        }
        return $next($request);
    }

    private function getCorrectStringState($request, $state)
    {
        if (strcasecmp($state, 'OTHER') == 0) {
            return $request->non_us_state;
        }
        return $state;
    }
}
