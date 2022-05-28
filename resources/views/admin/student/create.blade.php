@extends('admin.layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add Student</h3>
                        </div>
                        <!-- /.card-header -->
                        @include('admin.partials.flash_message')                      
                        <!-- form start -->
                        <form action="{{ route('students.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Picture:</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"> <b>Subject</b> </div>
                                    <div class="col-sm-4"> <b>Number</b> </div>
                                    <div class="col-sm-4"><button class="btn btn-sm btn-primary" id="addRow">Add New</button></div>
                                </div>
                                <br />
                                <div id="inputFormRow">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <select class="custom-select" name="subject[]" required>
                                                    @foreach ($subjects as $subject )
                                                    <option value="{{$subject->id}}">{{ Str::ucfirst($subject->subject_name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <input type="number" class="form-control" id="achieve_number"name="achieve_number[]" required placeholder="Enter number">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="newRow"></div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer"> <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                        
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
@push('js')
    <script>
        // add row
        $("#addRow").click(function(e) {
            e.preventDefault();
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="row">';
            html +='<div class="col-sm-4"><div class="form-group"> <select class="custom-select" name="subject[]" required> @foreach ($subjects as $subject )  <option value="{{$subject->id}}">{{ Str::ucfirst($subject->subject_name) }}</option>  @endforeach </select> </div></div>';
            html += ' <div class="col-sm-4"> <div class="form-group"> <input type="number" class="form-control" id="achieve_number"name="achieve_number[]" placeholder="Enter number"> </div> </div>';
            html += '<div class="col-sm-4"> <button id="removeRow" type="button" class="btn btn-danger">Remove</button></div>';
            html += '</div>';
            html += '</div>';
            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputFormRow').remove();
        });
    </script>
@endpush
