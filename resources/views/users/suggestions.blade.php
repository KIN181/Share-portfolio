@extends('layouts.app')

@section('title', 'Suggested Users')

@section('content')
    <div class="container w-50 mx-auto bg-white shadow-sm pb-5">
        <p class="display-6 text-center p-5">suggested</p>

        @if ($suggested_users)
            @foreach ($suggested_users as $user)
                <div class="row align-items-center mb-4 ps-5">
                    <div class="col-auto">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="{{ $user->name }}" class="rounded-circle avatar-md">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                            @endif
                        </a>
                    </div>
                    <div class="col ps-0 text-truncate">
                        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">
                            {{ $user->name }}
                        </a>
                        <p class="text-muted small p-0 m-0">{{ $user->email }}</p>
                        <p class="text-muted small p-0 m-0">
                            @if ($user->followers->count() > 0)
                                Followed by {{ $user->followers->count()}} {{ $user->followers->count() == 1 ? 'user' : 'users' }}
                            @else
                                No followers yet
                            @endif
                        </p>
                    </div>
                    <div class="col text-center">
                        <form action="{{ route('follow.store', $user->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary fw-bold">Follow</button>
                        </form>
                    </div>


                </div>
            @endforeach
        @endif
    </div>
@endsection