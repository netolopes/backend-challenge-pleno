<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>App</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
      <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
   </head>
   <body>
      <div class="container-fluid mt-2">
         <div class="row">
            <div class="col-lg-12 margin-tb">
               <div class="pull-left">
                  <h2>Categorias</h2>
               </div>
               <div class="pull-right mb-2">
                  <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Add Categoria</a>
                  <a class="btn btn-primary"  href={{ url("/produto"); }}> Produtos</a>
               </div>
            </div>
         </div>
         @if ($message = Session::get('success'))
         <div class="alert alert-success">
            <p>{{ $message }}</p>
         </div>
         @endif
         <div class="card-body">
            <table style="width:100% " class="table table-bordered data-table" id="ajax-crud-datatable">
               <thead class="table-dark">
                  <tr>
                     <th>Id</th>
                     <th>Nome</th>
                     <th>Descricao</th>
                     <th>Action</th>
                  </tr>
               </thead >
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
      <!-- boostrap company model -->
      <div class="modal fade" id="company-modal" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h4 class="modal-title" id="CompanyModal"></h4>
               </div>
               <div class="modal-body">
                  <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                     <input type="hidden" name="id" id="id">
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nome</label>
                        <div class="col-sm-12">
                           <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome"  required="">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Descricao</label>
                        <div class="col-sm-12">
                           <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descricao"  required="">
                        </div>
                     </div>
                     <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                        </button>
                     </div>
                  </form>
               </div>
               <div class="modal-footer"></div>
            </div>
         </div>
      </div>
      <!-- end bootstrap model -->
   </body>
   <script type="text/javascript">
    $(document).ready( function () {
      $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $('#ajax-crud-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('api/categoria') }}",
        columns: [
        { data: 'id', name: 'id' },
        { data: 'nome', name: 'nome' },
        { data: 'descricao', name: 'descricao' },
        {data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'desc']]
      });
    });
    function add(){
      $('#CompanyForm').trigger("reset");
      $('#CompanyModal').html("Add User");
      $('#company-modal').modal('show');
      $('#id').val('');
    }
    function editFunc(id){
      $.ajax({
        type:"get",
        url: "{{ url('api/categoria/show') }}"+"/"+id,
        dataType: 'json',
      success: function(res){
        $('#CompanyModal').html("Edit Company");
        $('#company-modal').modal('show');
        $('#id').val(res.data.id);
        $('#nome').val(res.data.nome);
        $('#descricao').val(res.data.descricao);
      }
      });
    }

    function deleteFunc(id){
      if (confirm("Delete Record "+ id +"?") == true) {
      var id = id;
      // ajax
      $.ajax({
        type:"DELETE",
        url: "{{ url('api/categoria/delete') }}",
        data: { id: id },
        dataType: 'json',
      success: function(res){
        var oTable = $('#ajax-crud-datatable').dataTable();
        oTable.fnDraw(false);
      },
            error: function(res){
          //  console.log(res.responseJSON.error);
          if(res.responseJSON.error.substr(17, 30) == "Integrity constraint violation"){
            alert('Cannot delete or update a parent row: a foreign key constraint fails');
          }else{
            alert("error, connection!");
          }

        }
      });
      }
    }
    $('#CompanyForm').submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      var check_id = document.forms['CompanyForm'].elements['id'].value;
      var result = "";

    if(check_id == '' || check_id == null){
        $.ajax({
                type:'POST',
                url: "{{ url('api/categoria/create')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
            success: (data) => {
                $("#company-modal").modal('hide');
                var oTable = $('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Submit');
                $("#btn-save"). attr("disabled", false);
            },
            error: function(jqXHR, textStatus, errorThrown){
            alert(textStatus + ": " + jqXHR.status + " " + errorThrown);
        }
        });

    }else{

    let  descricao         = document.forms['CompanyForm'].elements['descricao'].value;
    let  nome           = document.forms['CompanyForm'].elements['nome'].value;

      var data = {
         "id":check_id,
         "descricao":descricao,
         "nome":nome
         }
        $.ajax({
                type:'PUT',
                url: "{{ url('api/categoria/edit')}}",
                data: data,
            success: (data) => {
                $("#company-modal").modal('hide');
                var oTable = $('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Submit');
                $("#btn-save"). attr("disabled", false);
            },
            error: function(jqXHR, textStatus, errorThrown){
            alert(textStatus + ": " + jqXHR.status + " " + errorThrown);
        }
        });
    }


    });
   </script>
</html>
