<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        Log::info('Event store request received.', $request->except(['background_file']));

        try {
            // Initial Validation (Basic Fields)
            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:Seminar,Workshop,Conference,Study Day',
                'speaker_name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'total_seats' => 'required|integer|min:1',
                'date_time' => 'required|date|after:now',
                'has_certificate' => 'nullable',
                'background_type' => 'required|in:image,video',
            ];

            // Conditional File Validation
            if ($request->background_type === 'image') {
                $rules['background_file'] = 'required|file|image|mimes:jpg,jpeg,png,webp,avif|max:2048'; // 2MB for images
            } else {
                $rules['background_file'] = 'required|file|mimes:mp4,mov,avi,wmv|max:102400'; // 100MB for videos
            }

            $validated = $request->validate($rules);

            // Double check file integrity / usability
            if ($request->hasFile('background_file')) {
                $file = $request->file('background_file');
                
                if (!$file->isValid()) {
                    throw new \Exception('The uploaded file is corrupted or could not be processed.');
                }

                if ($file->getSize() <= 0) {
                    throw new \Exception('The uploaded file is empty and unusable.');
                }

                Log::info('Uploading background file...', ['name' => $file->getClientOriginalName()]);
                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '', $file->getClientOriginalName());
                $path = $file->storeAs('events', $filename, 'public');
                $validated['background_path'] = $path;
                Log::info('Background file uploaded successfully.', ['path' => $path]);
            }

            $validated['available_seats'] = $validated['total_seats'];
            $validated['has_certificate'] = $request->has('has_certificate');

            $event = Event::create($validated);
            Log::info('Event created successfully.', ['id' => $event->id]);

            return redirect()->route('admin.events.index')->with('success', "Event '{$event->title}' created successfully.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Event validation failed.', ['errors' => $e->errors()]);
            throw $e; // Caught by the global handler in app.blade.php
        } catch (\Exception $e) {
            Log::error('Event creation failed with error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Critical Error: ' . $e->getMessage());
        }
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        Log::info('Event update request received.', ['id' => $event->id] + $request->except(['background_file']));

        try {
            // Initial Validation (Basic Fields)
            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|in:Seminar,Workshop,Conference,Study Day',
                'speaker_name' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'total_seats' => 'required|integer|min:1',
                'date_time' => 'required|date',
                'has_certificate' => 'nullable',
                'background_type' => 'required|in:image,video',
            ];

            // Conditional File Validation (Optional on update)
            if ($request->background_type === 'image') {
                $rules['background_file'] = 'nullable|file|image|mimes:jpg,jpeg,png,webp,avif|max:2048';
            } else {
                $rules['background_file'] = 'nullable|file|mimes:mp4,mov,avi,wmv|max:102400';
            }

            $validated = $request->validate($rules);

            $validated['has_certificate'] = $request->has('has_certificate');
            
            // Update available seats if total seats changed
            $diff = $validated['total_seats'] - $event->total_seats;
            $validated['available_seats'] = $event->available_seats + $diff;

            // Integrity check if new file provided
            if ($request->hasFile('background_file')) {
                $file = $request->file('background_file');

                if (!$file->isValid()) {
                    throw new \Exception('The new background file is corrupted or could not be processed.');
                }

                Log::info('Uploading new background file...', ['name' => $file->getClientOriginalName()]);
                
                // Delete old file
                if ($event->background_path) {
                    Storage::disk('public')->delete($event->background_path);
                }

                $filename = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '', $file->getClientOriginalName());
                $path = $file->storeAs('events', $filename, 'public');
                $validated['background_path'] = $path;
                Log::info('New background file uploaded successfully.', ['path' => $path]);
            }

            $event->update($validated);
            Log::info('Event updated successfully.', ['id' => $event->id]);

            return redirect()->route('admin.events.index')->with('success', "Event '{$event->title}' updated successfully.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Event update validation failed.', ['id' => $event->id, 'errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Event update failed for ID ' . $event->id . ' with error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Critical Error: ' . $e->getMessage());
        }
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
