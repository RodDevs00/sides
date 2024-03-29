@extends('layouts.app')

@section('title', '| Doctors')
@section('sidebar_doctors', 'active')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Doctors</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Doctors</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card User-Activity">
                                        <div class="card-header">
                                            <h5>All Doctors</h5>
                                            @if ($user->type === 'admin')
                                                <div class="card-header-right">
                                                    <a href="{{ route('doctors.create') }}" class="btn btn-icon btn-outline-primary">
                                                        <i class="feather icon-user-plus"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-block text-center">
                                            <div class="row">
                                                @foreach ($doctors as $doctor)
                                                    <div class="col-md-4 col-xl-4">
                                                        <div class="card mb-4 hover-md" onclick="location.href='{{ route('doctors.show', $doctor->id) }}'">
                                                            <img class="card-img-top" src="/img/pictures/{{ $doctor->image }}" alt="doctor" style="height: 200px; object-fit: cover;">
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $doctor->name }}</h5>
                                                                <p class="card-text">{{ $doctor->doctor->specialty ?? 'General' }}</p>
                                                                <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-primary">Details</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
@endsection
