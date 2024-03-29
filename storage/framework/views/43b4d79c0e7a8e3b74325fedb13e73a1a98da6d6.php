<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($ldms_general_setting_data->site_title); ?></title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/main.css')?>" type="text/css">
</head>
<body>
<?php echo $__env->make('partials.topMenu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message1')): ?>
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message1')); ?></div> 
<?php endif; ?>
<?php if($errors->has('title')): ?>
 <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><?php echo e($errors->first('title')); ?></strong></div>

<?php endif; ?>

    <!--Document Update Start-->
    <form class="form-group" method="post" action="ldms_update/<?php echo $document->id; ?>" files="true" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="col-md-6">
            <?php if($file_exist == 1): ?>
            <?php
            $fileExtension = $document['file_name'] ;
            $fileExtension = substr($fileExtension, strpos($fileExtension, ".") + 1);
            if ($fileExtension=='doc' || $fileExtension=='docx') {
                ?>
            <iframe style="width:100%;height: 100vh;margin-top: 30px" scrolling="no" src='https://view.officeapps.live.com/op/embed.aspx?src=http://lion-coders.com/doc/<?php echo $document["file_name"]; ?>' frameborder='0'></iframe>
            <?php
            } else {
                ?>
            <iframe style="width:100%;height: 100vh;margin-top: 30px" scrolling="no" src='../../public/document/<?php echo $document["file_name"]; ?>' frameborder='0'></iframe>
            <?php
            } ?>
            <?php else: ?>
                <h2 class="text-center">Archivos no encontrados</h2>
            <?php endif; ?>
        </div>

        <div class="col-md-6 col-offset-md-6">
            <div class="col-md-12 panel">
                <h1><?php echo e(trans('file.Edit Document')); ?></h1>
                <input type="hidden" name="id" value="<?php echo $document["id"]; ?>">
                <div class="form-group col-md-12">
                     <label for="ldms_documentTitle"><?php echo e(trans('file.Document Title')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="title" id="ldms_documentTitle" value="<?php echo $document["title"]; ?>">
                         </div>
                     </div>
                </div>          
                
                  <div class="form-group col-md-12">
                     <label for="ldms_documentComentario">Comentario</label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                             <input class="form-control" type="text" name="comentario" id="ldms_documentComentario" value="<?php echo $document["comentario"]; ?>">
                         </div>
                     </div>
                </div>   
                
                <div class="form-group col-md-12">
                    <label ><?php echo e(trans('file.Category')); ?></label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <select name="category_id" class="form-control">
                                <option>Elige una categoría</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if($document["category_id"] == $category->id): ?> selected <?php endif; ?>><?php echo e($category->name); ?></option>                                   
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </select>
                         </div>
                    </div>
                </div> 
                
                
          
               <div class="form-group col-md-12">
                    <label for="ldms_createDate">Fecha de creación</label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_createDate" name="ldms_createDate" class="form-control" type="text" name="date" value="<?php echo $document["create_date"]; ?>">
                         </div>
                    </div>
                </div>
          
          
                <div class="form-group col-md-12">
                    <label for="ldms_experiedDate"><?php echo e(trans('file.Expired Date')); ?></label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input id="ldms_experiedDate" name="ldms_experiedDate" class="form-control" type="text" name="date" value="<?php echo $document["expired_date"]; ?>">
                         </div>
                    </div>
                </div>
                <div class="form-group col-md-12">
                     <label for="ldms_email"><?php echo e(trans('file.Notification Email')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="text" name="ldms_email" id="ldms_email" value="<?php echo $document["email"]; ?>">
                         </div>
                     </div>
                </div>
                <div class="form-group col-md-12">
                     <label><?php echo e(trans('file.Notification Mobile')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input class="form-control" type="text" name="mobile" value="<?php echo $document["mobile"]; ?>">
                         </div>
                     </div>
                </div>
  
                
                <?php
            $ldms_user_data = DB::table('users')->where('id', Auth::id())->first();
            $ldms_role_data = Db::table('roles')->where('id', $ldms_user_data->role_id)->first();
          ?>
          <?php if($ldms_role_data->id !== 6): ?> 
          
          
                          <div class="form-group col-md-12">
                     <label> <?php echo e(trans('file.Document')); ?></label>
                     <div class="form-group-inner">
                         <div class="field-outer">
                            <input type="hidden" name="previousFileName" value="<?php echo $document["file_name"]; ?>">
                            <input type="file" name="ldms_documentFile" id="ldms_documentFile">
                            <label class="btn btn-default" for="ldms_documentFile"><i class="fa fa-upload"></i> <?php echo e(trans('file.Upload File')); ?></label>
                            <span id="ldms_document_file_name"></span>
                         </div>
                     </div>
                </div>  
          
          
                
                <div class="form-group submit col-md-12 text-left">
                    <label for="submit"></label>
                    <div class="form-group-inner">
                         <div class="field-outer">
                           <input type="submit" name="submit" value="<?php echo e(trans('file.Update')); ?>" class="btn btn-primary" id="editForm">
                         </div>
                    </div>
                </div> 
           <?php endif; ?>     
                
            </div>
        </div>               
    </form>
<!--Document Update End-->
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/jquery-ui.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
 <script type="text/javascript" src="<?php echo asset('public/js/bootstrap-datepicker.min.js')?>"></script>

 <script type="text/javascript">
 var ldms_experiedDate = $('#ldms_experiedDate');
 ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     autoclose: true,
     todayHighlight: true
     });
     
 var ldms_createDate = $('#ldms_createDate');
 ldms_createDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y')?>",
     autoclose: true,
     todayHighlight: true
     });     
     
     
 var editForm = $('#editForm');
 editForm.on("click",function () {
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
    });

  var  ldms_document_file = $("#ldms_documentFile");
  ldms_document_file.change(function(){
      var  ldms_document_file_name = $("#ldms_document_file_name");
      ldms_document_file_name.html($(":file").val());
   });

 </script>
 </body>
 </html>
