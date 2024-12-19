<?php

namespace App\Http\Controllers;

use App\Models\GroupSetting;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\XmlConfiguration\Group;

class SettingController extends Controller
{
    public function index(){
        $group_settings = GroupSetting::with(['settings' => function($query) {
                            $query->orderBy('created_at', 'asc');  
                        }])->orderBy('created_at', 'asc')->get();
        $settings = Setting::all();
        return view('setting.index', compact('group_settings', 'settings'));
    }

    public function add(){
        return ;
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'the_key' => 'required|string',
            'type_form' => 'required|string',
            'options' => 'nullable',
            'group' => 'required',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);

            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }

            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }
        try {
            // Simpan perubahan ke database
            $options = null;
            if($request->options)
                $options = explode(',',$request->options);

            $create = Setting::create([
                'name' => $request->name,
                'description' => $request->description,
                'the_key' => $request->the_key,
                'type_form' => $request->type_form,
                'options' => $options != null ? json_encode($options) : null,
                'group_id' => $request->group,
            ]);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Setting updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('setting.index')
                ->with('success', 'Setting created successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal membuat setting, error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat setting, error: ' . $e->getMessage());
        }
    }

    public function edit(){
        return ;
    }

    public function update($id, Request $request)
    {
        $setting = Setting::findOrFail($id);
        if($setting->is_urgent == 1){
            return redirect()->back()->withInput()
            ->with('error', 'Setting gagal diupdate, Setting ini diperlukan dalam sistem');
        }

        // Validasi input
        if ($setting->type_form == 'image') {
            // Validator untuk file image
            $validator = Validator::make($request->all(), [
                'the_value' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validasi gambar
            ]);
        } elseif ($setting->type_form == 'file') {
            // Validator untuk file dokumen (bukan image)
            $validator = Validator::make($request->all(), [
                'the_value' => 'nullable|file|mimes:pdf,doc,docx,xlsx,xls|max:5120', // Validasi dokumen (pdf, doc, dll)
            ]);
        } else {
            // Validator umum untuk selain file atau image
            $validator = Validator::make($request->all(), [
                'the_value' => 'nullable',
            ]);
        }
        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);

            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }

            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        // Proses penyimpanan file jika type_form adalah image atau file
        if ($setting->type_form == 'image' || $setting->type_form == 'file') {
            if ($setting->the_value && storage_path('app/public/' . $setting->the_value)) {
                // Hapus file lama
                Storage::disk('public')->delete($setting->the_value);
            }
            if ($request->hasFile('the_value')) {
                // Simpan file ke storage dengan path sesuai kebutuhan, misalnya folder 'settings'
                $filePath = $request->file('the_value')->store('settings', 'public');

                // Update kolom 'the_value' dengan path file yang disimpan
                $setting->the_value = $filePath;
            }
        } else {
            // Jika bukan file atau image, update kolom 'the_value' secara langsung
            $setting->the_value = $request->the_value;
        }

        try {
            // Simpan perubahan ke database
            $setting->save();

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => $setting->name . ' updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('setting.index')
                ->with('success', $setting->name . ' updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal mengupdate ' . $setting->name . ', error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal mengupdate ' . $setting->name . ', error: ' . $e->getMessage());
        }
    }

    public function clearFile($id){
        $setting = Setting::findOrFail($id);
        if($setting->type_form == 'image' || $setting->type_form == 'file'){
            
            if ($setting->the_value && storage_path('app/public/' . $setting->the_value)) {
                // Hapus file lama
                Storage::disk('public')->delete($setting->the_value);
                $setting->the_value = null;
                $setting->save();
                return redirect()->back()
                        ->with('success','Berhasil mengosongkan file pada Setting : '.$setting->name);
            }else{
                return redirect()->back()
                        ->with('error','Error : '.$setting->name.' tidak ditemukan atau file tidak ada.');
            }
        }else{
            return redirect()->back()
                        ->with('error','Error : '.$setting->name.' bukan bertipe file.');
        }
    }

    public function destroy($id){
        try {
            $setting = Setting::findOrFail($id);
            if($setting->is_urgent == 1){
                return redirect()->back()->withInput()
                ->with('error', 'Setting gagal dihapus, Setting ini diperlukan dalam sistem');
            }
            if($setting->type_form == 'image' || $setting->type_form == 'file'){
                if ($setting->the_value && storage_path('app/public/' . $setting->the_value)) {
                    // Hapus file lama
                    Storage::disk('public')->delete($setting->the_value);
                }
            }
            $setting->delete();

            return redirect()->route('setting.index')
                ->with('success','Setting berhasil dihapus.');
        } catch (\Exception $e) {

            return redirect()->back()->withInput()
                ->with('error', 'Setting gagal dihapus, error: ' . $e->getMessage());
        }
    }

    public function addGroup(Request $request){
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            
            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }
            
            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        try {
            // Simpan quotation baru
            $gs = GroupSetting::create([
                'name' => $request->name,
            ]);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Group Setting created successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->route('setting.index')
                ->with('success', 'Group Setting created successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal membuat Group Setting, error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal membuat Group Setting, error: ' . $e->getMessage());
        }
    }

    public function updateGroup($id, Request $request){
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            // Menggabungkan semua pesan kesalahan menjadi satu teks
            $errorMessages = $validator->errors()->all();
            $errorMessageText = implode(' ', $errorMessages);
            
            // Jika request adalah AJAX, kembalikan respons JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => $errorMessageText]);
            }
            
            // Untuk request biasa, redirect dengan pesan error
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('warning', $errorMessageText);
        }

        try {
            // Simpan quotation baru
            $gs = GroupSetting::findOrFail($id);
            
            $gs->update([
                'name' => $request->name,
            ]);

            // Jika request adalah AJAX, kembalikan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Group Setting updated successfully.']);
            }

            // Untuk request biasa, redirect ke halaman index dengan pesan sukses
            return redirect()->back()
                ->with('success', 'Group Setting updated successfully.');
        } catch (\Exception $e) {
            // Jika terjadi error, tangani sesuai dengan jenis request (AJAX atau non-AJAX)
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Gagal mengupdate Group Setting, error: ' . $e->getMessage()]);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Gagal mengupdate Group Setting, error: ' . $e->getMessage());
        }
    }

    public function destroyGroup($id){
        try {
            $gs = GroupSetting::findOrFail($id);
            if($gs->is_urgent == 1){
                return redirect()->back()->withInput()
                ->with('error', 'Group Setting gagal dihapus, Setting ini diperlukan dalam sistem');
            }
            $gs->delete();
            return redirect()->back()
                ->with('success', 'Group Setting destroyed successfully.');
        } catch (\Exception $e) {
            
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menghapus Group Setting, error: ' . $e->getMessage());
        }
    }
}
