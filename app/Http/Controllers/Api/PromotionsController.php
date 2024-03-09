<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotions;
use Illuminate\Support\Facades\DB;


class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = promotions::all();
        return response()->json($promotions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try{
            $request -> validate([
                'promotion_name' => 'required',
                'description' => 'required',
                'discount' => 'required | integer | min:0 | max:100',
                'start_date' => 'required | date  ',
                'end_date' => 'required | date  ',
                'is_show' => 'required | boolean'
            ]);

            $promotion = new Promotions();
            $promotion -> promotion_name = $request -> promotion_name;
            $promotion -> description = $request -> description;
            $promotion -> discount = $request -> discount;
            $promotion -> start_date = $request -> start_date;
            $promotion -> end_date = $request -> end_date;
            $promotion -> is_show = $request -> is_show;

            $promotion -> save();
            return response()->json(['message' => 'Promotion created successfully'], 201);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error creating promotion', 'error' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
