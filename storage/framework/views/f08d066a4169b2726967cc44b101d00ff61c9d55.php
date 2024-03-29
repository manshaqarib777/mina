<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($ldms_general_setting_data->site_title); ?></title>
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/bootstrap-datepicker.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/font-awesome.min.css')?>" type="text/css"> 
    <link rel="stylesheet" href="<?php echo asset('public/css/jquery-ui.min.css')?>" type="text/css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/css/dataTables.checkboxes.css') ?>">
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
<?php if(count($document_list)!=0): ?>
  <div class="col-md-12">     
    <!--Document List Start-->
    <div class="col-md-12 panel">
        <h1>Documentos que venceran pronto(<?php echo $ldms_total_documents_number;?>)</h1>
    
        <div class="col-md-12"> 
            <table id="document-table" class="table table-bordered table-striped">
              <thead>
                <th class="not-exported"></th>
                <th><?php echo e(trans('file.SL No')); ?></th>
                <th><?php echo e(trans('file.Document Title')); ?></th>
                <th><?php echo e(trans('file.Expired Date')); ?></th>
                <th><?php echo e(trans('file.Notification Email')); ?></th>            
                <th class="text-center hidden-print not-exported"><?php echo e(trans('file.Option')); ?></th>
              </thead>
              <tbody>
                <?php $__currentLoopData = $document_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $fileExtension = $document->file_name ;
                $fileExtension = substr($fileExtension, strpos($fileExtension, ".") + 1);
                $todayDate = strtotime(date('Y-m-d'));
                $expiredDate = strtotime($document->expired_date);
                ?>   
                        <tr class=<?php if ($expiredDate<$todayDate) {
                            echo "danger";
}?> data-toggle="tooltip" data-placement="top"  title= "<?php if ($expiredDate<$todayDate) {
    echo "Document Date is Expired";
}?>">
                            <td><?php echo e($key); ?></td>
                            <td><?php echo $key+1 ?></td>
                            <td><?php echo $document->title; ?></td>
                            <td><?php echo date('d-m-Y', strtotime($document->expired_date)); ?></td>
                            <td><?php echo $document->email; ?></td>
                    
                                <td class="text-center hidden-print">
                                <?php
                                if ($expiredDate<$todayDate) {
                                    $ldms_line_through = "line-through";
                                } else {
                                    $ldms_line_through = "none";
                                }?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Action</button>
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">
                                            <li><a title = "View" href="ldms_edit/<?php echo $document->id; ?>"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo e(trans('file.View')); ?></a></li>
                                            <li class="divider"></li>
                                            <li><a title = "Download" href="../public/document/<?php echo $document->file_name;?>" download><i class="fa fa-download" aria-hidden="true"></i> <?php echo e(trans('file.Download')); ?></a></li>
                                            <li class="divider"></li>
                                            <li><a title = "Delete" href="ldms_delete/<?php echo $document->id; ?>/<?php echo $document->file_name; ?>" onclick='return confirmDelete()'><i class="fa fa-trash" aria-hidden="true"></i> <?php echo e(trans('file.Delete')); ?></a></li>
                                            <li class="divider"></li>
                                            <li><a class="<?php if ($expiredDate<$todayDate) {
                                                echo "disabled";
}?>" href="ldms_alarm_date/<?php echo $document->id; ?>" title="Alarm Date"><i class="fa fa-bell" aria-hidden="true"></i> <span style="text-decoration:<?php echo $ldms_line_through;?>"><?php echo e(trans('file.Alarm')); ?></span></a>
                                            </li>
                                      </ul>
                                </div>
                                </td>
                        </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tbody>
            </table>
        </div>
    </div>
    <!--Document List End-->
  </div>
