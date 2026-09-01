@extends('layouts.admin')

@section('title', 'Manage Permissions')

@section('content')

<div class="users-page">

    {{-- HEADER --}}
    <div class="users-page__head">

        <div>
            <h1>Manage Permissions</h1>

            <p>
                Configure permissions for {{ $role->roleName }}
            </p>
        </div>

        <div class="users-page__actions">

            <a href="{{ route('admin.users.permissions') }}"
               class="users-page__btn users-page__btn--outline">
                ← Back to Permissions
            </a>

        </div>

    </div>


    {{-- PERMISSIONS CARD --}}
    <div class="users-form-card">

        <div class="users-form-card__header">

            <h2>{{ $role->roleName }}</h2>

            <p>
                Permissions currently assigned to this role.
            </p>

        </div>


        @if($role->permissions->count())

            <div class="permissions-list">

                @foreach($role->permissions as $permission)

                    <div class="permission-role">

                        <div class="permission-role__info">

                            <div class="permission-role__icon">

                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M12 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3Z"
                                        stroke="currentColor"
                                        stroke-width="1.6"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                            </div>

                            <div>

                                <strong>
                                    {{ $permission->permissionName ?? 'Permission' }}
                                </strong>

                                @if(!empty($permission->description))

                                    <p>
                                        {{ $permission->description }}
                                    </p>

                                @else

                                    <p>
                                        Permission assigned to this role
                                    </p>

                                @endif

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="users-table__empty">

                No permissions are currently assigned to this role.

            </div>

        @endif

    </div>

</div>

@endsection