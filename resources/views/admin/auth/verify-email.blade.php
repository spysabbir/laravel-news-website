

        <span>
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.
        </span>

        @if (session('status') == 'verification-link-sent')
            <span>
                A new verification link has been sent to the email address you provided during registration.
            </span>
        @endif

        <div>
            <form method="POST" action="{{ route('admin.verification.send') }}">
                @csrf
                    <button type="submit">Resend Verification Email'</button>
            </form>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" >Log Out</button>
            </form>
        </div>
