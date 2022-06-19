<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$ldms_general_setting_data->site_title}}</title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.checkboxes.css') ?>">
</head>
<body>
@include('partials.topMenu')

@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('message1'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message1') }}</div> 
@endif
@if($errors->has('title'))
 <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>{{ $errors->first('title') }}</strong></div>

@endif


@if(count($document_list)!=0)

  <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
          @if($ldms_role_data->id == 6)

           <div class="col-md-12">     
          @else
           <div class="col-md-9"> 
          @endif
  
  
  
    <!--Document List Start-->
    <div class="col-md-12 panel">
          <h1>Cantidad de documentos agregados: (<?php echo $ldms_total_documents_number;?>)</h1>
        <div class="container-fluid">


          <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
          @if($ldms_role_data->id == 4)
          <div class="col-md-3">
            
             <a href="../categories"  class="btn btn-primary"><i class="fa fa-file"></i> VER CATEGORÍAS</a>

            </div>

          @endif

            <div class="col-md-9">
                <form id="filter_form" method="get" action="ldms_create" class="form-horizontal row">
                    {!! csrf_field() !!}
                    <div class="col-md-3">
                        <div class="form-group">
                            <input class="form-control month_year date"
                                placeholder="Fecha de Inicio" readonly=""
                                id="start_date" name="start_date" type="text" required
                                value="">
                        </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input class="form-control month_year date"
                                placeholder="Fecha Final" readonly=""
                                id="end_date" name="end_date" type="text" required
                                value="">
                        </div>
                    </div>
                    
                     <div class="col-md-1">

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="form-actions">
                                <button type="submit" class="filtering btn btn-primary"><i class="fa fa-search"></i> Filtrar búsqueda
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>



     </div>
        
   
        
        <div class="col-md-12"> 
            <table id="document-table" class="table table-bordered table-striped">
              <thead>
                <th class="not-exported"></th>
                <th>{{trans('file.SL No')}}</th>
                <th>{{trans('file.Category')}}</th>         
                <th>{{trans('file.Document Title')}}</th>         
                <th>Fecha de creación</th>
                <th>{{trans('file.Expired Date')}}</th>
               <!-- <th>{{trans('file.Notification Email')}}</th>
                <th>{{trans('file.Notification Mobile')}}</th>   -->  

           
                <th class="text-center hidden-print not-exported">{{trans('file.Option')}}</th>
                    
              </thead>
              <tbody>
              
             
           
             
                @foreach($document_list as $key=>$document)
                  <?php
                  $fileExtension = $document->file_name ;
                  $fileExtension = substr($fileExtension, strpos($fileExtension, ".") + 1);
                  $todayDate = strtotime(date('Y-m-d'));
                  $expiredDate = strtotime($document->expired_date);
                  $category = $categories->where('id',$document->category_id)->pluck('name')->implode('name');                  
                  ?>   
                        <tr class=<?php if ($expiredDate<$todayDate) {
                            echo "danger";
                            }?> data-toggle="tooltip" data-placement="top"  title= "<?php if ($expiredDate<$todayDate) {
                                echo trans('file.Document Date is Expired');
                            }?>">
                            <td>{{$key}}</td>
                            <td><?php echo $key + 1 ?></td>
                            <td>  @if($category != ''){{ $category}} @else {{ trans('file.Uncategorized') }}@endif
                           
                           </td>
                            <td><b>{!! $document->title !!}</b><br>
                           <span class="h6 text-info">{!! $document->comentario !!} </span></td>
                           
                            <td>{!! date('d-m-Y', strtotime($document->create_date)) !!}</td> 
                            
                            <td>{!! date('d-m-Y', strtotime($document->expired_date)) !!}</td>
                            
                           <!-- <td>{!! $document->email !!}</td>
                            <td>{!! $document->mobile !!}</td> -->
                            
                            
                  
                  <td class="text-center hidden-print">
                                <?php
                                if ($expiredDate<$todayDate) {
                                    $ldms_line_through = "line-through";
                                } else {
                                    $ldms_line_through = "none";
                                }?>
                  <div class="btn-group">
                                        <button type="button" class="btn btn-default">{{trans('file.Action')}}</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                   <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                            <li><a title = "View" href="ldms_edit/{!! $document->id !!}"><i class="fa fa-eye" aria-hidden="true"></i> {{trans('file.View')}} / Editar</a></li>
                                            <li class="divider"></li>
                                            <li><a title = "Download" href="../public/document/<?php echo $document->file_name;?>" download><i class="fa fa-download" aria-hidden="true"></i> {{trans('file.Download')}}</a></li>
                    
                                      <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
          @if($ldms_role_data->id !== 6)       
                                          
                 <li class="divider"></li>
                                            <li><a title = "Delete" href="ldms_delete/{!! $document->id !!}/{!! $document->file_name !!}" onclick='return confirmDelete()'><i class="fa fa-trash" aria-hidden="true"></i> {{trans('file.Delete')}}</a></li>
                                            <li class="divider"></li>
                  <li><a class="<?php if ($expiredDate<$todayDate) {
                      echo "disabled"; }?>" href="ldms_alarm_date/{!! $document->id !!}" title="Alarm Date"><i class="fa fa-bell" aria-hidden="true"></i> <span style="text-decoration:<?php echo $ldms_line_through;?>">{{trans('file.Alarm')}}</span></a>
                  </li>
             @endif       
                  
                                      </ul>
                                </div>
                                </td>
                        </tr>
                @endforeach
                

                
              </tbody>
            </table>
        </div>
    </div>
    <!--Document List End-->
  </div>
