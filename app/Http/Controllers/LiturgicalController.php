<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Liturgical;
use Illuminate\Support\Facades\DB;

class LiturgicalController extends Controller
{
 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.liturgical');
    }

    public function liturgical_annual()
    {
        return view('pages.liturgical.annually');
    }

    public function liturgical_month()
    {
        return view('pages.liturgical.monthly');
    }

    public function liturgical_week()
    {
        return view('pages.liturgical.weekly');
    }


    public function getListLiturgical(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);

        $perPage = 10; // Items per page

        $query = DB::table('liturgicals')
        ->where('status','Active');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%');
            });
        }

        $total = $query->count(); // Get total count for pagination
        $sched = $query->skip(($page - 1) * $perPage)
                    ->take($perPage)
                    ->get();

        return response()->json([
            'data' => $sched,
            'total' => $total,
            'current_page' => $page,
            'per_page' => $perPage
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.liturgical.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'requirements' => 'required|string',
            'fee' => 'numeric|min:0',
        ]);

        // Save the liturgical service
        $liturgical = Liturgical::create([
            'title' => $validatedData['title'],
            'requirements' => $validatedData['requirements'],
            'stipend' => $validatedData['fee'], // Save the stipend field
        ]);

        return response()->json(['message' => 'Liturgical created successfully', 'data' => $liturgical], 201);
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
    public function edit($id)
    {
        $liturgical = Liturgical::findOrFail($id);
        return view('pages.liturgical.edit', compact('liturgical'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Liturgical $liturgical)
    {
        $request->validate([
            'title' => 'sometimes|string',
            'requirements' => 'sometimes|string',
            'stipend' => 'sometimes|integer',
        ]);

        $liturgical->update($request->all());

        return response()->json(['message' => 'Liturgical updated successfully', 'data' => $liturgical]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Liturgical $liturgical)
    {
        $liturgical->delete();

        return response()->json(['message' => 'Liturgical deleted successfully']);
    }
}
