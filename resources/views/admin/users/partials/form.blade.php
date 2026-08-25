<div class="users-form">

    {{-- FIRST NAME --}}
    <div class="users-form__group">
        <label for="firstName">First Name</label>

        <input
            type="text"
            id="firstName"
            name="firstName"
            value="{{ old('firstName', $user->firstName ?? '') }}"
            placeholder="Enter first name"
            required
        >

        @error('firstName')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- LAST NAME --}}
    <div class="users-form__group">
        <label for="lastName">Last Name</label>

        <input
            type="text"
            id="lastName"
            name="lastName"
            value="{{ old('lastName', $user->lastName ?? '') }}"
            placeholder="Enter last name"
            required
        >

        @error('lastName')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- USERNAME --}}
    <div class="users-form__group">
        <label for="userName">Username</label>

        <input
            type="text"
            id="userName"
            name="userName"
            value="{{ old('userName', $user->userName ?? '') }}"
            placeholder="Enter username"
            required
        >

        @error('userName')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- EMAIL --}}
    <div class="users-form__group">
        <label for="email">Email Address</label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', $user->email ?? '') }}"
            placeholder="Enter email address"
            required
        >

        @error('email')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- PHONE --}}
    <div class="users-form__group">
        <label for="phoneNumber">Phone Number</label>

        <input
            type="text"
            id="phoneNumber"
            name="phoneNumber"
            value="{{ old('phoneNumber', $user->phoneNumber ?? '') }}"
            placeholder="Enter phone number"
        >

        @error('phoneNumber')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- PASSWORD --}}
    <div class="users-form__group">
        <label for="password">
            Password

            @if(isset($user))
                <span class="users-form__optional">
                    Leave blank to keep current password
                </span>
            @endif
        </label>

        <input
            type="password"
            id="password"
            name="password"
            placeholder="{{ isset($user) ? 'Leave blank to keep current password' : 'Enter password' }}"
            {{ isset($user) ? '' : 'required' }}
        >

        @error('password')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- PASSWORD CONFIRMATION --}}
    <div class="users-form__group">
        <label for="password_confirmation">
            Confirm Password
        </label>

        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            placeholder="Confirm password"
            {{ isset($user) ? '' : 'required' }}
        >

        @error('password_confirmation')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- ROLE --}}
    <div class="users-form__group">
        <label for="roleID">Role</label>

        <select
            id="roleID"
            name="roleID"
        >
            <option value="">Select a role</option>

            @if(isset($roles))

                @foreach($roles as $role)

                    <option
                        value="{{ $role->roleID }}"
                        {{ (string) old('roleID', $selectedRole ?? '') === (string) $role->roleID ? 'selected' : '' }}
                    >
                        {{ $role->roleName }}
                    </option>

                @endforeach

            @endif
        </select>

        @error('roleID')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- ACCOUNT STATUS --}}
    <div class="users-form__group">
        <label for="accountStatus">Account Status</label>

        <select
            id="accountStatus"
            name="accountStatus"
        >
            <option
                value="active"
                {{ old('accountStatus', $user->accountStatus ?? 'active') === 'active' ? 'selected' : '' }}
            >
                Active
            </option>

            <option
                value="disabled"
                {{ old('accountStatus', $user->accountStatus ?? '') === 'disabled' ? 'selected' : '' }}
            >
                Disabled
            </option>
        </select>

        @error('accountStatus')
            <span class="users-form__error">{{ $message }}</span>
        @enderror
    </div>


    {{-- TWO FACTOR AUTHENTICATION --}}
    <div class="users-form__group users-form__group--checkbox">

        <label class="users-form__checkbox">

            <input
                type="checkbox"
                name="twoFactorEnabled"
                value="1"
                {{ old('twoFactorEnabled', $user->twoFactorEnabled ?? false) ? 'checked' : '' }}
            >

            <span>
                Enable Two-Factor Authentication
            </span>

        </label>

        @error('twoFactorEnabled')
            <span class="users-form__error">{{ $message }}</span>
        @enderror

    </div>

</div>