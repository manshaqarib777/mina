<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css"> 
</head>
<body>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<title><?php echo e($ldms_general_setting_data->site_title); ?></title>



<div class="col-md-12 panel">
<center><h3><strong>Editar Categoría</strong></h3> </center>
<?php echo Form::open(['route' => ['categoria.update',$ldms_user_data->id], 'method' => 'PUT']); ?>

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<strong>Nombre de categoría:</strong>	
			<?php echo e(Form::text('categoria_name',$value = $ldms_user_data->categoria_name,array('required' => 'required', 'class' => 'form-control mar-t-b'))); ?>


	
		

			
			<input type="submit" value="<?php echo e(trans('file.Submit')); ?>" class="btn btn-success">
			
			 <input type="button" onclick="history.go(-1);"  class="btn btn-warning" id="editForm" value="Regresar">
			
		</div>
	</div>
</div> 

<?php echo Form::close(); ?>

<script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

<script type="text/javascript">

	$('#genbutton').click(function(){
      $.get('../password', function(data){
        $("input[name='password']").val(data);
        alert('Password has set to  "' + data +'"');
      });
    });

 var ldms_experiedDate = $('#ldms_experiedDate');
 ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     autoclose: true,
     todayHighlight: true
     });


 </script>
</body>
