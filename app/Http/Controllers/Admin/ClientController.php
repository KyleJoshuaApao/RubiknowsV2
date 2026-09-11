<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use App\Services\FileUploadService;

class ClientController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function index()
    {
        $clients = Client::latest()->paginate(10);

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        unset($data['logo']); // Remove logo from validated data as it's handled separately
        if ($request->hasFile('logo')) {
            $data['logo_url'] = $this->fileUploadService->upload($request->file('logo'), 'clients');
        }

        Client::create($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client)
    {
        $data = $request->validated();

        unset($data['logo']);
        if ($request->hasFile('logo')) {
            $data['logo_url'] = $this->fileUploadService->upload($request->file('logo'), 'clients', $client->logo_url);
        }

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $this->fileUploadService->delete($client->logo_url);
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }
}
