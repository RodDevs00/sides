@extends('layouts.app')

@section('title', '| Secretaries')
@section('sidebar_secretaries', 'active')

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
                                        <h5 class="m-b-10">Secretary</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('admins.index') }}">Secretaries</a></li>
                                        <li class="breadcrumb-item"><a href="javascript:">Secretary</a></li>
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
                                            <h5>New Secretary</h5>
                                        </div>
                                        <div class="card-block pb-0">
                                            <form class="link-form" action='{{ route('secretaries.store') }}' method='POST' enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="bg-c-blue config-avatar shadow-3">
                                                    <img src='{{ asset('img/pictures/default.png') }}'>
                                                </div>
                                                <div class="controls" style="display: none;">
                                                    <input type="file" name="image"/>
                                                </div>
                                                <input id='admin-name' class='form-control' type='text' name='name' placeholder="Name" required>
                                                <input id='admin-email' class='form-control mt-3' type='text' name='email' placeholder="Email" required>
                                                <input id='admin-password' class='form-control mt-3' type='password' name='password' placeholder="Password" required>
                                                <!-- Select field for doctors -->
                                                <div class="form-group mt-3">
                                                    <label for="doctor_id">Select Doctor</label>
                                                    <select class="form-control" id="doctor_id" name="doctor_id">
                                                    <option value="" selected disabled>Select Doctor</option>
                                                        @foreach($doctors as $doctor)
                                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <br>
                                                <button class='btn btn-outline-primary' type='submit'>Submit</button>
                                                <br>
                                            </form>
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
    <script>
        $(".config-avatar").click(function(event) {
            var previewImg = $(this).children("img");

            $(this)
                .siblings()
                .children("input")
                .trigger("click");

            $(this)
                .siblings()
                .children("input")
                .change(function() {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var urll = e.target.result;
                        $(previewImg).attr("src", urll);
                        previewImg.parent().css("background", "transparent");
                        previewImg.show();
                    };
                    reader.readAsDataURL(this.files[0]);
                });
        });
    </script>
    <!-- [ Main Content ] end -->
@endsection
