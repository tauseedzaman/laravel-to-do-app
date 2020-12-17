<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>To do app</title>
        <link rel="stylesheet" href="../resources/css/bootstrap.css">
        <link rel="stylesheet" href="../resources/css/w3.css">
        <script src="../resources/js/jquery.min.js"></script>
        <script src="../resources/js/bootstrap.min.js"></script>
    </head>
    <body class="bg-light">
        <h1 class="text-center text-success my-4">Laravel To Do App</h1>
        <div class="container bg-light">
            <div class="row">
                <div class="col">
                    <div class=" flex-column mx-auto modal p-4 text-danger" id="loading" style="margin-top: 200px;margin-left: 550px !important;"></div>
                </div>
            </div>
            <div class="modal w3-animate-zoom " id="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h4 class="modal-title" id="formModalLabel">Add To List</h4>
                            <button class="close" onclick="close_model()">X</button>

                        </div>
                        <div class="modal-body">
                            <form id="myForm" name="myForm"  class="form" novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label>Message</label>
                                    <input type="text" class="form-control" id="message" autocomplete="off" name="message"
                                           placeholder="Enter Message" required  class="form-control ">
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-primary save_btn" id="save_btn">Save</button>
                            <button type="button" class="btn btn-warning" onclick="close_model()">Close</button>
                            <input type="hidden" id="id" name="id" value="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class=" row py-0 my-0">
                <div class=" col mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <span class="text-capitalize w3-xlarge text-info my-auto">what you will do today!</span>
                            <button class="float-right btn btn-danger ml-2 btn-lg my-auto" id="delete_all">Clear All</button>
                            <button class="float-right btn btn-success btn-lg my-auto modal-btn " id="add_btn">Add</button>
                        </div>
                        <div class="card-body " id="load_data_here">

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script>
            //show model
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#add_btn').click(function (){
                    $('#modal').modal('show');
                    $('#message').val('');
                });
            });
            //add data
            $(document).on('click','#save_btn',function (){
                   var message = $('#message').val();
                if (message == ''){
                    alert('please fill field!');
                    return false;
                }
                $.ajax({
                    url:"{{url('store')}}",
                    type:'post',
                    data:{
                        message : message,
                    },
                    beforeSend:function (){
                        $('#loading').addClass('spinner-border');
                    },
                    success:function (){
                        $('#loading').removeClass('spinner-border');
                        $('#modal').modal('hide');
                        $('#message').val('');
                        load_data();
                    }
                })
            });
            //edit data
            $(document).on('click','#edit_btn',function(){
                var id = $(this).data('id');
                $.ajax({
                    url:'{{url('edit')}}',
                    type:'post',
                    data:{
                        id:id,
                    },
                    beforeSend:function (){
                        $('#loading').addClass('spinner-border');
                    },
                    success:function(res){
                        $('#loading').removeClass('spinner-border');
                        $('.modal-title').attr('data-e_id',id);
                        $('.save_btn').attr('id','update_btn');
                        $('.save_btn').text('Update Record');
                        $('.save_btn').val(id);
                        $('.modal-title').text('Update Action');
                        $('#modal').modal('show');
                        $('#message').val(res.data.message);
                    }
                });
            });
            //update record
            $(document).on('click','#update_btn',function(){
                var message = $('#message').val();
                var id = $(".save_btn").val();
                $.ajax({
                    url:'{{url('update')}}',
                    type:'post',
                    data:{
                        message:message,
                        id:id,
                    },
                    beforeSend:function (){
                        $('#loading').addClass('spinner-border');
                    },
                    success:function(res){
                        $('#loading').removeClass('spinner-border');
                        $('#modal').modal('hide');
                        $('.save_btn').attr('id','add_btn');
                        $('.save_btn').text('Add Record');
                        $('.modal-title').text('Add Action');
                        $('.save_btn').val('');
                        $('#message').val('');
                        load_data();
                    }
                });
            });
            //delete data
            $(document).on('click','#delete_btn',function(){
                var id = $(this).data('id');
                if (confirm('Delete Record!')){
                    $.ajax({
                        url:"{{url('destroy')}}",
                        type:'post',
                        data:{id:id},
                        beforeSend:function (){
                            $('#loading').addClass('spinner-border');
                        },
                        success:function (a) {
                            $('#loading').removeClass('spinner-border');
                            load_data();
                        }

                    });
                }
            });
            //delete all data
            $(document).on('click','#delete_all',function(){
                if (confirm('Delete All Records!')){
                    $.ajax({
                        url:"{{url('destroyAll')}}",
                        type:'post',
                        beforeSend:function (){
                            $('#loading').addClass('spinner-border');
                        },
                        success:function () {
                            $('#loading').removeClass('spinner-border');
                            load_data();
                        }

                    });
                }
            });
            //close model
            function close_model(){
                $('#modal').modal('hide');
                $('#message').val('');
            }

            //load data
            function load_data(){
                $.ajax({
                    url:'{{url('loaddata')}}',
                    type: 'get',
                    beforeSend:function (){
                        $('#loading').addClass('spinner-border');
                    },
                    success:function (e){
                        $('#loading').removeClass('spinner-border');
                        $('#load_data_here').empty().append(e);
                    }
                });
            }
            load_data();
        </script>
    </body>
</html>
