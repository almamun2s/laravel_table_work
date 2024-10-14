@extends('admin.layout.index')

@section('title', 'Work Create')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <style>
                        .input-item {
                            margin-top: 1rem;
                        }
                    </style>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('work.create') }}" method="post">
                                @csrf
                                <div class="input-item">
                                    <label for="date">Date(pick a date to add work for your user)</label>
                                    <input type="date" name="date" class="form-control">
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="input-item">
                                    <input type="submit" value="Next" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
