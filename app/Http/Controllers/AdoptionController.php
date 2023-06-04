<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Nette\Utils\Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdoptionConfirmation;

class AdoptionController extends Controller
{
    public function index()
    {
        $pets = Pet::where('adopted', false)->get();
        $selectedPetId = session()->get('selectedPetId');
        $selectedPet = null;
        if ($selectedPetId) {
            $selectedPet = Pet::find($selectedPetId);
        }
        return view('adopt.index', compact('pets', 'selectedPet'));
    }

    public function select($id)
    {
        $selectedPet = Pet::findOrFail($id);
        $pets = Pet::where('adopted', false)->get();

        return view('adopt.index', compact('pets', 'selectedPet'))->with('selectedPetId', $id);
    }

    public function create()
    {
        $pets = Pet::where('adopted', false)->get();
        return view('adopt.create', compact('pets'));
    }

    public function createPet()
    {
        return view('adopt.create');
    }
    //para adoptar mascotas, cuando adoptas adopted cambia a 1 (true)
    public function store(Request $request)
    {
        $petId = $request->input('pet_id');
        $pet = Pet::find($petId);

        if (!$pet) {
            return redirect()->back()->with('error', 'Pet not found.');
        } else {
            $pet->adopted = 1;
            $pet->save();
            // send adoption confirmation email
            $email = $request->input('email');
            Mail::to($email)->send(new AdoptionConfirmation($pet));

            return redirect()->route('adopt')
                ->with('success', 'Adoption request submitted. Check your mail!');
        }
    }

    public function storePet(Request $request)
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

        return redirect()->route('adopt')
            ->with('success', 'Pet created successfully.');
    }

  
}
