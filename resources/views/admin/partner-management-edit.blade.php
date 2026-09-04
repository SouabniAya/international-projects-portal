@extends('layouts.admin')

@section('title', 'Edit Partner')

@section('content')

<div class="ptm-page">

    <a href="{{ route('admin.partner-management') }}" class="ptm-page__back">
        <svg viewBox="0 0 24 24" fill="none">
            <path d="M15 6l-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('Back to Partners') }}
    </a>

    <div class="ptm-page__head">
        <div>
            <h1>{{ __('Edit Partner') }}</h1>
            <p>{{ __('Update the information for :name.', ['name' => $partner->partnerName]) }}</p>
        </div>
    </div>

    @if($errors->any())
        <div class="ptm-alert ptm-alert--error">
            <strong>{{ __('Please correct the following errors:') }}</strong>
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

        <div class="ptm-form-card">
            <div class="ptm-form-card__header">
                <h2>{{ __('Partner Information') }}</h2>
                <p>{{ __('Enter the main information about the institutional partner.') }}</p>
            </div>

            <div class="ptm-form-grid">

                <div class="ptm-form-field">
                    <label for="partnerName">{{ __('Partner Name') }} <span>*</span></label>
                    <input type="text" id="partnerName" name="partnerName" value="{{ old('partnerName', $partner->partnerName) }}" placeholder="{{ __('e.g. KU Leuven') }}" required>
                    @error('partnerName')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field">
                    <label for="countryCode">{{ __('Country / Region') }} <span>*</span></label>
                    <select id="countryCode" name="countryCode" required>
                        <option value="">{{ __('Select country') }}</option>
                        @foreach($countries as $code => $name)
                            <option value="{{ $code }}" @selected(old('countryCode', $partner->countryCode) === $code)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('countryCode')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field">
                    <label for="city">{{ __('City') }}</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $partner->city) }}" placeholder="{{ __('e.g. Leuven') }}">
                    @error('city')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field">
                    <label for="establishmentType">{{ __('Type of Institution') }}</label>
                    <select id="establishmentType" name="establishmentType">
                        <option value="">{{ __('Select institution type') }}</option>
                        @foreach(['University', 'Research Institute', 'Higher Education Institution', 'Government Institution', 'Non-Governmental Organization', 'Company', 'Other'] as $type)
                            <option value="{{ $type }}" @selected(old('establishmentType', $partner->establishmentType) === $type)>{{ __($type) }}</option>
                        @endforeach
                    </select>
                    @error('establishmentType')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field">
                    <label for="areaID">{{ __('Domain of Cooperation') }}</label>
                    <select id="areaID" name="areaID">
                        <option value="">{{ __('Select cooperation domain') }}</option>
                        @foreach($domains as $id => $name)
                            <option value="{{ $id }}" @selected(old('areaID', $currentAreaID) == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('areaID')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field">
                    <label for="partnershipType">{{ __('Partnership Type') }} <span>*</span></label>
                    <select id="partnershipType" name="partnershipType" required>
                        <option value="">{{ __('Select partnership type') }}</option>
                        @foreach(['Bilateral Agreement', 'Framework Agreement', 'Memorandum of Understanding', 'Erasmus Agreement', 'Research Agreement', 'Other'] as $partnershipType)
                            <option value="{{ $partnershipType }}" @selected(old('partnershipType', $partner->partnershipType) === $partnershipType)>{{ __($partnershipType) }}</option>
                        @endforeach
                    </select>
                    @error('partnershipType')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field">
                    <label for="partnershipStatus">{{ __('Partnership Status') }} <span>*</span></label>
                    <select id="partnershipStatus" name="partnershipStatus" required>
                        @foreach(['pending' => 'Pending', 'active' => 'Active', 'expired' => 'Expired'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('partnershipStatus', $partner->partnershipStatus) === $value)>{{ __($label) }}</option>
                        @endforeach
                    </select>
                    @error('partnershipStatus')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

            </div>
        </div>

        <div class="ptm-form-card">
            <div class="ptm-form-card__header">
                <h2>{{ __('Partner Branding') }}</h2>
                <p>{{ __('Replace the partner logo used in the partner list.') }}</p>
            </div>

            <div class="ptm-form-grid">
                @if($partner->logo)
                <div class="ptm-form-field">
                    <label>{{ __('Current Logo') }}</label>
                    <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->partnerName }}" style="max-width:120px; max-height:80px; object-fit:contain;">
                </div>
                @endif
                <div class="ptm-form-field">
                    <label for="logo">{{ __('Replace Partner Logo') }}</label>
                    <input type="file" id="logo" name="logo" accept="image/png,image/jpeg,image/webp">
                    <small class="ptm-form-help">{{ __('PNG, JPG or WEBP. Recommended square format. Leave empty to keep the current logo.') }}</small>
                    @error('logo')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="ptm-form-card">
            <div class="ptm-form-card__header">
                <h2>{{ __('Additional Information') }}</h2>
                <p>{{ __('Optional contact or cooperation information.') }}</p>
            </div>

            <div class="ptm-form-grid">
                <div class="ptm-form-field">
                    <label for="website">{{ __('Website') }}</label>
                    <input type="url" id="website" name="website" value="{{ old('website', $partner->website) }}" placeholder="https://www.example.com">
                    @error('website')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>

                <div class="ptm-form-field ptm-form-field--full">
                    <label for="presentation">{{ __('Presentation / Notes') }}</label>
                    <textarea id="presentation" name="presentation" rows="5" placeholder="{{ __('Additional information about the partnership...') }}">{{ old('presentation', $presentation) }}</textarea>
                    @error('presentation')<small class="ptm-form-error">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="ptm-form-actions">
            <a href="{{ route('admin.partner-management') }}" class="ptm-page__btn ptm-page__btn--outline">{{ __('Cancel') }}</a>
            <button type="submit" class="ptm-page__btn">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M5 12l4 4L19 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ __('Save Changes') }}
            </button>
        </div>

    </form>

</div>

@endsection