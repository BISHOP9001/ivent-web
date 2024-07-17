<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

abstract class Controller
{
    protected $base = '';
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }


    /**
     *
     * Override default view with inertia render
     */
    protected function view($viewPath, $content = [], $status = 200, array $headers = [])
    {
        return Inertia::render($this->base . $viewPath, $content);
    }

    /**
     * Get Auth User  an authenticated session.
     *
     *
     * @return \App\Models\User|mixed
     */
    public function user()
    {
        $user = Auth::user();
        if (!$user)
            return null;
        return User::find(Auth::user()->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function setLocale(Request $request)
    {
        App::setLocale($request->locale);
        if ($this->user()) {
            $locale = $this->user()->metaData()->where('key', 'locale')->first();
            if ($locale) {
                $locale->update(['value' => $request->locale]);
            } else {
                $this->user()->metaData()->create([
                    'key' => 'locale',
                    'value' => $request->locale,
                ]);
            }
        }
    }
    public function setTimeZone(Request $request)
    {
        if ($this->user()) {
            return $this->user()->updateMetaData('timezone', $request->timezone);
        }
    }
    public function paginate(Request $request, $resource)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', null);
        if ($limit) {
            $resource = $resource
                ->offset($offset)
                ->limit($limit);
        }
        return $resource->get();
    }
}
