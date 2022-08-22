@extends('layouts.app')
@section('title', 'Code Juice')

@section('content')
    @include('layouts.inc.errors')
    @include('layouts.inc.success')
    <div class="card mb-4">
        <h5 class="card-header">Check Out</h5>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    @forelse ($methods as $method)
                        <div class="col-md-6 mb-3">
                            <label for="inputEmail4" class="form-label">{{ $method->name }}</label>
                            <input type="radio" name="payment_method" value="{{ $method->slug }}" class="form-check-input">

                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Checke Out</button>
                </div>
            </form>

        </div>
    </div>

@endsection
