<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 20/04/2015
 * Time: 18:10
 */

namespace App\Http\Controllers;

use Auth;
use App\Models\Listing;
use App\Models\TimeLog;
use Carbon\Carbon;
use Session;


class TimeLogController extends BaseController
{

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {

        $listings = Listing::query()->orderBy('name')->get(['id', 'name'])->pluck('name', 'id');
        return \View::make('time_logs.create', compact('listings'));
    }


    /**
     * @return string
     */
    public function index()
    {

        if (\Request::has('init')) {
            Session::forget('time_logs');
        }

        if (\Request::has('listing_id')) {
            if (\Request::get('listing_id') == 0) {
                Session::forget('time_logs.listing_id');
            } else {
                Session::put('time_logs.listing_id', \Request::get('listing_id'));
            }
        }


        $listings = Listing::query()->orderBy('name')->get(['id', 'name'])->pluck('name', 'id');
        $timeLogs = TimeLog::where('user_id','=',Auth::user()->id)->orderBy('start', 'desc')
            ->with('Listing:id,name')
            ->with('User:name');

        if (Session::has('time_logs.listing_id')) {
            $timeLogs->where('listing_id','=',Session::get('time_logs.listing_id'));
        }

        $timeLogs = $timeLogs->simplePaginate(20);

        return \View::make('time_logs.index', compact('timeLogs' ,'listings'));
    }

    /**
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $validator = \Validator::make($data = \Request::all(), TimeLog::$rules);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

        $data['user_id'] = Auth::user()->id;
        $data['start'] = Carbon::createFromFormat('Y-m-d H:i', $data['start_date'] . ' ' . $data['start_time'])->toDateTimeString(); ;
        $data['end'] = Carbon::createFromFormat('Y-m-d H:i', $data['start_date']. ' ' . $data['end_time'])->toDateTimeString(); ;
        unset($data['start_time'],$data['start_date'],$data['end_time'] );

        TimeLog::create($data);

        return \Redirect::route('time_logs');
    }

}