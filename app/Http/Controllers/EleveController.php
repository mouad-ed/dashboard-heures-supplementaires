<?php
namespace App\Http\Controllers;

use App\Models\Eleve;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    // LIST
    public function index()
    {
        $eleves = Eleve::latest()->paginate(10);

        return view('eleves.index', compact('eleves'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'father_phone' => 'required',
        ]);

        Eleve::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'father_phone' => $request->father_phone,
        ]);

        return redirect()->route('eleves.index')
                         ->with('success', 'Élève ajouté avec succès');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'father_phone' => 'required',
        ]);

        $eleve->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'father_phone' => $request->father_phone,
        ]);

        return redirect()->route('eleves.index')
                         ->with('success', 'Élève modifié');
    }

    // DELETE (AJAX)
    public function destroy($id)
    {
        $eleve = Eleve::findOrFail($id);
        $eleve->delete();

        return response()->json([
            'success' => true
        ]);
    }
}