@endif 


        <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
@if($ldms_role_data->id != 6) 
  <div class="col-md-3">

@else
 <div class="col-md-12">

@endif 



      
       <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
@if($ldms_role_data->id !== 6) 
      
   
    <div class="col-md-12 panel">
        <h3>{{trans('file.Upload New Document')}}</h3> 
   
<!--@eSSlse
  <div class="col-md-8 col-md-offset-2">
    <div class="col-md-12 panel">
        <h3>{{trans('file.Upload New Document')}}</h3>
@endiSSSf  -->


        <!--Document Create Start-->
        <form method="post" action="ldms_store" files="true" enctype="multipart/form-data">
            <div class="col-md-12">
                {!! csrf_field() !!}
                <div class="form-group">
                     <label for="ldms_documentTitle">{{trans('file.Document Title')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="title" id="ldms_documentTitle" placeholder="{{trans('file.Trade License')}}">
                         </div>
                     </div>
                </div> 

                <div class="form-group">
                     <label for="ldms_documentTitle">Comentario</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="comentario" id="comentario" placeholder="Comentario aquí">
                         </div>
                     </div>
                </div> 


              <div class="form-group">
                    <label >{{trans('file.Category')}}</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <select name="category_id" class="form-control">
                                <option>Elegir una categoría</option>
                               @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>                                   
                               @endforeach
                           </select>
                         </div>
                    </div>
                </div>         
                
                
                
                <div class="form-group">
                    <label for="ldms_createDate">Fecha de Creación *</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_createDate" name="ldms_createDate" class="form-control" type="text" name="date" value="<?php echo date('d-m-Y'); ?>">
                         </div>
                    </div>
                </div>
                
                
                <div class="form-group">
                    <label for="ldms_experiedDate">{{trans('file.Expired Date')}} *</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_experiedDate" name="ldms_experiedDate" class="form-control" type="text" name="date" value="<?php echo date('d-m-Y', strtotime('+2 day')); ?>">
                         </div>
                    </div>
                </div>
                <div class="form-group">
                     <label for="ldms_email">{{trans('file.Notification Email')}} * (Para agregar más correos debes separarlos con ",". Ejemplo: mail1,mail2,etc)</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="text" name="ldms_email" id="ldms_email" placeholder=
                            "correo@ademisa.com">
                         </div>
                     </div>
                </div>
                <div class="form-group">
                     <label for="ldms_email">{{trans('file.Notification Mobile')}} (Agrega el código de País. Ejemplo: +51999999999. Para ingresar varios números separalos con ",".</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="text" name="mobile" placeholder=
                            "+51*********">
                         </div>
                     </div>
                </div>
                <div class="form-group">
                     <label for="ldms_documentFile">{{trans('file.Document')}}</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input  type="file" name="ldms_documentFile" id="ldms_documentFile">
                             <label class="btn btn-default" for="ldms_documentFile"><i class="fa fa-upload"></i> {{trans('file.Upload File')}}</label>
                             <span id="ldms_document_file_name"></span>
                         </div>
                     </div>
                </div>                                   
            </div>
            <div class="form-group submit text-right">
                <label for="submit"></label>
                <div class="form-group-inner">
                     <div class="field-outer">
                       <input type="submit" name="submit" value="{{trans('file.Submit')}}" class="btn btn-primary" id="createForm">
                     </div>
                </div>
            </div>                
         </form>
         <!--Document Create End-->
    </div> 
 @endif
    
  </div>
  


<div id="importProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'document.import', 'method' => 'post', 'files' => true]) !!}
        <div class="modal-header">
          <span style="font-weight: 850;">Import Document</span>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <i><small>{{trans('file.All field labels are required input fields.')}}</small></i><br><br>
           <p>{{trans('file.The correct column order is')}} (title, expiredDate(d-m-Y), email, mobile, fileName) {{trans('file.and you must follow this.')}} {{trans('file.Make sure expiredDate column is in text format.')}} {{trans('file.Files must be located in')}} public/document {{trans('file.directory')}}.</p>
           <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.Upload File')}} *</strong></label>
                        {{Form::file('file', array('class' => 'form-control','required'))}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong> {{trans('file.Sample File')}}</strong></label>
                        <a href="../public/sample/sample-doc.csv" class="btn btn-info btn-block btn-md"><i class="fa fa-download"></i>  {{trans('file.Download')}}</a>
                    </div>
                </div>
           </div>           
            <div class="form-group" id="operation_value"></div>
            <input type="submit" name="submit" value="{{trans('file.Submit')}}" class="btn btn-primary">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>

 <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

 <script type="text/javascript" src="<?php echo asset('public/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.bootstrap4.min.js') ?>">"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.print.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/buttons.colVis.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/sum().js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/dataTables.checkboxes.min.js') ?>"></script>
 
 <script type="text/javascript">

  var table =$('#document-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '{{trans("file.Previous")}}',
                    'next': '{{trans("file.Next")}}'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'print',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    modifier: {
                          page: 'current'
                    }
                },
                footer:true
            },
            {
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ]
    } );

    var ldms_experiedDate = $('#ldms_experiedDate');
    ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });
     
     
    var ldms_createDate = $('#ldms_createDate');
    ldms_createDate.datepicker({
     format: "dd-mm-yyyy",
    // startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });
     

    var createForm = $('#createForm');
    createForm.on("click",function () {
        var ldms_documentTitle = $.trim($('#ldms_documentTitle').val());
        if (ldms_documentTitle == '') {
            alert("El título del documento no puede estar vacío.");
            $("#ldms_documentTitle").focus();
            return false;
        }
        var ldms_email = $.trim($('#ldms_email').val());
        if (ldms_email == '') {
            alert("El correo electrónico de envío de alarma no puede estar vacío.");
            $('#ldms_email').focus();
            return false;
        }
        var ldms_documentFile = $.trim($('#ldms_documentFile').val());
        if (ldms_documentFile == '') {
            alert("El archivo del documento no puede estar vacío.");
            $('#ldms_documentFile').focus();
            return false;
        }
        
          

    });

    var  ldms_document_file = $("#ldms_documentFile");
    ldms_document_file.change(function(){
        var  ldms_document_file_name = $("#ldms_document_file_name");
        ldms_document_file_name.html($(":file").val());
     });



@if(count($document_list)!=0)
    var ldms_tags_email = [ @foreach($ldms_documents_all as $document)
        <?php
            $emailArray[] = $document->email;
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $emailArray).'"';
            ?> ];
    var ldms_email = $('#ldms_email');
    ldms_email.autocomplete({
      source: function( request, response ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
              response( $.grep( ldms_tags_email, function( item ){
                  return matcher.test( item );
              }) );
          }
    });
    

    function confirmDelete() {
      if (confirm("¿Estás seguro que quieres eliminar este documento?")) {
          return true;
      }
      return false;
    }

    $(function () {
      var tooltip = $('[data-toggle="tooltip"]');
      tooltip.tooltip({container: 'body'});
    });
@endif





 var searchParams = new URLSearchParams(window.location.search);
    if (searchParams != '') {
        var f_start_date = searchParams.get('filter_start_date').split("-");
        var f = new Date(f_start_date[2], f_start_date[1] - 1, f_start_date[0]);     
    }


    var start_date = $('#start_date');
    var end_date = $('#end_date');
    start_date.datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true   
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        end_date.datepicker('setStartDate', minDate);
    });

    end_date.datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    }).on('changeDate', function (selected) {
        var minDate = new Date(selected.date.valueOf());
        start_date.datepicker('setEndDate', minDate);
    });

    var searchParams = new URLSearchParams(window.location.search);
    if (searchParams != '') {
        var f_start_date = searchParams.get('filter_start_date').split("-");
        start_date.datepicker( 'setDate', new Date(f_start_date[2], f_start_date[1] - 1, f_start_date[0]) );  
        var f_end_date = searchParams.get('filter_end_date').split("-");
        end_date.datepicker( 'setDate', new Date(f_end_date[2], f_end_date[1] - 1, f_end_date[0]) );    
    }


    $('#filter_form').on('submit',function (e) {
        e.preventDefault();
        var filter_start_date = $('#start_date').val();
        var filter_end_date = $('#end_date').val();
        if (filter_start_date != '' && filter_end_date != '') { 
            document.location.href = "{{ route('document.create') }}?filter_start_date="+filter_start_date+"&filter_end_date="+filter_end_date;           
        }
        else {
            alert('Elige un rango de fechas');
        }
    });


</script>
</body>
</html>
