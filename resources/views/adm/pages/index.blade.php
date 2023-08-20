@extends('adm.layouts')
@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<style>
    .name-input{
        width: 94%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #b8b8b8;
        margin-bottom: 5px;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-between mx-1">
            <h3><strong>All Guests</strong></h3>
            <div class="btn btn-primary btn-sm" style="height: fit-content"  data-toggle="modal" data-target="#exampleModal">Add new guest</div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table" id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Confirm</th>
                                    <th>Attendance</th>
                                    <th>URL</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($datas as $data)
                               <tr>
                                    <td>{{$data->id}}</td>
                                    <td>{{$data->name}}</td>
                                    <td> <span>{{$data->atten_confirm}}</span></td>
                                    <td> <span>{{$data->attendance}}</span></td>
                                    <td> {{$data->url}} </td>
                                    <td class="text-center">
                                        <i class="fas fa-edit text-info"></i>
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add new quest</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div>
                <form action="{{url('createguest')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="field_wrapper">
                        <div>
                            <input type="text" class="name-input" name="name[]" value="" placeholder="Enter guest name..." required autocomplete='off'/>
                            <a href="javascript:void(0);" class="add_button" title="Add field"> <i class="fas fa-plus text-info ml-2"></i></a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mt-3"> Add guests </button>
                </form>
            </div>
        </div>
        </div>
    </div>
    </div>
@endsection

@section('javascript')
  <!-- DataTables  & Plugins -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

    <script>
        $(function () {
            $("#datatable").DataTable();
        });

        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div><input type="text" name="name[]" class="name-input" value="" placeholder="Enter guest name..." required autocomplete="off"/><a href="javascript:void(0);" class="remove_button"><i class="fas fa-trash text-danger ml-2"></a></div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
@endsection
