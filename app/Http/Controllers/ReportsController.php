<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 20/04/2015
 * Time: 18:10
 */

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests;
use Illuminate\Http\Request;


class ReportsController  extends BaseController {

    /**
     * Display a listing of listings
     *
     * @return Response
     */
    public function index()
    {

        return \View::make('reports.index');
    }

}