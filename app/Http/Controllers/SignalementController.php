<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Photo;
use App\Models\Signalement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SignalementController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user()->load('role', 'agentMunicipal');

        $query = Signalement::query()
            ->with(['category', 'citoyen', 'agentMunicipal.user'])
            ->latest();

        if ($user->hasRole('citoyen')) {
            $query->where('citoyen_id', $user->id);
        }

        if ($user->hasRole('agent_municipal')) {
            $agentId = $user->agentMunicipal?->id;
            $query->where('agent_municipal_id', $agentId ?? 0);
        }

        return view('signalements.index', [
            'signalements' => $query->paginate(10),
            'user' => $user,
        ]);
    }

    public function show(Request $request, Signalement $signalement): View
    {
        $signalement->load(['category', 'citoyen', 'agentMunicipal.user']);
        $this->authorizeView($request->user(), $signalement);

        return view('signalements.show', [
            'signalement' => $signalement,
        ]);
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
        $this->authorizeCitizenOwner($request->user()->id, $signalement);

        return view('signalements.edit', [
            'signalement' => $signalement,
            'categories' => Category::query()->orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Signalement $signalement): RedirectResponse
    {
        $this->authorizeCitizenOwner($request->user()->id, $signalement);

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
        $this->authorizeCitizenOwner($request->user()->id, $signalement);

        $signalement->delete();

        return redirect()->route('signalements.index')->with('success', 'Signalement deleted successfully.');
    }

    private function authorizeView($user, Signalement $signalement): void
    {
        if ($user->hasRole('admin')) {
            return;
        }

        if ($user->hasRole('citoyen') && $signalement->citoyen_id === $user->id) {
            return;
        }

        if ($user->hasRole('agent_municipal') && $signalement->agent_municipal_id === $user->agentMunicipal?->id) {
            return;
        }

        abort(403, 'You are not allowed to access this signalement.');
    }

    private function authorizeCitizenOwner(int $userId, Signalement $signalement): void
    {
        abort_unless($signalement->citoyen_id === $userId, 403, 'You can only manage your own signalements.');
    }
}
