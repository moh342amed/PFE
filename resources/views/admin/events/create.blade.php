<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm me-3 border-0 rounded-circle">
                <i class="bi bi-arrow-left fs-5"></i>
            </a>
            <span>{{ __('Add New Event') }}</span>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-brand-green py-3">
                    <h5 class="fw-bold mb-0 text-white"><i class="bi bi-plus-circle me-2"></i> Event Details</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">Event Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control rounded-3 py-2 @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="e.g. Annual AI Conference 2026">
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Full Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" rows="5" class="form-control rounded-3 @error('description') is-invalid @enderror" required placeholder="Provide a detailed overview of the event...">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-12">
                                <label for="background_file" class="form-label fw-bold d-flex justify-content-between">
                                    <span>Background File <span class="text-danger">*</span></span>
                                    <span id="type_badge" class="badge bg-secondary rounded-pill d-none">Detected: <span id="type_text">---</span></span>
                                </label>
                                <input type="hidden" name="background_type" id="background_type" value="{{ old('background_type', 'image') }}">
                                <input type="file" name="background_file" id="background_file" class="form-control rounded-3 py-2 @error('background_file') is-invalid @enderror" accept="image/*,video/mp4,video/quicktime" required>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">Recommended: 1920x1080 (Images) | .mp4 (Videos)</small>
                                    <small class="text-muted">Max size: 2MB (Image) / 100MB (Video)</small>
                                </div>
                                @error('background_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="type" class="form-label fw-bold">Event Type <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select rounded-3 py-2 @error('type') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select type</option>
                                    <option value="Seminar" {{ old('type') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="Workshop" {{ old('type') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                    <option value="Conference" {{ old('type') == 'Conference' ? 'selected' : '' }}>Conference</option>
                                    <option value="Study Day" {{ old('type') == 'Study Day' ? 'selected' : '' }}>Study Day</option>
                                </select>
                                @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="speaker_name" class="form-label fw-bold">Lecturer / Speaker <span class="text-danger">*</span></label>
                                <input type="text" name="speaker_name" id="speaker_name" class="form-control rounded-3 py-2 @error('speaker_name') is-invalid @enderror" value="{{ old('speaker_name') }}" required placeholder="Dr. Ahmed Mansour">
                                @error('speaker_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-bold">Hall / Venue Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" id="location" class="form-control rounded-3 py-2 @error('location') is-invalid @enderror" value="{{ old('location') }}" required placeholder="e.g. Conference Hall A">
                                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="date_time" class="form-label fw-bold">Event Date & Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="date_time" id="date_time" class="form-control rounded-3 py-2 @error('date_time') is-invalid @enderror" value="{{ old('date_time') }}" required>
                                @error('date_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <label for="total_seats" class="form-label fw-bold">Total Seat Capacity <span class="text-danger">*</span></label>
                                <input type="number" name="total_seats" id="total_seats" class="form-control rounded-3 py-2 @error('total_seats') is-invalid @enderror" value="{{ old('total_seats') }}" required placeholder="e.g. 100">
                                @error('total_seats') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted">Will be auto-set as "available seats".</small>
                            </div>
                            <div class="col-md-6 d-flex align-items-center mb-0 mt-5">
                                <div class="form-check form-switch p-3 bg-light rounded-3 shadow-sm border col-12 d-flex justify-content-between">
                                    <label class="form-check-label fw-bold ms-1" for="has_certificate">Issue Certificates?</label>
                                    <input name="has_certificate" class="form-check-input ms-0 mt-0" type="checkbox" id="has_certificate" checked>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-univ btn-lg py-3 rounded-pill fw-bold shadow">
                                <i class="bi bi-save me-2"></i> Create Event
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-light btn-lg py-3 rounded-pill fw-semibold border-0">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backgroundFileInput = document.getElementById('background_file');
            const backgroundTypeInput = document.getElementById('background_type');
            const typeBadge = document.getElementById('type_badge');
            const typeText = document.getElementById('type_text');

            backgroundFileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const mimeType = file.type;
                    let detectedType = '';

                    if (mimeType.startsWith('image/')) {
                        detectedType = 'image';
                        typeBadge.classList.remove('bg-info', 'bg-warning', 'd-none');
                        typeBadge.classList.add('bg-success');
                        typeText.innerText = 'Image';
                    } else if (mimeType.startsWith('video/')) {
                        detectedType = 'video';
                        typeBadge.classList.remove('bg-success', 'bg-warning', 'd-none');
                        typeBadge.classList.add('bg-info');
                        typeText.innerText = 'Video';
                    } else {
                        // Unsupported
                        Swal.fire({
                            icon: 'error',
                            title: 'Unsupported File',
                            text: 'Please select a valid image or video file.',
                            confirmButtonColor: '#2e7d32'
                        });
                        backgroundFileInput.value = '';
                        typeBadge.classList.add('d-none');
                        return;
                    }

                    // File Size Check (Prevent silent failure)
                    const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
                    if (file.size > 8 * 1024 * 1024) { // 8MB limit
                        Swal.fire({
                            icon: 'warning',
                            title: 'File Too Large',
                            html: `Your file is <b>${fileSizeMB}MB</b>. Your server is currently limited to <b>8MB</b>.<br><br>Please choose a smaller file or increase 'post_max_size' in your php.ini.`,
                            confirmButtonColor: '#2e7d32'
                        });
                        backgroundFileInput.value = '';
                        typeBadge.classList.add('d-none');
                        return;
                    }

                    backgroundTypeInput.value = detectedType;
                    console.log('✅ Auto-detected type:', detectedType);
                } else {
                    typeBadge.classList.add('d-none');
                }
            });

            // Standard Form monitoring
            const form = document.querySelector('form');
            form.addEventListener('submit', function() {
                console.log('🚀 Submit clicked. Validated for auto-type:', backgroundTypeInput.value);
            });
        });
    </script>
</x-app-layout>
