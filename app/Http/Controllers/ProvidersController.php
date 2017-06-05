<?php namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Provider;
use Illuminate\Http\Request;
use Session;

class ProvidersController extends BaseController
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request)
    {


        $term = trim($request->input('q'));

        if (empty($term)) {
            return \Response::json([]);
        }

        $providers = Provider::search($term)->where('mobile','!=','')->limit(5)->get();

        $formatted_tags = [];

        $mobileNumberPattern = '/^[0-9\.\-+]{9,}+$/';
        if (preg_match($mobileNumberPattern, $term)) {
            $formatted_tags[] = ['id' => $term, 'text' => $term];
        }


        foreach ($providers as $provider) {
            $formatted_tags[] = ['id' => $provider->mobile, 'text' => $provider->first_name . ' ' . $provider->last_name];
        }

        return \Response::json($formatted_tags);
    }

    /**
     * Display a listing of providers
     *
     * @return Response
     */
    public function index()
    {
        $providers = Provider::all();

        return \View::make('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new provider
     *
     * @return Response
     */
    public function create()
    {

        return \View::make('providers.create');
    }

    /**
     * Store a newly created provider in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = \Validator::make($data = \Request::all(), Provider::$rules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        Provider::create($data);

        return \Redirect::route('providers.index');
    }

    /**
     * Display the specified provider.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $provider = Provider::findOrFail($id);

        return \View::make('providers.show', compact('provider'));
    }

    /**
     * Show the form for editing the specified provider.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $provider = Provider::find($id);

        return \View::make('providers.edit', compact('provider'));
    }

    /**
     * Update the specified provider in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $provider = Provider::findOrFail($id);

        $validator = \Validator::make($data = Request::all(), Provider::$rules);

        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $provider->update($data);

        return \Redirect::route('providers');
    }

    /**
     * Remove the specified provider from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        Provider::destroy($id);

        return \Redirect::route('providers');
    }

}
