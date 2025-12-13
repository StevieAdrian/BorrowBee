@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/viewProfile.css') }}">
@endsection

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
                    <a href="#" onclick="openFollowPopup('followers')" class="text-dark text-decoration-none">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center py-3">
                                <h5 class="fw-bold">
                                    <div>{{ $user->followers()->count() }}</div>
                                </h5>
                                <div class="stat-label">Followers</div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="#" onclick="openFollowPopup('following')" class="text-dark text-decoration-none">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center py-3">
                                <h5 class="fw-bold">
                                    {{ $user->followingUser()->count() }}
                                </h5>
                                <small class="text-muted">Following</small>
                            </div>
                        </div>
                    </a>
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

<div id="followPopup" class="follow-popup d-none" onclick="closeFollowPopup()">
    <div class="follow-popup-card" onclick="event.stopPropagation()">
        <div class="follow-popup-header">
            <button onclick="closeFollowPopup()" class="back-btn">←</button>
            <span class="username">{{ $user->name }}</span>
        </div>
        <div class="follow-tabs">
            <button id="tab-followers" onclick="switchTab('followers')" class="active">
                Followers
            </button>
            <button id="tab-following" onclick="switchTab('following')">
                Following
            </button>
        </div>
        <div class="follow-list">
            <div id="followers-list">
                @forelse($user->followers as $follower)
                    <a href="{{ route('users.show', $follower->id) }}" class="follow-item">
                        <img src="{{ $follower->avatar ? asset('storage/'.$follower->avatar) : asset('assets/default-avatar.png') }}">
                        <strong>{{ $follower->name }}</strong>
                    </a>
                @empty
                    <p class="empty-text">No followers yet</p>
                @endforelse
            </div>
            <div id="following-list" class="d-none">
                @forelse($user->followingUser as $following)
                    <a href="{{ route('users.show', $following->id) }}" class="follow-item">
                        <img src="{{ $following->avatar ? asset('storage/'.$following->avatar) : asset('assets/default-avatar.png') }}">
                        <strong>{{ $following->name }}</strong>
                    </a>
                @empty
                    <p class="empty-text">Not following anyone</p>
                @endforelse
            </div>
        </div>

    </div>
</div>


<script>
    function openFollowPopup(tab) {
        document.getElementById('followPopup').classList.remove('d-none');
        switchTab(tab);
    }

    function closeFollowPopup() {
        document.getElementById('followPopup').classList.add('d-none');
    }

    function switchTab(tab) {
        document.getElementById('followers-list').classList.toggle('d-none', tab !== 'followers');
        document.getElementById('following-list').classList.toggle('d-none', tab !== 'following');

        document.getElementById('tab-followers').classList.toggle('active', tab === 'followers');
        document.getElementById('tab-following').classList.toggle('active', tab === 'following');
    }
</script>

@endsection
