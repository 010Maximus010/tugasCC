@extends('layouts/main')

@section('content')

<style>
    .center-content {
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
</style>
  
<main>
    <div class="container-login">
        <div class="row justify-content-center align-item-center">
            <div class="col-lg-10 col-md-10 col-sm-12 py-md-5">
                <div class="row shadow">
                    <div class="col-lg-12 p-0">
                        @error('loginError')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 p-md-0 order-1 order-md-0">
                        <img src="{{ asset('assets/images/logo1.jpg') }}" alt="..." style="width:675px; height:545px;">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-4 p-md-5 order-1 order-md-0">
                        <div class="center-content">
                            <img src="{{ asset('assets/images/logo_undip.png') }}" class="img-fluid mb-3 ml-md-4 ml-sm-5" width="120px" alt="Logo">
                            <h4 style="font-weight: bolder;">StudyfyIF</h4>
                            <p class="mb-3">Universitas Diponegoro</p>
                        </div>
                        <form class="mb-3 mt-md-3" action="/login" method="POST">
                            @csrf
                            <!-- Identifier -->
                            <div class="mb-3">
                                <label class="form-label" style="font-size: small"> NIM atau Email <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" style="font-size: small" id="identifier" name="identifier" placeholder="Masukkan NIM atau Email" value="{{ old('identifier') }}" required>
                            </div>
                            <!-- Password -->
                            <div class="mb-3 position-relative">
                                <label class="form-label" style="font-size: small"> Password <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control fakepassword" style="font-size: small" id="password" name="password" placeholder="Masukkan Password" required>
                                    <span class="input-group-text p-0">
                                        <i class="fakepasswordicon fa-solid fa-eye-slash cursor-pointer p-2 w-40px"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('script')

@include('sweetalert::alert')

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

<script>
    // disable all input and button after submit
    $('form').submit(function() {
        // show spinner on button
        $(this).find('button[type=submit]').html(
            `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...`
        );
        $('button').attr('disabled', 'disabled');
    });
</script>
@stop