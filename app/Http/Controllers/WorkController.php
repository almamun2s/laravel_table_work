<?php

namespace App\Http\Controllers;

use App\Models\CompanyName;
use App\Models\Market;
use App\Models\OfferName;
use App\Models\User;
use App\Models\Work;
use Auth;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * Display a listing of the Work.
     */
    public function index()
    {
        if (Auth::user()->role != 1) {
            abort(404);
        }
        $works = Work::latest()->get();
        return view('admin.work.index', compact('works'));
    }

    /**
     * Selects a date for a work
     */
    public function select_date()
    {
        if (Auth::user()->role != 1) {
            abort(404);
        }
        return view('admin.work.select_date');
    }

    /**
     * Show the form for creating a new Work.
     */
    public function create(Request $request)
    {
        if (Auth::user()->role != 1) {
            abort(404);
        }
        if (empty($request->date)) {
            return redirect()->back()->withErrors(['error' => 'Please Select a date.']);
        }
        $date = $request->date;


        $users    = User::latest()->get();
        $accounts = Market::latest()->get();
        $offers   = OfferName::latest()->get();
        $devices  = CompanyName::latest()->get();
        return view('admin.work.create', compact('users', 'accounts', 'offers', 'date', 'devices'));
    }

    /**
     * Store a newly created Work in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role != 1) {
            abort(404);
        }
        foreach ($request->works as $work) {
            $work = json_decode($work);

            Work::create([
                    'user_id'         => $work->user_id,
                    'market_id'       => $work->account_id,
                    'offer_name_id'   => $work->offer_id,
                    'company_name_id' => $work->device_id,
                    'lead'            => (int) $work->lead,
                    'date'            => $request->date,
            ]);
        }

        return redirect()->route('work');
    }

    /**
     * Display the specified Work.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified Work.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified Work in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified Work from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
