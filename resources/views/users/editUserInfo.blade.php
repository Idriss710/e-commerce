@extends('layouts.base')
@section('content')
<div class="col-lg-8">
    <form class="needs-validation" method="POST" action="{{route('user.edit')}}">
        @csrf
        @method('put')
        
        <div id="billingAddress" class="row g-4">
            <h3 class="mb-3 theme-color">Basic Details</h3>
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{Auth::user()->name}}"
                    placeholder="Enter Full Name">
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{Auth::user()->email}}"
                    placeholder="Enter Phone Number">
                    @error('email'){{$message}}
                        
                    @enderror
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{Auth::user()->phone}}"
                    placeholder="Enter Phone Number">
                    @error('phone'){{$message}}
                        
                    @enderror
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"  value=""
                    placeholder="Enter Phone Number">
                    @error('password'){{$message}} @enderror
                    <input type="checkbox" onclick="myFunction()">Show Password
            </div>
                       
        </div>

        

        

        <hr class="my-lg-5 my-4">

        
        <button class="btn btn-solid-default mt-4" type="submit">Confirm</button>
    </form>
</div>
@endsection
@push('scripts')
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            }
    </script>
@endpush