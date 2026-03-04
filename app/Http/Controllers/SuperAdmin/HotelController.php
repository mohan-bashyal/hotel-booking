<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Services\HotelService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function __construct(
        private HotelService $hotelService
    ) {}

    public function index()
    {
        $hotels = $this->hotelService->getAll();
        return view('superadmin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('superadmin.hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $this->hotelService->create($validated);

        return redirect()
            ->route('superadmin.hotels.index')
            ->with('success','Hotel created successfully');
    }

    public function edit(Hotel $hotel)
    {
        return view('superadmin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        $this->hotelService->update($hotel, $validated);

        return redirect()
            ->route('superadmin.hotels.index')
            ->with('success','Hotel updated successfully');
    }

    public function destroy(Hotel $hotel)
    {
        $this->hotelService->delete($hotel);

        return redirect()
            ->route('superadmin.hotels.index')
            ->with('success','Hotel deleted successfully');
    }
}
