<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;


class SettingController extends Controller
{
    public function __construct()
    {
        // Page Title
        $this->module_title = __('settings.title');

        // module name
        $this->module_name = 'settings';

        // module icon
        $this->module_icon = 'fas fa-cogs';

        $this->global_booking = false;

        view()->share([
            'module_title' => $this->module_title,
            'module_name' => $this->module_name,
            'module_icon' => $this->module_icon,
            'global_booking' => $this->global_booking,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $module_action = 'List';

        return view('backend.settings.index', compact('module_action'));
    }

    public function index_data(Request $request)
    {
        $userId = auth()->id();
        $data = [];

        if (!isset($request->fields)) {
            return response()->json($data, 404);
        }

        $fields = explode(',', $request->fields);
        
        $data = Setting::whereIn('name', $fields)
            ->where(function($query) use ($userId) {
                $query->where('created_by', $userId)
                      ->orWhereNull('created_by');
            })
            ->get();

        $newData = [];
        foreach ($fields as $field) {
            $newData[$field] = setting($field);
            if (in_array($field, ['logo', 'mini_logo', 'mini_logo', 'dark_logo', 'dark_mini_logo', 'favicon'])) {
                $newData[$field] = asset(setting($field));
            }
        }

        $newData['quick_booking_url'] = route('app.quick-booking');
        return response()->json($newData, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $userId = auth()->id(); // Get current admin's ID
        
        if ($request->hasFile('json_file')) { // Check if file exists
            $file = $request->file('json_file');
            if ($file) {
            $fileName = $userId . '_' . $file->getClientOriginalName(); // Add user ID prefix
            $directoryPath = storage_path('app/data');

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            // Delete only this admin's previous JSON files
            $files = File::files($directoryPath);
            foreach ($files as $existingFile) {
                if (strpos($existingFile->getFilename(), $userId . '_') === 0 && 
                    strtolower($existingFile->getExtension()) === 'json') {
                    File::delete($existingFile->getPathname());
                }
            }
            $file->move($directoryPath, $fileName);
            }
        }

        unset($data['json_file']);
        $rules = $request->wantsJson() 
            ? Setting::getSelectedValidationRules(array_keys($request->all()))
            : Setting::getValidationRules();

        $data = $this->validate($request, $rules);
        $validSettings = array_keys($rules);

        foreach ($data as $key => $val) {
            if (in_array($key, $validSettings)) {
                $mimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/vnd.microsoft.icon'];
                if (gettype($val) == 'object') {
                    if ($val->getType() == 'file' && in_array($val->getmimeType(), $mimeTypes)) {
                        $setting = Setting::updateOrCreate(
                            ['name' => $key, 'created_by' => $userId],
                            ['val' => '', 'type' => Setting::getDataType($key)]
                        );
                        $mediaItems = $setting->addMedia($val)->toMediaCollection($key);
                        $setting->update(['val' => $mediaItems->getUrl()]);
                    }
                } else {
                    Setting::updateOrCreate(
                        ['name' => $key, 'created_by' => $userId],
                        ['val' => $val, 'type' => Setting::getDataType($key)]
                    );
                }
                if ($key === 'default_time_zone') {
                    Cache::forget('settings.default_time_zone');
    
                    // Fetch and apply the updated timezone
                    $newTimezone = $val;
                    Config::set('app.timezone', $newTimezone);
                    date_default_timezone_set($newTimezone);
                }
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => __('settings.save_setting'), 
                'status' => true
            ], 200);
        }

        return redirect()->back()->with('status', __('messages.setting_save'));
    }

    public function clear_cache()
    {
        Setting::flushCache();

        $message = __('messages.cache_cleard');

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function verify_email(Request $request)
    {
        $mailObject = $request->all();
        try {
            \Config::set('mail', $mailObject);
            Mail::raw('This is a smtp mail varification test mail!', function ($message) use ($mailObject) {
                $message->to($mailObject['email'])->subject('Test Email');
            });

            return response()->json(['message' => 'Verification Successful', 'status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Verification Failed', 'status' => false], 500);
        }
    }
}
