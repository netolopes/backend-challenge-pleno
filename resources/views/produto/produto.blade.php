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
   <body class="back">
      <div class="container-fluid mt-2">
         <div class="row">
            <div class="col-lg-12 margin-tb">
               <div style="color:white" class="pull-left">
                  <h2>Produtos</h2>
               </div>
               <div class="pull-right mb-2">
                  <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Add Produto</a>
                  <a class="btn btn-primary"  href={{ url("/front"); }}> Categorias</a>
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
                     <th>Tipo</th>
                     <th>Cor</th>
                     <th>Tamanho</th>
                     <th>Valor</th>
                     <th>Categoria</th>
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
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Tipo</label>
                        <div class="col-sm-12">
                           <input type="text" class="form-control" id="tipo" name="tipo" placeholder="tipo"  required="">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Cor</label>
                        <div class="col-sm-12">
                           <input type="text" class="form-control" id="cor" name="cor" placeholder="Cor"  required="">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Tamanho</label>
                        <div class="col-sm-12">
                           <input type="text" class="form-control" id="tamanho" name="tamanho" placeholder="Tamanho"  required="">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Valor</label>
                        <div class="col-sm-12">
                           <input type="number" step="0.01" class="form-control" id="valor" name="valor" placeholder="Valor"  required="">
                        </div>
                     </div>
                     <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Categoria</label>
                        <div class="col-sm-12">
                          <select class="form-control" name="categoria_id" id="categoria_id">
                              <option value="">Selecione</option>
                          </select>
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
        ajax: "{{ url('api/produto') }}",
        columns: [
        { data: 'id', name: 'id' },
        { data: 'nome', name: 'nome' },
        { data: 'descricao', name: 'descricao' },
        { data: 'tipo', name: 'tipo' },
        { data: 'cor', name: 'cor' },
        { data: 'tamanho', name: 'tamanho' },
        { data: 'valor', name: 'valor' },
        { data: 'nome_categoria', name: 'categoria_id' },
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
      $.ajax({
                type:"get",
                url: "{{ url('api/categoria') }}",
                dataType: 'json',
                success: function(result){

                $.each(result.data, function (key, val) {
                    $("#categoria_id").append($('<option ></option>', {value: val.id, text: val.nome}));
                });

                },
            });
    }
    function editFunc(id){
        const request =   $.ajax({
        type:"get",
        url: "{{ url('api/produto/show') }}"+"/"+id,
        dataType: 'json',
      success: function(res){
        $('#CompanyModal').html("Edit Company");
        $('#company-modal').modal('show');
        $('#id').val(res.data.id);
        $('#nome').val(res.data.nome);
        $('#descricao').val(res.data.descricao);
        $('#tipo').val(res.data.tipo);
        $('#cor').val(res.data.cor);
        $('#tamanho').val(res.data.tamanho);
        $('#valor').val(res.data.valor);

      },

      }).done(function (res) {

        $.ajax({
                type:"get",
                url: "{{ url('api/categoria') }}",
                dataType: 'json',
                success: function(result){

                $.each(result.data, function (key, val) {
                    $("#categoria_id").append($('<option ></option>', {value: val.id, text: val.nome}));
                });
                $('#categoria_id option[value="'+res.data.categoria_id+'"]').prop('selected', true);
                },
            });
        });
    }

    function deleteFunc(id){
      if (confirm("Delete Record "+ id +"?") == true) {
      var id = id;
      // ajax
      $.ajax({
        type:"DELETE",
        url: "{{ url('api/produto/delete') }}",
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
                url: "{{ url('api/produto/create')}}",
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
    let  tipo           = document.forms['CompanyForm'].elements['tipo'].value;
    let  cor           = document.forms['CompanyForm'].elements['cor'].value;
    let  tamanho           = document.forms['CompanyForm'].elements['tamanho'].value;
    let  valor           = document.forms['CompanyForm'].elements['valor'].value;
    let  categoria_id           = document.forms['CompanyForm'].elements['categoria_id'].value;

      var data = {
         "id":check_id,
         "nome":nome,
         "descricao":descricao,
         "tipo":tipo,
         "cor":cor,
         "tamanho":tamanho,
         "valor":valor,
         "categoria_id":categoria_id

         }
        $.ajax({
                type:'PUT',
                url: "{{ url('api/produto/edit')}}",
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
     <style>
         .back{
            background-image: linear-gradient(to left bottom, #051937, #004d7a, #008793, #00bf72, #a8eb12);
         }

    </style>
</html>
