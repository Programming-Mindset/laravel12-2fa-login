@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Otp Page') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{ route('verify.otp') }}" method="POST">
                            @csrf
                            <label for="otp">Enter OTP:</label>
                            <input type="text" class="form-control" name="otp" placeholder="Enter 6 digits otp" minlength="6" maxlength="6" required>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
