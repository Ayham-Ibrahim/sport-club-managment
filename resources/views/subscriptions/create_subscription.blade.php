@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Subscription</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('subscriptions.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="form-group mt-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required>
                        </div>

                        <!-- Sport Selection -->
                        <div class="form-group mt-3">
                            <label for="sport_id">Select Sport</label>
                            <select name="sport_id" class="form-control" id="sport_id" required>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}">{{ $sport->name }} ({{ $sport->price }} per month)</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Number of Months -->
                        <div class="form-group mt-3">
                            <label for="months">Number of Months</label>
                            <input type="number" name="months" class="form-control" id="months" value="{{ old('months', 1) }}" min="1" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Create Subscription</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
