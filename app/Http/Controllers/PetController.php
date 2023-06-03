<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Nette\Utils\Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdoptionConfirmation;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::paginate(3);
        $selectedPetId = session()->get('selectedPetId');
        $selectedPet = null;
        if ($selectedPetId) {
            $selectedPet = Pet::find($selectedPetId);
        }
        return view('pets.index', compact('pets', 'selectedPet'));
    }

    public function select($id)
    {
        $selectedPet = Pet::findOrFail($id);
        $pets = Pet::paginate(3);

        return view('pets.index', compact('pets', 'selectedPet'))->with('selectedPetId', $id);
    }


    public function create()
    {
        return view('pets.create');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|string|in:male,female',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:500',
        ]);

        $pet = new Pet([
            'name' => $request->input('name'),
            'species' => $request->input('species'),
            'age' => $request->input('age'),
            'gender' => $request->input('gender'),
            'description' => $request->input('description'),
            'adopted' => false,
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = $photo->getClientOriginalName();
            $path = $photo->storeAs('public/pets', $filename);
            // Image::make($photo)->resize(300, 300)->save($location);
            $pet->photo = $filename;
        }

        $pet->save();

        return redirect()->route('pets.index')
            ->with('success', 'Pet created successfully.');
    }
    public function edit(Pet $pet)
    {
        $currentPhoto = $pet->photo;
        return view('pets.edit', compact('pet', 'currentPhoto'));
    }

    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|string|in:male,female',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string|max:500',
        ]);

        $pet->name = $request->input('name');
        $species = $request->input('species');
        if ($species === 'other') {
            $pet->species = $request->input('other_species');
        } else {
            $pet->species = $species;
        }
        $pet->age = $request->input('age');
        $pet->gender = $request->input('gender');
        $pet->description = $request->input('description');

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = $photo->getClientOriginalName();
            $path = $photo->storeAs('public/pets', $filename);
            $pet->photo = $filename;
        }

        $pet->save();

        return redirect()->route('pets.index')
            ->with('success', 'Pet updated successfully.');
    }


    public function destroy(Pet $pet)
    {
        $pet->delete();

        return redirect()->back()->with('success', 'Pet deleted successfully');
    }
}
