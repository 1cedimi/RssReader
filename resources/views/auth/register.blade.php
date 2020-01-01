@extends('layouts.app')

@section('content')

@push('head')
  <head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
  </head>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#email").on('input', function(e){
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var email = $("input[name='email']").val();
        var password = $("input[name='password']").val();

        $.ajax({
          url: "/ajaxValidator",
          type:'POST',
          data: {_token:_token, email:email, password:password},
          success: function(data) {
            if($.isEmptyObject(data.error)){
              $('#register').attr('disabled', false);
              $("#email-feedback").find("strong").html('');
              $("#email-feedback").find("strong").append(data.success);
            }
            else{ 
              $('#register').attr('disabled', true);        
              $("#email-feedback").find("strong").html('');
              $("#email-feedback").find("strong").append(data.error);
            }
          }
        });
      }); 
    });
  </script>
@endpush

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <span id="email-feedback" role="alert">
                                  <strong></strong>
                                </span>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="register" type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
