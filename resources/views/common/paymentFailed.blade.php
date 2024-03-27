<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ env('APP_DESCRIPTION') }}" name="description" />
    <meta content="KoderiaNg" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Local CSS files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header text-center ">Payment Failed</div>

                    <div class="card-body">
                        <p class="text-center">We're sorry, but your transaction failed to process. Please try again or
                            contact support.</p>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('bookNow') }}" class="btn btn-primary">Return to BookNow</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Local JS files -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
</body>

</html>
