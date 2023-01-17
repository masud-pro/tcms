<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminAccountRequest;
use App\Http\Requests\UpdateAdminAccountRequest;
use App\Models\AdminAccount;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdminAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function show(AdminAccount $subAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminAccount $subAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminAccountRequest  $request
     * @param  \App\Models\AdminAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminAccountRequest $request, AdminAccount $subAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminAccount  $subAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminAccount $subAccount)
    {
        //
    }
}