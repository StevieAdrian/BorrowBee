@extends('master.master')

@section('content')
   <div class="container mt-5 mb-0">
        <img 
            src="{{ asset('assets/borrowbee-logo-2.png') }}" 
            alt="BorrowBee Logo" 
            width="160"
            class="d-block mx-auto mb-4"
        >        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="text-center mb-4 fw-bold">
                    {{ __('about.title') }}
                </h2>

                <p class="text-justify">
                    {{ __('about.paragraph_1') }}
                </p>

                <p class="text-justify">
                    {{ __('about.paragraph_2') }}
                </p>
            </div>
        </div>
    </div>


@endsection
