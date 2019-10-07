<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateReport;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    protected $reportModel;

    public function __construct(Report $model){
        $this->reportModel = $model;
    }

    public function store(ValidateReport $request)
    {
        return response()->json($this->reportModel->report(Auth::id(), $request->reported_id, $request->description));
    }
}
