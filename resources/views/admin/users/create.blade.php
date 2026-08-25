@extends('layouts.admin')

@section('title', 'Create User')

@section('content')

<div class="users-page">

    {{-- HEADER --}}
    <div class="users-page__head">
        <div>
            <h1>Create User</h1>
            <p>Create a new user account</p>
        </div>

        <div class="users-page__actions">
            <a href="{{ route('admin.users.index') }}"
               class="users-page__btn users-page__btn--outline">
                ← Back to Users
            </a>
        </div>
    </div>

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="users-alert users-alert--error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <div class="users-form-card">

        <form method="POST"
              action="{{ route('admin.users.store') }}">

            @csrf

            @include('admin.users.partials.form')

            <div class="users-form__actions">

                <a href="{{ route('admin.users.index') }}"
                   class="users-page__btn users-page__btn--outline">
                    Cancel
                </a>

                <button type="submit"
                        class="users-page__btn users-page__btn--solid">
                    Create User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection