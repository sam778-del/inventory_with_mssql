@extends('layouts.master')

@section('auth-content')
<div class="col-lg-12 d-flex justify-content-center align-items-center">
    <div class="card shadow-sm w-100 p-4 p-md-5" style="max-width: 32rem;">
      <!-- Form -->
      {!! Form::open(["route" => ["auth.login"], "class" => "row g-3", "method" => "POST", "id" => "my-form"]) !!}
         <div class="col-12 text-center mb-2">
               <h1>{{ __('Registrazione') }}</h1>
               <span class="text-muted">{{ __('Accesso gratuito alla nostra dashboard.') }}</span>
         </div>
         <div class="col-12">
               <div class="mb-2">
                  <label class="form-label">{{ __('Parola d\'ordine') }}</label>
                  <input type="password" name="password" class="form-control form-control-lg" placeholder="***************">
               </div>
         </div>
         <div class="col-12 text-center mt-4">
            <button class="btn btn-outline-secondary btn-lg btn-block btn-dark lift" type="submit">
                <span id="spinnerLoad" role="status" aria-hidden="true"></span>
                {{ __('Login') }}
            </button>
         </div>
      {!! Form::close() !!}
      <!-- End Form -->
    </div>
 </div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Auth\LoginRequest', '#my-form') !!}
@endpush