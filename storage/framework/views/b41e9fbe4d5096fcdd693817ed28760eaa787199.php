<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.checkboxes.css') ?>">
</head>
<body>
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<title><?php echo e($ldms_general_setting_data->site_title); ?></title>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<?php if(count($ldms_user_list)!=0): ?>
  <div class="col-md-9">     
    <!--user List Start-->
    <div class="col-md-12 panel">
        <h1><strong>Categorías</strong></h1>
        
        <div class="container-fluid">
            <a href="<?php echo e(action("DocumentController@ldmsCreate")); ?>"  class="btn btn-primary"><i class="fa fa-file"></i> VER DOCUMENTOS</a>
        </div>
        
        <div class="col-md-12"> 
          <table id="user-table" class="table table-bordered table-striped">
            <thead>
             
              <th><?php echo e(trans('file.SL No')); ?></th>
              <th>Nombre de Categoría</th>         
              <th class="text-center hidden-print not-exported"><?php echo e(trans('file.Option')); ?></th>
            </thead>
            
            <tbody>
              <?php $__currentLoopData = $ldms_user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                              
                  <td><?php echo e($key+1); ?></td>
                  <td><?php echo $categoria->categoria_name; ?></td>
                  <td class="text-center hidden-print">
                      <div class="btn-group">
                          <button type="button" class="btn btn-default"><?php echo e(trans('file.Action')); ?></button>
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu dropdown-default pull-right" user="menu">
                              <li><a title = "View" href="<?php echo $categoria->id; ?>/edit"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo e(trans('file.View')); ?></a></li>

                              <li class="divider"></li>
                              <?php echo Form::open(['route' => ['categoria.destroy', $categoria->id], 'method' => 'DELETE'] ); ?>

                              <li>
                                <button type="submit" class="custom-del" onclick="return confirmDelete()"><i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('file.Delete')); ?></button> 
                              </li>
                              <?php echo Form::close(); ?>

                          </ul>
                      </div>
                  </td>
                  
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="col-md-3">
  <div class="col-md-12 panel">
  <center><h3><strong>Agregar Categoría</strong> </h3> </center>
  <div class="row">
    <div class="col-md-12">
      <?php echo Form::open(['route' => 'categoria.store', 'method' => 'post']); ?>

      
      <div class="form-group">
             <label for="ldms_userName">Nombre de categoría*</label>
             <div class="form-group-inner">
                <div class="field-outer">
                    <?php echo e(Form::text('categoria_name',null,array('required' => 'required', 'class' => 'form-control'))); ?>

                </div>
             </div>

          </div>

          <div class="form-group">
              <input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-primary">
          </div> 

    </div>      
  </div>
  </div>
  
</div>

  
      
<?php echo Form::close(); ?>


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

$('#genbutton').click(function(){
      $.get('password', function(data){
        $("input[name='password']").val(data);
        alert('Password has set to  "' + data +'"');
      });
    });

  $('#user-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ <?php echo e(trans("file.records per page")); ?>',
             "info":      '<?php echo e(trans("file.Showing")); ?> _START_ - _END_ (_TOTAL_)',
            "search":  '<?php echo e(trans("file.Search")); ?>',
            'paginate': {
                    'previous': '<?php echo e(trans("file.Previous")); ?>',
                    'next': '<?php echo e(trans("file.Next")); ?>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 5]
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
                text: '<?php echo e(trans("file.PDF")); ?>',
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
                text: '<?php echo e(trans("file.CSV")); ?>',
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
                text: '<?php echo e(trans("file.Print")); ?>',
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
                text: '<?php echo e(trans("file.Column visibility")); ?>',
                columns: ':gt(0)'
            },
        ],
    } );

      
<?php if(count($ldms_user_list)!=0): ?>

    function confirmDelete() {
      if (confirm("¿Seguro que deseas eliminar este dato?")) {
          return true;
      }
      return false;
    }

    $(function () {
      var tooltip = $('[data-toggle="tooltip"]');
      tooltip.tooltip({container: 'body'});
    });

  
<?php endif; ?>
</script>



