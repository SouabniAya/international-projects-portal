@extends('layouts.admin')

@section('title', 'Edit Partner')

@section('content')

<div class="ptm-page">

    {{-- BACK --}}
    <a href="{{ route('admin.partner-management') }}" class="ptm-page__back">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to Partners
    </a>

    {{-- HEADER --}}
    <div class="ptm-page__head">
        <div>
            <h1>Edit Partner</h1>
            <p>Update the information for {{ $partner->partnerName }}.</p>
        </div>
    </div>

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="ptm-alert ptm-alert--error">
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.partner-management.update', $partner->partnerID) }}" enctype="multipart/form-data" class="ptm-form">
        @csrf
        @method('PUT')

        {{-- BASIC INFORMATION --}}
        <div class="ptm-form-card">
            <div class="ptm-form-card__header">
                <h2>Partner Information</h2>
                <p>Enter the main information about the institutional partner.</p>
            </div>

            <div class="ptm-form-grid">

                {{-- NAME --}}
                <div class="ptm-form-field">
                    <label for="partnerName">Partner Name <span>*</span></label>
                    <input type="text" id="partnerName" name="partnerName" value="{{ old('partnerName', $partner->partnerName) }}" placeholder="e.g. KU Leuven" required>
                    @error('partnerName')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                {{-- COUNTRY --}}
                <div class="ptm-form-field">
                    <label for="countryCode">Country / Region <span>*</span></label>
                    <select id="countryCode" name="countryCode" required>
                        <option value="">Select country</option>
                        @foreach($countries as $code => $name)
                            <option value="{{ $code }}" @selected(old('countryCode', $partner->countryCode) === $code)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('countryCode')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                {{-- CITY --}}
                <div class="ptm-form-field">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $partner->city) }}" placeholder="e.g. Leuven">
                    @error('city')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                {{-- TYPE --}}
                <div class="ptm-form-field">
                    <label for="establishmentType">Type of Institution</label>
                    <select id="establishmentType" name="establishmentType">
                        <option value="">Select institution type</option>
                        @foreach(['University', 'Research Institute', 'Higher Education Institution', 'Government Institution', 'Non-Governmental Organization', 'Company', 'Other'] as $type)
                            <option value="{{ $type }}" @selected(old('establishmentType', $partner->establishmentType) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('establishmentType')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                {{-- DOMAIN OF COOPERATION --}}
                <div class="ptm-form-field">
                    <label for="areaID">Domain of Cooperation</label>
                    <select id="areaID" name="areaID">
                        <option value="">Select cooperation domain</option>
                        @foreach($domains as $id => $name)
                            <option value="{{ $id }}" @selected(old('areaID', $currentAreaID) == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('areaID')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                {{-- PARTNERSHIP TYPE --}}
                <div class="ptm-form-field">
                    <label for="partnershipType">Partnership Type <span>*</span></label>
                    <select id="partnershipType" name="partnershipType" required>
                        <option value="">Select partnership type</option>
                        @foreach(['Bilateral Agreement', 'Framework Agreement', 'Memorandum of Understanding', 'Erasmus Agreement', 'Research Agreement', 'Other'] as $partnershipType)
                            <option value="{{ $partnershipType }}" @selected(old('partnershipType', $partner->partnershipType) === $partnershipType)>{{ $partnershipType }}</option>
                        @endforeach
                    </select>
                    @error('partnershipType')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                {{-- STATUS --}}
                <div class="ptm-form-field">
                    <label for="partnershipStatus">Partnership Status <span>*</span></label>
                    <select id="partnershipStatus" name="partnershipStatus" required>
                        @foreach(['pending' => 'Pending', 'active' => 'Active', 'expired' => 'Expired'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('partnershipStatus', $partner->partnershipStatus) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('partnershipStatus')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

            </div>
        </div>

        {{-- VISUAL INFORMATION --}}
        <div class="ptm-form-card">
            <div class="ptm-form-card__header">
                <h2>Partner Branding</h2>
                <p>Replace the partner logo used in the partner list.</p>
            </div>

            <div class="ptm-form-grid">
                @if($partner->logo)
                <div class="ptm-form-field">
                    <label>Current Logo</label>
                    <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->partnerName }}" style="max-width:120px; max-height:80px; object-fit:contain;">
                </div>
                @endif
                <div class="ptm-form-field">
                    <label for="logo">Replace Partner Logo</label>
                    <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/webp">
                    <small class="ptm-form-help">PNG, JPG or WEBP. Recommended square format. Leave empty to keep the current logo.</small>
                    @error('logo')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        {{-- ADDITIONAL INFORMATION --}}
        <div class="ptm-form-card">
            <div class="ptm-form-card__header">
                <h2>Additional Information</h2>
                <p>Optional contact or cooperation information.</p>
            </div>

            <div class="ptm-form-grid">
                <div class="ptm-form-field">
                    <label for="website">Website</label>
                    <input type="url" id="website" name="website" value="{{ old('website', $partner->website) }}" placeholder="https://www.example.com">
                    @error('website')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field ptm-form-field--full">
                    <label for="presentation">Presentation / Notes</label>
                    <textarea id="presentation" name="presentation" rows="5" placeholder="Additional information about the partnership...">{{ old('presentation', $presentation) }}</textarea>
                    @error('presentation')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        {{-- FORM ACTIONS --}}
        <div class="ptm-form-actions">
            <a href="{{ route('admin.partner-management') }}" class="ptm-page__btn ptm-page__btn--outline">Cancel</a>
            <button type="submit" class="ptm-page__btn">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M5 12l4 4L19 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Save Changes
            </button>
        </div>

    </form>

</div>

@endsection