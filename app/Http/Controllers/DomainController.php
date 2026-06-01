<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Services\DomainCheckerService;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domains = auth()->user()
            ->domains()
            ->latest()
            ->paginate(20);

        return view('domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('domains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DomainCheckerService $service, Request $request)
    {
        $data = $request->validate([
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}$/i',
            ],
            'title' => [
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'domain.regex' => 'Enter correct domain name (example.com)',
        ]);

        $domain = auth()->user()->domains()->create($data);

        if ($domain) {
            $service->check($domain);
        }

        return redirect()
            ->route('domains.index')
            ->with('success', 'Domain created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Domain $domain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Domain $domain)
    {
        return view('domains.edit', compact('domain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DomainCheckerService $service, Request $request, Domain $domain)
    {
//        $this->authorize('update', $domain);

        $data = $request->validate([
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}$/i',
            ],
            'title' => [
                'nullable',
                'string',
                'max:255',
            ],
        ], [
            'domain.regex' => 'Enter correct domain name (example.com)',
        ]);

        $domain->update($data);

        $service->check($domain);

        return redirect()
            ->route('domains.index')
            ->with('success', 'Domain updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Domain $domain)
    {
        $domain->delete();

        return redirect()
            ->route('domains.index')
            ->with('success', 'Domain deleted successfully');
    }

    public function check(DomainCheckerService $service, $id)
    {
        $domain = Domain::findOrFail($id);
        $service->check($domain);

        return redirect()
            ->route('domains.index')
            ->with('success', 'Domain "' . $domain->domain . '" checked successfully');
    }
}
