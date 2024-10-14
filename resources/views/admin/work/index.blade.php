@extends('admin.layout.index')

@section('title', 'Work')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Default Datatable</h4>
                    <p class="card-title-desc"><a href="{{ route('work.date_select') }}">User Daily Work Add</a></p>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Date Time</th>
                                <th>User Name</th>
                                <th>Account Name</th>
                                <th>Offer Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($works as $key => $work)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $work->date }}</td>
                                    <td>{{ $work->user->name }}</td>
                                    <td>{{ $work->account->name }}</td>
                                    <td>{{ $work->offer->name }}</td>
                                    <td>
                                        <a href="#" class="btn btn-warning">Edit</a>
                                        <a href="#" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- <tr>
                                <td>1</td>
                                <td>Date</td>
                                <td>User</td>
                                <td>Account</td>
                                <td>Offer</td>
                                <td>
                                    <a href="#" class="btn btn-warning">Edit</a>
                                    <a href="#" class="btn btn-danger">Delete</a>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
