@extends('layouts.app')
@section('title', 'Code Juice')

@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Dashboard / Payment Methods</h5>
    </div>
    <a class="btn btn-outline-primary mb-2" href="">
        Create Payment Method
    </a>
    <div class="card">
        <div class="card-body">
            <table class="table table-secondary table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payment_methods as $method)
                        <tr>
                            <th scope="row">{{ $method->id }}</th>
                            <td>{{ $method->slug }}</td>
                            <td>{{ $method->description }}</td>
                            <td>{{ $method->status }}</td>
                            <td>
                                {{-- <div class="btn-group" role="group" aria-label="Basic mixed styles example"> --}}
                                    <a href="" class="btn btn-outline-danger btn-sm">Delete</a>
                                    <a  href="{{route('payment.method.edit' , $method->id)}}" class="btn btn-outline-success btn-sm">edit</a>
                                    {{-- <button type="button" class="btn btn-warning">Middle</button> --}}
                                {{-- </div> --}}
                            </td>
                        </tr>
                    @empty
                        <th colspan="6">
                            <div class="alert alert-danger text-center w-50 m-auto">
                                <b>{{ 'No There Payment Methods :(' }}</b>
                            </div>
                        </th>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
