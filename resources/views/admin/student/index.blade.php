@extends('admin.layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            @include('admin.partials.flash_message')
                            <h3 class="card-title">Student Table</h3>
                            <a href="{{ route('students.create') }}" class="float-right btn btn-sm btn-primary">Create Student</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">SL</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $key => $student)
                                        <tr>
                                            <td> {{ $key += 1 }} </td>
                                            <td> <img src="{{ asset('backend/admin/images/' . $student->image) }}"
                                                    width="55" height="65" alt=""> </td>
                                            <td> {{ $student->name }} </td>
                                            <td> {{ $student->studentResult->sum('achieve_number') }} </td>
                                            <td>
                                                <form action="{{ route('students.destroy', $student->id) }}" method="Post"
                                                    style="">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-success">View</a>
                                                    <a href="{{ route('students.edit', $student->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {!! $students->links() !!}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('js')
    <script></script>
@endpush
