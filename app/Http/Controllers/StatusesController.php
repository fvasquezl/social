<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Events\StatusCreated;
use App\Http\Resources\StatusResource;

class StatusesController extends Controller
{
    public function index()
    {
        return StatusResource::collection(
            Status::latest()->paginate()
        );
    }

    /**
     * @param Request $request
     * @return StatusResource
     */
    public function store(Request $request)
    {
        $validStatus = $request->validate(['body' => 'required|min:5']);

        $status = $request->user()->statuses()->create($validStatus);

        $statusResource = StatusResource::make($status);

        StatusCreated::dispatch($statusResource);

        return $statusResource;
    }
}
