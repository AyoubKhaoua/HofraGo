<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HistoriqueStatut;
use App\Models\Photo;
use App\Models\Signalement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SignalementController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = Signalement::query()->latest();

        if ($user->role?->name === 'citoyen') {
            $query->where('citoyen_id', $user->id);
        }

        if ($user->role?->name === 'agent_municipal') {
            $agentId = $user->agentMunicipal?->id;
            $query->where('agent_municipal_id', $agentId ?? 0);
        }

        $signalements = $query->paginate(10);

        return view('signalements.index', compact('signalements', 'user'));
    }

    public function show(Request $request, Signalement $signalement): View
    {
        $user = $request->user();

        /*  if ($user->role->name === 'citoyen' && $signalement->citoyen_id !== $user->id) {
            abort(403, 'Access denied.');
        }
 */
        if (
            $user->role?->name === 'agent_municipal' &&
            $signalement->agent_municipal_id !== ($user->agentMunicipal?->id)
        ) {
            abort(403, 'Access denied.');
        }

        $canUpdateStatus = in_array($user->role->name, ['admin', 'agent_municipal'], true);

        $nextStatuses = [];
        if ($signalement->statut === 'en_attente') {
            $nextStatuses = ['en_cours', 'rejete'];
        } elseif ($signalement->statut === 'en_cours') {
            $nextStatuses = ['resolu', 'rejete'];
        }

        $historiqueStatuts = $signalement->historiqueStatuts()->orderByDesc('id')->get();

        return view('signalements.show', compact('signalement', 'canUpdateStatus', 'nextStatuses', 'historiqueStatuts'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('signalements.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'localisation' => ['nullable', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
        ]);

        $signalement = Signalement::query()->create([
            'titre' => $data['titre'],
            'description' => $data['description'],
            'category_id' => $data['category_id'],
            'localisation' => $data['localisation'] ?? null,
            'citoyen_id' => $request->user()->id,
            'statut' => 'en_attente',
            'date_signalement' => now()->toDateString(),
        ]);

        HistoriqueStatut::query()->create([
            'titre' => 'Creation du signalement',
            'ancien_statut' => '-',
            'nouveau_statut' => 'en_attente',
            'date_changement' => now()->toDateString(),
            'signalement_id' => $signalement->id,
        ]);

        if ($request->hasFile('images') && is_array($request->file('images'))) {
            foreach ($request->file('images') as $image) {
                $path = $image->storePublicly('signalements', 'public');
                Photo::query()->create([
                    'signalement_id' => $signalement->id,
                    'path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('signalements.index')->with('success', 'Signalement created successfully.');
    }

    public function edit(Request $request, Signalement $signalement): View
    {
        if ($signalement->citoyen_id !== $request->user()->id) {
            abort(403, 'Access denied.');
        }

        $categories = Category::query()->orderBy('title')->get();

        return view('signalements.edit', compact('signalement', 'categories'));
    }

    public function update(Request $request, Signalement $signalement): RedirectResponse
    {
        if ($signalement->citoyen_id !== $request->user()->id) {
            abort(403, 'Access denied.');
        }

        $data = $request->validate([
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'localisation' => ['nullable', 'string', 'max:255'],
        ]);

        $signalement->update($data);

        return redirect()->route('signalements.index')->with('success', 'Signalement updated successfully.');
    }

    public function destroy(Request $request, Signalement $signalement): RedirectResponse
    {
        if ($signalement->citoyen_id !== $request->user()->id) {
            abort(403, 'Access denied.');
        }

        $signalement->delete();

        return redirect()->route('signalements.index')->with('success', 'Signalement deleted successfully.');
    }

    public function updateStatus(Request $request, Signalement $signalement): RedirectResponse
    {
        $user = $request->user();

        if (! in_array($user->role->name, ['admin', 'agent_municipal'], true)) {
            abort(403, 'Access denied.');
        }

        if (
            $user->role?->name === 'agent_municipal' &&
            $signalement->agent_municipal_id !== ($user->agentMunicipal?->id)
        ) {
            abort(403, 'Access denied.');
        }

        $data = $request->validate([
            'statut' => ['required', 'in:en_attente,en_cours,resolu,rejete'],
        ]);

        $ancienStatut = $signalement->statut;
        $nouveauStatut = $data['statut'];

        $allowedTransitions = [
            'en_attente' => ['en_cours', 'rejete'],
            'en_cours' => ['resolu', 'rejete'],
            'resolu' => [],
            'rejete' => [],
        ];

        if (! in_array($nouveauStatut, $allowedTransitions[$ancienStatut] ?? [], true)) {
            return back()->withErrors([
                'statut' => 'Transition de statut invalide.',
            ]);
        }

        $signalement->update([
            'statut' => $nouveauStatut,
        ]);

        HistoriqueStatut::query()->create([
            'titre' => 'Changement de statut',
            'ancien_statut' => $ancienStatut,
            'nouveau_statut' => $nouveauStatut,
            'date_changement' => now()->toDateString(),
            'signalement_id' => $signalement->id,
        ]);

        return redirect()->route('signalements.show', $signalement)->with('success', 'Statut mis a jour.');
    }
}
