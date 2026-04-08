@extends('layouts.backendFuncionario')

@section('content')
    <div class="content">
        <div class="row items-push">
            <div class="bg-image" style="background-image: url({{ asset('images/municipalidad.jpg') }});">
          <div class="bg-black-25">
            <div class="content content-full">
              <div class="py-5 text-center">
                <a class="img-link" href="be_pages_generic_profile.html">
                  <img class="img-avatar img-avatar96 img-avatar-thumb" src="assets/media/avatars/avatar10.jpg" alt="">
                </a>
                <h1 class="fw-bold my-2 text-white">{{ $user->name }}</h1>
                <h2 class="h4 fw-bold text-white-75">
                  {{ $user->email }}
                </h2>
                <button type="button" class="btn btn-primary m-1">
                  <i class="fa fa-fw fa-user-plus opacity-50 me-1"></i> Add
                </button>
              </div>
            </div>
          </div>
        </div>

        </div>
    </div>
@endsection









