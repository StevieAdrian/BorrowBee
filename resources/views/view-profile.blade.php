@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/viewProfile.css') }}">
@endsection

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="profile-header mb-4">
                <div class="profile-avatar">
                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('assets/default-avatar.png') }}">
                </div>

                <div class="profile-meta">
                    <div class="profile-top">
                        <h4 class="username">{{ $user->name }}</h4>
                        @auth
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('user.follow', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm {{ $isFollowing ? 'btn-secondary' : 'btn-warning' }}">
                                        {{ $isFollowing ? 'Following' : 'Follow' }}
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>

                    <div class="profile-stats">
                        <span onclick="openFollowPopup('followers')">
                            <strong>{{ $user->followers()->count() }}</strong> followers
                        </span>
                        <span onclick="openFollowPopup('following')">
                            <strong>{{ $user->followingUser()->count() }}</strong> following
                        </span>
                    </div>

                    <div class="profile-bio">
                        @if($user->bio)
                            {{ $user->bio }}
                        @else
                            <span class="text-muted">This user hasn't written a bio yet.</span>
                        @endif
                    </div>

                </div>
            </div>
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Reviews by {{ $user->name }}</h6>
                    @forelse($reviews as $review)
                        <div class="mb-3 pb-3 border-bottom">
                            <a href="{{ route('books.show', $review->book->id) }}" class="fw-semibold text-decoration-none text-dark">
                                {{ $review->book->title }}
                            </a>

                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="star-rating" style="--rating: {{ $review->rating }};">★★★★★</span>
                                <small class="text-muted">
                                    {{ number_format($review->rating, 1) }} ·
                                    {{ $review->created_at->diffForHumans() }}
                                </small>
                            </div>

                            <p class="mb-0 mt-2">
                                {{ Str::limit($review->content, 150) }}
                            </p>
                        </div>
                    @empty
                        <p class="text-muted mb-0">
                            This user hasn’t written any reviews yet.
                        </p>
                    @endforelse

                    @if($reviews->hasPages())
                        <div class="mt-3">
                            {{ $reviews->links() }}
                        </div>
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
