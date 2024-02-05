@extends('layouts.app')

@section('title', '| Appointment')
@section('sidebar_appointments', 'active')

@section('content')
<style>
    #jitsi-container {
        width: 100%;
        height: 500px; /* Adjust the height as needed */
    }

    .receipt-container {
        max-width: 300px; /* Define the maximum width for the receipt image container */
        margin: 0 auto; /* Center the container */
    }

    .receipt-img {
        max-width: 100%; /* Make the receipt image responsive within the container */
        height: auto; /* Maintain the aspect ratio */
    }

    /* Custom styles for the form */
    .receipt-upload-form {
        margin-top: 20px;
    }

    .receipt-upload-btn {
        margin-top: 10px;
    }
</style>

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="m-b-10">Appointment</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Appointment</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card User-Activity">
                                    <div class="card-header">
                                        <h5>
                                            {{
                                                $appointment->start_date->format('d/m H:i') .
                                                ' - ' .
                                                ($user->type === 'patient'
                                                    ? $appointment->doctor->name 
                                                    : $appointment->patient->name) 
                                            }}
                                        </h5>
                                        <script>
                                            // Pass the roomName from PHP to JavaScript
                                            const room = @json($appointment->roomName);
                                        </script>
                                    </div>
                                    <div class="card-block text-center">
                                        <div class="text-center m-b-30">
                                            <h5 class="mt-3">
                                                {{
                                                    $user->type === 'patient'
                                                        ? $appointment->doctor->name
                                                        : $appointment->patient->name
                                                }}
                                            </h5>
                                            <h3>Room Name: {{ $appointment->roomName}}</h3>
                                            <span class="d-block mb-4">{{ $appointment->present()->status }}</span>
                                            <img
                                                class="img-fluid rounded-circle"
                                                style="width: 200px; max-width: 100%;"
                                                src="{{ asset('img/pictures/' . ($user->type === 'patient' ? $appointment->doctor->image : $appointment->patient->image)) }}"
                                                alt="doctor"
                                            >
                                        </div>
                                        @if ($appointment->status === 'confirmed')
                                            <div id="jitsi-container"></div>
                                        @endif

                                        @if ($user->type === 'patient')
                                        @if ($appointment->status === 'pending')
                                        <!-- Receipt display -->
                                        @if ($appointment->receipt_path)
                                            <div class="mt-3 receipt-container">
                                                <h5>Proof of payment:</h5>
                                                <img src="{{ asset('storage/' . $appointment->receipt_path) }}" alt="Receipt" class="img-fluid receipt-img">
                                            </div>
                                        @endif
                                    
                                        <!-- Receipt upload form -->
                                    <form action="{{ route('appointments.uploadReceipt', $appointment->id) }}" method="post" enctype="multipart/form-data" class="receipt-upload-form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="receipt">Upload Receipt:</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="receipt" class="custom-file-input" id="receipt" required>
                                                    <label class="custom-file-label" for="receipt">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary receipt-upload-btn">Submit Receipt</button>
                                    </form>

                                        @endif
                                    @endif 
                                        <!-- Additional appointment details -->
                                        <div class="row m-t-30">
                                            <div class="col-md-6 col-lg-6">
                                                <h5>{{ $appointment->start_date->format('d/m H:i') }}</h5>
                                                <span class="text-muted">Start Date</span>
                                            </div>
                                            <div class="col-md-6 col-lg-6">
                                                <h5>{{ $appointment->end_date->format('d/m H:i') }}</h5>
                                                <span class="text-muted">End Date</span>
                                            </div>
                                        </div>
                                        <!-- Cancel appointment button -->
                                        @if ($appointment->status === 'pending')
                                            <div class="designer m-t-30">
                                                <a
                                                    href="{{ route('appointments.cancel', $appointment->id) }}"
                                                    class="btn btn-danger shadow-2 text-uppercase btn-block"
                                                >
                                                    Cancel
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const domain = 'meet.jit.si';
        const options = {
            roomName: room,
            width: '100%',
            height: '100%',
            parentNode: document.querySelector('#jitsi-container'),
        };
        const api = new JitsiMeetExternalAPI(domain, options);
    });
</script>

@endsection
