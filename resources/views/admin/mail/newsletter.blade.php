<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mail from {{ env('APP_NAME') }}</title>
</head>
<body>
    <p>Hello ,</p>

    <p>Thank You For Join Us!</p>

    <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $newsletter->newsletter_subject }}</h4>
            </div>
            <div class="card-body">
                {!! $newsletter->newsletter_body !!}
            </div>
        </div>
    </div>


    <p>We look forward to communicating more with you. For more information visit our Site.</p>

    <a href="{{ env('APP_URL') }}" target="_blank">Visit Website</a>

    <p>© {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.</p>
</body>
</html>
