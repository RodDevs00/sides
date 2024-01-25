@extends('layouts.app')

@section('title', '| Services')
@section('sidebar_services', 'active')

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
                                        <h5 class="m-b-10">Services</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Services</a></li>
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
                                        <h5>All Services</h5>
                                        @if($user->type === 'admin')
                                            <div class="card-header-right">
                                                <a href="{{ route('service.create') }}" class="btn btn-icon btn-outline-primary"><i class="feather icon-user-plus"></i></a>
                                                
                                            </div>
                                        @endif
                                    </div>
                                        <div class="card-block text-center">
                                            <table id="tb-patients" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Price</th>
                                                        @if($user->type === 'admin')  <th>Action</th> @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($services as $service)
                                                        <tr>
                                                            
                                                            <td>{{ $service->name }}</td>
                                                            <td>{{ $service->description }}</td>
                                                            <td>₱{{ $service->price }}</td>
                                                            @if($user->type === 'admin')
                                                            <td>
                                                                <a href="{{ route('service.show', $service->id) }}" class="btn btn-icon btn-outline-primary">
                                                                    <i class="feather icon-play"></i>
                                                                </a>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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

    <script src="{{ asset('plugins/datatables/datatables.min.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('#tb-patients').DataTable();
        } );
    </script>
@endsection
