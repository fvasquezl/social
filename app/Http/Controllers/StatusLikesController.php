<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusLikesController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Status $status
     * @return void
     */
    public function store(Status $status)
    {

        $status->like();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Status $status
     * @return void
     */
    public function destroy(Status $status)
    {

        $status->unlike();

    }

}
