@extends('layouts.admin')
@section('header', 'Member')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div id="controller">
  <div class="container">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-9">
                        <a href="#" class="btn btn-primary" @click="addData()">Create New Member</a>
                    </div>
                    <div class="col-md-3">
                        <select name="gender" class="form-control">
                            <option value="A">Semua Jenis Kelamin</option>
                            <option value="L">Laki - laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table id="datatable" class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">No.</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Jenie Kelamin</th>
                        <th class="text-center">Nomor Telepon</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Email</th>
                        <th style="width: 200px" class="text-center">Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
            </div>

            <div class="modal fade" id="modal-default">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form :action="actionUrl" method="POST" autocomplete="off" @submit="submitForm($event, data.id)">
                    <div class="modal-header">
                      <h4 class="modal-title">Member</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                        <div class="form-group">
                            <label for="name">Nama Anggota</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" :value="data.name" required>
                        </div>

                        <div class="form-group">
                            <label for="gender">Jenis Kelamin</label>
                            <select name="gender" class="form-control">
                                <option :selected="data.gender=='L'"  value="L">Laki - Laki</option>
                                <option :selected="data.gender=='P'" value="P">Perempuan</option>
                            </select>
                        </div>
                      
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="number" name="phone_number" class="form-control" id="phone_number" placeholder="Enter Phone Number" :value="data.phone_number" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address" :value="data.address" required>
                        </div>

                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" :value="data.email" required>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script>
var actionUrl = '{{ url('members') }}';
var apiUrl = '{{ url('api/members') }}';

var columns = [
  {data: 'DT_RowIndex', class: 'text-center', orderable: true},
  {data: 'name', class: 'text-center', orderable: true},
  {data: 'jk', class: 'text-center', orderable: true},
  {data: 'phone_number', class: 'text-center', orderable: true},
  {data: 'address', class: 'text-center', orderable: true},
  {data: 'email', class: 'text-center', orderable: true},
  {render: function (index, row, data, meta){
    return `
      <a href="#" class="btn btn-warning" onclick="controller.editData(event, ${meta.row})">Edit</a>
      <a href="#" class="btn btn-danger" onclick="controller.deleteData(event, ${data.id})">Delete</a>
      `;
  }, orderable: false, width: '200px', class: 'text-center' },
];
</script>
<script src="{{ asset('assets/js/data.js') }}"></script>
<script>
$('select[name=gender]').on('change', function(){
    gender = $('select[name=gender]').val();
    if(gender == 'A'){
      controller.table.ajax.url(apiUrl).load();
    } else {
      controller.table.ajax.url(apiUrl+'?gender='+gender).load();
    }
})
</script>
@endsection