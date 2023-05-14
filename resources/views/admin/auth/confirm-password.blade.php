

        <span>
            This is a secure area of the application. Please confirm your password before continuing.
        </span>

        <form method="POST" action="{{ route('admin.password.confirm') }}">
            @csrf

            <!-- Password -->
           <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" />
            @error('password')
            <span>{{ $message }}</span>
            @enderror
        </div>

            <div>
                <button type="submit">
                    Confirm
                </button>
            </div>
        </form>
