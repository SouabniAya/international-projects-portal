@extends('layouts.admin')

@section('title', 'User Details')

@section('content')

<div class="users-page">

    <div class="users-page__head">

        <div>
            <h1>User Details</h1>

            <p>
                View user account information
            </p>
        </div>

        <div class="users-page__actions">

            <a href="{{ route('admin.users.index') }}"
               class="users-page__btn users-page__btn--outline">
                Back to Users
            </a>

            <a href="{{ route('admin.users.edit', $user->userID) }}"
               class="users-page__btn users-page__btn--solid">
                Edit User
            </a>

        </div>

    </div>


    <div class="users-form-card">

        <div class="users-profile">

            <div class="users-profile__avatar">

                {{ strtoupper(substr($user->firstName ?? 'U', 0, 1)) }}

            </div>


            <h2>
                {{ $user->firstName }}
                {{ $user->lastName }}
            </h2>


            <p>
                {{ $user->email }}
            </p>


            @if($user->accountStatus === 'active')

                <span class="users-table__status">
                    Active
                </span>

            @else

                <span class="users-table__status users-table__status--inactive">
                    Inactive
                </span>

            @endif

        </div>


        <div class="users-details">

            <div>
                <strong>User ID</strong>
                <span>{{ $user->userID }}</span>
            </div>

            <div>
                <strong>Username</strong>
                <span>{{ $user->userName }}</span>
            </div>

            <div>
                <strong>First Name</strong>
                <span>{{ $user->firstName }}</span>
            </div>

            <div>
                <strong>Last Name</strong>
                <span>{{ $user->lastName }}</span>
            </div>

            <div>
                <strong>Email</strong>
                <span>{{ $user->email }}</span>
            </div>

            <div>
                <strong>Phone</strong>
                <span>{{ $user->phoneNumber ?: 'Not provided' }}</span>
            </div>

            <div>
                <strong>Account Status</strong>
                <span>{{ ucfirst($user->accountStatus) }}</span>
            </div>

            <div>
                <strong>Two Factor Authentication</strong>

                <span>
                    {{ $user->twoFactorEnabled ? 'Enabled' : 'Disabled' }}
                </span>
            </div>

        </div>

    </div>

</div>

@endsection