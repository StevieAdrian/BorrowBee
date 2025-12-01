@extends('master.master')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 text-center mb-4">
            <img src="{{ asset('assets/default-pp.png') }}" alt="Profile Picture" class="rounded-circle mb-3" width="150">
            <h3>{{ $user->name }}</h3>
            <p>{{ $user->email }}</p>
            <a href="#" class="btn btn-secondary">Change Profile Picture</a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color: #FFB933; color: #333;">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <!-- Profile Edit Form -->
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Change Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="**************">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="**************">
                        </div>

                        <button type="submit" class="btn" style="background-color: #FFB933; color: #333;">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
