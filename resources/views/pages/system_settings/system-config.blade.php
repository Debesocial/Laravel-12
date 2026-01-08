<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4">
            <div class="col-12">
                <div class="card adminuiux-card">
                    <div class="card-body p-0">
                        {{-- header halaman action log --}}
                        <div class="p-4 pb-0">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    {{-- System Configuration Page --}}
                                    <h4 class="fw-bold mb-0">{{ __('System Configuration') }}</h4>
                                    <small class="text-muted">
                                        {{ __('Configure system settings such as application name, tagline, logo, and more to tailor the functionality and appearance of your application.') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('system-config.update') }}" method="POST"
                                enctype="multipart/form-data" autocomplete="off">

                                @csrf
                                @method('PUT')

                                {{-- anti autofill trap --}}
                                <input type="text" name="fakeuser" style="display:none">
                                <input type="password" name="fakepass" style="display:none">

                                {{-- Application Name --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ __('Application Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="app_name" class="form-control"
                                        value="{{ old('app_name') ?? get_setting('app_name', '') }}"
                                        placeholder="{{ __('Enter application name') }}" required minlength="3"
                                        maxlength="100"
                                        title="Application name is required and must be between 3 and 100 characters">
                                </div>

                                {{-- Tagline 1 --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ __('Tagline 1') }}</label>
                                    <input type="text" name="app_tagline" class="form-control"
                                        value="{{ old('app_tagline') ?? get_setting('app_tagline', '') }}"
                                        maxlength="150" placeholder="{{ __('Enter tagline') }}"
                                        title="Optional tagline, maximum 150 characters">
                                </div>

                                {{-- Tagline 2 --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ __('Tagline 2') }}</label>
                                    <input type="text" name="app_tagline1" class="form-control"
                                        value="{{ old('app_tagline1') ?? get_setting('app_tagline1', '') }}"
                                        maxlength="150" placeholder="{{ __('Enter tagline') }}"
                                        title="Optional tagline, maximum 150 characters">
                                </div>

                                {{-- Tagline 3 --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ __('Tagline 3') }}</label>
                                    <textarea name="app_tagline2" class="form-control" rows="5" maxlength="300"
                                        placeholder="{{ __('Enter tagline') }}"
                                        title="Optional description, maximum 300 characters">{{ old('app_tagline2') ?? get_setting('app_tagline2', '') }}</textarea>
                                </div>

                                {{-- Application Logo --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ __('Application Logo') }}</label>

                                    @php $logo = get_setting('app_logo'); @endphp
                                    @if($logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$logo) }}" class="img-thumbnail rounded"
                                            width="120">
                                    </div>
                                    @endif

                                    <input type="file" name="app_logo" class="form-control"
                                        accept="image/png,image/jpeg,image/webp"
                                        title="Upload an image file (PNG, JPG, WEBP)">
                                </div>

                                {{-- Favicon --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ __('Favicon') }}</label>

                                    @php $favicon = get_setting('app_favicon'); @endphp
                                    @if($favicon)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$favicon) }}" width="40" class="rounded">
                                    </div>
                                    @endif

                                    <input type="file" name="app_favicon" class="form-control"
                                        accept="image/png,image/x-icon,image/webp"
                                        title="Upload a favicon image (PNG, ICO, WEBP)">
                                </div>

                                {{-- Footer / Copyright --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ __('Footer / Copyright') }}</label>
                                    <input type="text" name="footer_text" class="form-control"
                                        value="{{ old('footer_text') ?? get_setting('footer_text', '') }}"
                                        maxlength="200" placeholder="© 2025 My Application. All rights reserved."
                                        title="Optional footer text, maximum 200 characters">
                                </div>

                                {{-- Submit --}}
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary px-4">
                                        {{ __('Save Configuration') }}
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>