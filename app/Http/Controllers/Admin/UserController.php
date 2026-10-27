<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private FileUploadService $fileUploadService)
    {
    }

    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->safe()->only(['name', 'email', 'password']);

        if ($request->hasFile('profile_photo')) {
            try {
                $data['profile_photo_url'] = $this->fileUploadService->upload($request->file('profile_photo'), 'profile_photos');
            } catch (\Throwable $exception) {
                return $this->uploadFailure('profile_photo', $exception);
            }
        }

        $data['role'] = User::ROLE_ADMIN;

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->safe()->only(['name', 'email']);

        // The model's "hashed" cast hashes the new password on save.
        if ($request->filled('password')) {
            $data['password'] = $request->validated('password');
        }

        if ($request->hasFile('profile_photo')) {
            try {
                $data['profile_photo_url'] = $this->fileUploadService->upload($request->file('profile_photo'), 'profile_photos', $user->profile_photo_url);
            } catch (\Throwable $exception) {
                return $this->uploadFailure('profile_photo', $exception);
            }
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
