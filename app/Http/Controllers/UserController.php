<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $datas = User::all();
        $columns = [
            [
                'name' => 'name',
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'type' => 'text',
            ],
            [
                'name' => 'phone',
                'type' => 'text',
            ],
            [
                'name' => 'image',
                'type' => 'image',
            ],
            [
                'name' => 'roles',
                'type' => 'relation',
                'rlt_type' => 'single',
                'rlt_name' => 'roles',
                'rlt_index' => 0,
                'rlt_key' => 'name',
            ],
            [
                'name' => 'created_at',
                'type' => 'text',
            ],
        ];
        return view('crud.user.index', compact('datas', 'columns'));
    }

    public function add(){
        return view('crud.user.add');
    }

    // Store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'required|numeric|digits_between:1,14|unique:users,phone',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' requires a matching 'cpassword' field
            'role' => 'required|exists:roles,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
        
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        // Handle file upload
        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        try {
            // Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'image' => $imagePath,
            ]);
            if($user)
                $user->assignRole($request->role);

            return redirect()->route('user.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat user, error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); // Cari user berdasarkan ID

        return view('crud.user.edit', compact('user'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . '|max:255', // Email harus unik kecuali untuk user ini
            'phone' => 'required|numeric|digits_between:1,14|unique:users,phone,'.$id,
            'password' => 'nullable|string|min:8|confirmed', // 'confirmed' memerlukan field 'password_confirmation'
            'role' => 'required|exists:roles,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
        
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        $user = User::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Hapus image lama jika ada
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            // Simpan image baru
            $imagePath = $request->file('image')->store('users', 'public');
        } else {
            // Gunakan image lama jika tidak ada yang diupload
            $imagePath = $user->image;
        }

        try {
            // Reset verified fields if email or phone has changed
            $emailChanged = $request->email !== $user->email;
            $phoneChanged = $request->phone !== $user->phone;
        
            // Update user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'image' => $imagePath,
                'email_verified_at' => $emailChanged ? null : $user->email_verified_at,
                'phone_verified_at' => $phoneChanged ? null : $user->phone_verified_at,
            ]);
        
            // Update role
            if($request->role) {
                $user->syncRoles([$request->role]); // Sinkronisasi role yang baru
            }
        
            return redirect()->route('user.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupdate user, error: ' . $e->getMessage());
        }        
    }


    // Destroy
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete the image from storage
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully.');
    }

    // --------------- Profile
    // Update Data Image & Name
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $user = User::findOrFail($user->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user->name = $request->input('name');

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete('users/' . $user->image);
            }

            $imagePath = $request->file('image')->store('users', 'public');

            $user->image = $imagePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
