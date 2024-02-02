@extends('layouts.app')

@section('title', '| Appointment')
@section('sidebar_appointments', 'active')


@section('content')
<style>
    #jitsi-container {
    width: 100%;
    height: 500px; /* Adjust the height as needed */
}

</style>

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
                    <!-- [ breadcrumb ] end -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
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
                                            const room  = @json($appointment->roomName);
                                           
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
                                                <h3>Room Name :{{ $appointment->roomName}}</h3>
                                                <span class="d-block mb-4">{{ $appointment->present()->status }}</span>

                                                
                                                <img
                                                    class="img-fluid rounded-circle"
                                                    style="width: 200px;max-width:100%;"
                                                    src="{{ asset('img/pictures/' . ($user->type === 'patient' ? $appointment->doctor->image : $appointment->patient->image)) }}"
                                                    alt="doctor"
                                                >
                                            </div>
                                            @if ($appointment->status === 'confirmed')
                                            <div id="jitsi-container"></div>
                                            @endif
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
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
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
