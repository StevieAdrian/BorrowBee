@extends('master.master')

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/default-avatar.png') }}" class="rounded-circle mb-3" width="140" height="140" style="object-fit:cover;">
                    <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">Member since {{ $user->created_at?->format('F Y') ?? '-' }}</p>

                    @auth
                        @if(auth()->id() !== $user->id)
                            <form action="{{ route('user.follow', $user->id) }}" method="POST">
                                @csrf
                                <button class="btn {{ $isFollowing ? 'btn-secondary' : 'btn-warning' }} px-4">
                                    {{ $isFollowing ? 'Following' : 'Follow' }}
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="row text-center mb-4">
                <div class="col">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-bold mb-0">{{ $user->followers()->count() }}</h5>
                            <small class="text-muted">Followers</small>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-bold mb-0">{{ $user->followingUser()->count() }}</h5>
                            <small class="text-muted">Following</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">About</h6>

                    @if($user->bio)
                        <p class="mb-0">{{ $user->bio }}</p>
                    @else
                        <p class="text-muted mb-0">This user hasn't written a bio yet.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