<?php endif; ?> 

    

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

  $('#document-table').DataTable( {
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
                'targets': 0,
                'checkboxes': {
                   'selectRow': true
                }
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

    var ldms_experiedDate = $('#ldms_experiedDate');
    ldms_experiedDate.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('+2 day')); ?>",
     autoclose: true,
     todayHighlight: true
     });
    var createForm = $('#createForm');
    createForm.on("click",function () {
        var ldms_documentTitle = $.trim($('#ldms_documentTitle').val());
        if (ldms_documentTitle == '') {
            alert("Document Title can't be empty.");
            $("#ldms_documentTitle").focus();
            return false;
        }
        var ldms_email = $.trim($('#ldms_email').val());
        if (ldms_email == '') {
            alert("Alarm Sending Email can't be empty.");
            $('#ldms_email').focus();
            return false;
        }
        var ldms_documentFile = $.trim($('#ldms_documentFile').val());
        if (ldms_documentFile == '') {
            alert("Document File can't be empty.");
            $('#ldms_documentFile').focus();
            return false;
        }
    });

    var  ldms_document_file = $("#ldms_documentFile");
    ldms_document_file.change(function(){
        var  ldms_document_file_name = $("#ldms_document_file_name");
        ldms_document_file_name.html($(":file").val());
     });

<?php if(count($document_list)!=0): ?>
    var ldms_tags_email = [ <?php $__currentLoopData = $ldms_documents_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $emailArray[] = $document->email;
        ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

  var ldms_tags_title = [ <?php $__currentLoopData = $ldms_documents_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $documentTitleArray[] = $document->title;
        ?>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php
            echo  '"'.implode('","', $documentTitleArray).'"';
            ?> ];

    var ldms_documentTitleSearch = $('#ldms_documentTitleSearch');
    ldms_documentTitleSearch.autocomplete({
      source: function( request, response ) {
              var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( request.term ), "i" );
              response( $.grep( ldms_tags_title, function( item ){
                  return matcher.test( item );
              }) );
          },
      select: function(event,ui){
        ldms_documentTitleSearch.val(ui.item.value);
        var ldms_search = $("#ldms_search");
        $("#ldms_search").submit();
        }
    });    

    function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
    }

    $(function () {
      var tooltip = $('[data-toggle="tooltip"]');
      tooltip.tooltip({container: 'body'});
    });

  function print_current(){
    var myWindow=window.open('','','width=800,height=500');
    <?php
          $ldms_print_serial = 1;
          $html="<html><head><title></title><link rel='stylesheet' href='";
          $html.= asset('public/css/bootstrap.min.css');
          $html.= "' type='text/css'></head><body><table class='table table-bordered table-striped'><tr><td>SL No.</td><td>Document Title</td><td>Expired Date</td><td>Notification Email</td></tr>";
    foreach ($document_list as $document) {
        $html.="<tr><td>".$ldms_print_serial."</td><td>".$document->title."</td><td>".$document->expired_date."</td><td>".$document->email ."</td></tr>";
        $ldms_print_serial++;
    }
          $html.="</table></body></html>";
    ?>

    var html_printCurrent = "<?php echo $html; ?>";
    myWindow.document.write(html_printCurrent);
    myWindow.document.close();
    myWindow.focus();
    myWindow.print(); 
  }

  function print_all(){
    var myWindow=window.open('','','width=800,height=500');
    <?php
          $ldms_print_serial = 1;
          $html="<html><head><title></title><link rel='stylesheet' href='";
          $html.= asset('public/css/bootstrap.min.css');
          $html.= "' type='text/css'></head><body><table class='table table-bordered table-striped'><tr><td>SL No.</td><td>Document Title</td><td>Expired Date</td><td>Notification Email</td></tr>";
    foreach ($ldms_close_expired_documents_all as $document) {
        $html.="<tr><td>".$ldms_print_serial."</td><td>".$document->title."</td><td>".$document->expired_date."</td><td>".$document->email ."</td></tr>";
        $ldms_print_serial++;
    }
          $html.="</table></body></html>";

    ?>

    var html_printAll = "<?php echo $html; ?>";
    myWindow.document.write(html_printAll);
    myWindow.document.close();
    myWindow.focus();
    myWindow.print(); 
  }
<?php endif; ?>
</script>
</body>
</html>
