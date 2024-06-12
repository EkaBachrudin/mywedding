@extends('adm.layouts')
@section('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
<style>
    .name-input{
        width: 94%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #b8b8b8;
        margin-bottom: 5px;
    }
    .search-input{
        height: 30px;
        width: 300px;
        padding-left: 20px;
        padding-right: 20px;
        border: 1px solid rgba(0, 0, 0, 0.139);
    }
    input[type="checkbox"]:focus {
        outline: max(2px, 0.15em) solid currentColor;
        outline-offset: max(2px, 0.15em);
    }
    .action-section{
        height: 20px;
        padding-right: 15px;
    }
    .table-responsive{
        overflow: auto;
        height: 75vh;
    }
    thead{
        position: sticky;
        top: -3%;
        background-color: white;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-between mx-1">
            <h3><strong>All Guests</strong></h3>
            <form method="GET">
                <div class="input-group mb-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request()->get('search') }}"
                    class="search-input"
                    placeholder="Search name..."
                    aria-label="Search"
                    aria-describedby="button-addon2"
                    autocomplete="off">
                <button class="btn btn-success btn-sm ml-3" style="height: 30px;" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                @if (request()->get('search'))
                    <a href="/administrator" class="btn btn-danger btn-sm ml-3 d-flex align-items-center" style="height: 30px" type="submit" id="button-addon2">Clear</a>
                @endif

                </div>
            </form>
            <div class="btn btn-primary btn-sm" style="height: fit-content"  data-toggle="modal" data-target="#exampleModal">Add new guest</div>
        </div>
        <div class="row d-flex mx-1 mb-3">
            @if (request()->get('search'))
               <h5> Search result for : {{ request()->get('search') }}</h5>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr style="height: 80px">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Confirm</th>
                                    <th>Attendance</th>
                                    <th>URL</th>
                                    <th class="text-center">Action</th>
                                    <th>
                                        <div class="checkbox-field"></div>
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="overflow-auto">
                               @foreach ($datas as $data)
                               <tr class="guest-{{$data->id}}">
                                    <td class="guest-id">{{$data->id}}</td>
                                    <td class="guest-name">{{$data->name}}</td>
                                    <td class="guest-atten-confirm">{{$data->atten_confirm}}</td>
                                    <td class="guest-attendance"><button onclick="copyToClipboard('{{ $data->name }}', '{{ $data->url }}')">COPY TEXT</button></td>
                                    <td class="guest-url">{{$data->url}} </td>
                                    <td class="text-center">
                                        <i class="fas fa-edit text-info" onclick="getGuest({{$data->id}})"></i>
                                    </td>
                                    <td><input class="selectCheckbox" type="checkbox" value="{{$data->id}}"></td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5">
                            {!! $datas->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Guest -->
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

    <!-- Modal Edit Guest -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Guest</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="field_wrapper_update">
                        <div>
                            <input type="text" class="name-input" name="name" value="" placeholder="Enter guest name..." required autocomplete='off'/>
                        </div>
                    </div>
                    <div onclick="updateGuest()" class="btn btn-primary btn-sm mt-3"> Update guest </div>
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
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <script>
        var datatable = $("#datatable").DataTable();

        $(document).ready(function(){
            var maxField = 10;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            var fieldHTML = '<div><input type="text" name="name[]" class="name-input" value="" placeholder="Enter guest name..." required autocomplete="off"/><a href="javascript:void(0);" class="remove_button"><i class="fas fa-trash text-danger ml-2"></a></div>'; //New input field html
            var x = 1;


            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });


            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

        function getGuest(id) {
            var request = $.ajax({
                url: "/getguest/"+id,
                method: "GET"
            });

            request.done(function( response ) {
                $('.field_wrapper_update').find('.name-input').val(response.data.name);
                $('.field_wrapper_update').attr("data-guest", id);
                $('#editModal').modal('show');
            });

            request.fail(function( jqXHR, textStatus ) {
                toastr.error('Create guests failed !');
            });
        }

        function updateGuest() {
            var id = $('.field_wrapper_update').attr("data-guest");
            var name = $('.field_wrapper_update').find('.name-input').val();
            var request = $.ajax({
                url: '/updateguest/'+ id +'?_token=' + '{{ csrf_token() }}',
                data: {
                    name: name
                },
                method: "POST"
            });

            request.done(function( response ) {
                toastr.success('Update success !');
                $('.guest-'+id).find('.guest-name').html(response.data.name);
            });

            request.fail(function( jqXHR, textStatus ) {
                toastr.error('Update guest failed !');
            });
        }

        $("#selectAll").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            if($('input[type=checkbox]').is(':checked')){
                $('.delete-bulk').length === 0 ? $(".checkbox-field").append('<i onclick="confirmDeleteGuest()" style="top: 20px" class="position-absolute delete-bulk fas fa-trash text-danger mr-1"></i>') : null
            }else{
                $( ".delete-bulk" ).remove();

            }
        });

        $(".selectCheckbox").click(function(){
             if($('input[type=checkbox]').is(':checked')){
                $('.delete-bulk').length === 0 ? $(".checkbox-field").append('<i onclick="confirmDeleteGuest()" style="top: 20px" class="position-absolute delete-bulk fas fa-trash text-danger mr-1"></i>') : null
            }else{
                $( ".delete-bulk" ).remove();
            }
        });

        function confirmDeleteGuest() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                );
                deleteGuests();
            }
            })
        }

        function deleteGuests(){
            var guests = []
            var checkboxes = document.querySelectorAll('.selectCheckbox:checked')

            for (var i = 0; i < checkboxes.length; i++) {
                guests.push(checkboxes[i].value)
            }

             var request = $.ajax({
                url: '/deleteguests?_token=' + '{{ csrf_token() }}',
                data: {
                    guests: guests
                },
                method: "POST"
            });

            request.done(function( response ) {
                toastr.success(response.message);
                for (const numb of guests) {$('.guest-'+numb).remove()}
            });

            request.fail(function( jqXHR, textStatus ) {
                toastr.error('Delete guests failed !');
            });
        }

        function copyToClipboard(name, url) {
            var name = name;
            var weddingLink = url;
            var text = `Kepada Yth.\n` +
                       `*${name}*\n\n` +
                       `Tanpa mengurangi rasa hormat, kami bermaksud mengundang Bapak/Ibu/Saudara/i, pada acara tasyakuran pernikahan kami\n\n` +
                       `*The Wedding of Eka & Ana*\n` +
                       `Hari/Tgl : Minggu, 23 Juni 2024\n` +
                       `Alamat :  Papandayan Ballroom Plaza Metropolitan, Jl. Sultan Hasanudin lantai 2, Bekasi Regency\n\n` +
                       `Info lebih lengkap klik link di bawah ini\n` +
                       `${weddingLink}\n\n` +
                       `Atas kehadiran dan do'a restu yang diberikan, kami ucapkan terima kasih.\n\n` +
                       `Kami yang berbahagia,\n` +
                       `*Eka & Ana*`;
            navigator.clipboard.writeText(text).then(() => {
                alert('Invitation text copied to clipboard!');
            });
        }
    </script>
@endsection
