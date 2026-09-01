@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

<div class="users-page">

    {{-- HEADER --}}
    <div class="users-page__head">
        <div>
            <h1>Edit User</h1>

            <p>
                Update
                {{ $user->firstName }}
                {{ $user->lastName }}
            </p>
        </div>

        <div class="users-page__actions">

            <a href="{{ route('admin.users.show', $user->userID) }}"
               class="users-page__btn users-page__btn--outline">
                View User
            </a>

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
              action="{{ route('admin.users.update', $user->userID) }}">

            @csrf
            @method('PUT')

            @include('admin.users.partials.form', [
                'user' => $user
            ])

            <div class="users-form__actions">

                <a href="{{ route('admin.users.index') }}"
                   class="users-page__btn users-page__btn--outline">
                    Cancel
                </a>

                <button type="submit"
                        class="users-page__btn users-page__btn--solid">
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

@endsection