<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientRequest;
use App\Models\Client;
use App\Services\FileUploadService;

class ClientController extends Controller
{
    public function __construct(private FileUploadService $fileUploadService)
    {
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
        $data = $request->safe()->except('logo');
        if ($request->hasFile('logo')) {
            try {
                $data['logo_url'] = $this->fileUploadService->upload($request->file('logo'), 'clients');
            } catch (\Throwable $exception) {
                return $this->uploadFailure('logo', $exception);
            }
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
        $data = $request->safe()->except('logo');
        if ($request->hasFile('logo')) {
            try {
                $data['logo_url'] = $this->fileUploadService->upload($request->file('logo'), 'clients', $client->logo_url);
            } catch (\Throwable $exception) {
                return $this->uploadFailure('logo', $exception);
            }
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
