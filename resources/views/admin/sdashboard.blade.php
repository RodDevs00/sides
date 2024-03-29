@extends('layouts.app')

@section('title', '| Dashboard')
@section('sidebar_dashboard', 'active')

@section('content')
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <!--[ card-dash ] start-->
                                <div class="col-md-4 col-xl-4">
                                    <div class="card shadow-sm">
                                        <div class="card-block customer-visitor">
                                            <h2 class="text-right mt-2 f-w-300">{{ $appointments->count() }}</h2>
                                            <span class="text-right d-block h5">Pending</span>
                                            <i class="material-icons text-c-blue">today</i>
                                        </div>
                                    </div>
                                </div>
                                <!--[ card-dash ] end-->
                                <!--[ card-dash ] start-->
                                <div class="col-md-4 col-xl-4">
                                    <div class="card shadow-sm">
                                        <div class="card-block customer-visitor">
                                            <h2 class="text-right mt-2 f-w-300">{{ $confirmed }}</h2>
                                            <span class="text-right d-block h5">Confirmed</span>
                                            <i class="material-icons text-c-blue">event_available</i>
                                        </div>
                                    </div>
                                </div>
                                <!--[ card-dash ] end-->
                                <!--[ card-dash ] start-->
                                <div class="col-md-4 col-xl-4">
                                    <div class="card shadow-sm">
                                        <div class="card-block customer-visitor">
                                            <h2 class="text-right mt-2 f-w-300">{{ $ended }}</h2>
                                            <span class="text-right d-block h5">Ended</span>
                                            <i class="material-icons text-c-blue">schedule</i>
                                        </div>
                                    </div>
                                </div>
                                <!--[ card-dash ] end-->
                                <div class="col-sm-12">
                                    <div class="card User-Activity">
                                        <div class="card-header">
                                            <h5>Pending Appointments</h5>
                                        </div>
                                        <div class="card-block text-center">
                                        <table id="tb-appointments" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Patients</th>
                                                        <th>Doctor</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Receipt</th>
                                                        <th>Confirm</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($appointments as $appointment)
                                                        <tr>
                                                            <td>{{ $appointment->patient->name }}</td>
                                                            <td>{{ $appointment->doctor->name }}</td>
                                                            <td>{{ $appointment->start_date }}</td>
                                                            <td>{{ $appointment->end_date }}</td>
                                                            <td>
                                                                @if ($appointment->receipt_path)
                                                                    <a href="{{ asset('storage/' . $appointment->receipt_path) }}" target="_blank">View Receipt</a>
                                                                @else
                                                                    No Receipt
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('appointments.confirm', $appointment->id) }}" class="btn btn-icon btn-outline-success">
                                                                    <i class="feather icon-check-circle"></i>
                                                                </a>
                                                                <a href="{{ route('appointments.cancel', $appointment->id) }}" class="btn btn-icon btn-outline-danger">
                                                                    <i class="feather icon-slash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
    <!-- [ Main Content ] end -->

    <script src="{{ asset('plugins/datatables/datatables.min.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('#tb-appointments').DataTable();
        });
    </script>
@endsection
