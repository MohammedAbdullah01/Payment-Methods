@extends('layouts.app')
@section('title', 'Code Juice')

@section('content')
    @include('layouts.inc.errors')
    @include('layouts.inc.success')
    <div class="card mb-4">
        <h5 class="card-header">Edit / Payment Method</h5>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('payment.method.update', $method->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="inputEmail4" class="form-label">Payment Name</label>
                        <input type="text" name="name" class="form-control" id="inputEmail4">
                    </div>

                    <div class="col-md-6 mb-3 ">
                        <label for="inputState" class="form-label">Status</label>
                        <select id="inputState" name="status" class="form-select">

                            <option value="active">{{ 'active' }}</option>
                            <option value="inactive">{{ 'inactive' }}</option>
                        </select>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Payment Description </label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">
                        {{ $method->description }}
                    </textarea>
                    </div>
                </div>

                <div class="row">
                    @forelse ($options as $key => $option)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="{{ $key }}">{{ $option['lable'] }}</label>
                            <input class="form-control" name="options[{{ $key }}]" type="text"
                                id="{{ $key }}">
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>

@endsection
