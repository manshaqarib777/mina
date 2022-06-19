<?php
namespace App\Http\Controllers;

use App\Document;
use App\Categoria;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Clickatell\Rest;
use Clickatell\ClickatellException;
use Carbon\Carbon;
use App\Categories;

class DocumentController extends Controller
{
    
    public function ldmsCreate(Request $request)
    {
    	$userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
    
    if ($roleData->id == '4' || $roleData->id == '6') {
            $ldms_documents_all = Document::all();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
 
       if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('create_date', [$start_date, $end_date])->get();
                $ldms_total_documents_number = count($document_list);
                
              if (count($document_list)==0) {
                return redirect()->back()->with('message1', 'No se encontraron documentos en esas fechas');
            }
                
            }
            else {
                $document_list = DB::table('documents')->get();
                $ldms_total_documents_number = count($document_list);
             
            //$ldms_total_documents_number = count($ldms_documents_all);
           // $document_list = Document::all();
             
            }    
   
            
            $ldms_categoria = Categoria::pluck('categoria_name','id');
            
             $categories = Categories::all();

            return view('document.create', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list','ldms_categoria','categories'));
        } else {
            $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            $todayDate = date('Y-m-d');
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id', '=' ,$userData->role_id],
                                        ['expired_date', '<', $todayDate],
                                        ]
                                    )->get();

                         $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
             
              if ($request->filter_start_date != '') {
                $start_date = Carbon::parse($request->filter_start_date)->format('Y-m-d') ?? '';
                $end_date = Carbon::parse($request->filter_end_date)->format('Y-m-d') ?? '';
                $document_list = DB::table('documents')->whereBetween('create_date', [$start_date, $end_date])->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
                
                              if (count($document_list)==0) {
                return redirect()->back()->with('message1', 'No se encontraron documentos en esas fechas');
            }
                
            }
            else {
                $document_list = DB::table('documents')->where('role_id', $userData->role_id)->get();
                $ldms_total_documents_number = count($document_list);
            
            //  $ldms_total_documents_number = count($ldms_documents_all);
          //  $document_list = Document::where('role_id', $userData->role_id)->get();
            
            
            }
             
           
              $ldms_categoria = Categoria::pluck('categoria_name','id');
            
            $categories = Categories::all();
            return view('document.create', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list','ldms_categoria','categories'));
        }
    }

    public function ldmsExpiredDocuments()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
     if ($roleData->id == '4' || $roleData->id == '6') {
            $ldms_documents_all = Document::all();
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));

            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)
                                    ->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
            $ldms_total_documents_number = count($ldms_expired_documents_all);
            
            
           
            $document_list =  Document::where('expired_date', '<', $todayDate)->get();


             if (count($ldms_expired_documents_all)==0) {
                return redirect()->back()->with('message1', 'No tienes documentos expirados');
            }

            return view('document.expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        } else {
            $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id',$userData->role_id],
                                        ['expired_date', '<', $todayDate]
                                        ]
                                    )->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id',$userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
            $ldms_total_documents_number = count($ldms_expired_documents_all);
      
                       if (count($ldms_expired_documents_all)==0) {
                return redirect()->back()->with('message1', 'No tienes documentos expirados');
            }
            
            
            $document_list =  Document::where(
                                        [
                                        ['role_id',$userData->role_id],
                                        ['expired_date', '<', $todayDate]
                                        ]
                                    )->get();

            return view('document.expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        }
    }

    public function ldmsCloseToBeExpiredDocuments()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();

  if ($roleData->id == '4' || $roleData->id == '6') {
      
        $ldms_documents_all = Document::all();
            $todayDate = date('Y-m-d');
            $interval = date('Y-m-d', strtotime('+30 days'));
      
            $ldms_expired_documents_all =  DB::table('documents')
                                ->where('expired_date', '<', $todayDate)
                                ->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                            ->where(
                                [
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();
            $ldms_total_documents_number = count($ldms_close_expired_documents_all);
            $document_list = DB::table('documents')
                            ->where(
                                [
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();


         if (count($ldms_close_expired_documents_all)==0) {
                return redirect()->back()->with('message1', 'No tienes documentos por expirar');
            }


            return view('document.close_to_be_expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        } else {
            
             $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
             $todayDate = date('Y-m-d');
             $interval = date('Y-m-d', strtotime('+30 days')); 
            $ldms_expired_documents_all =  DB::table('documents')
                                ->where(
                                    [
                                    ['role_id',$userData->role_id],
                                    ['expired_date', '<', $todayDate]
                                    ]
                                )
                                ->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                            ->where(
                                [
                                ['role_id', $userData->role_id],
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();
            $ldms_total_documents_number = count($ldms_close_expired_documents_all);
            $document_list = DB::table('documents')
                            ->where(
                                [
                                ['role_id', $userData->role_id],
                                ['expired_date', '>=', $todayDate],
                                ['expired_date', '<' , $interval]
                                ]
                            )->get();

         if (count($ldms_close_expired_documents_all)==0) {
                return redirect()->back()->with('message1', 'No tienes documentos por expirar');
            }


            return view('document.close_to_be_expired_documents', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        }
    }

    public function ldmsSearch()
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($roleData->id == '4' || $roleData->id == '6') {
            $ldms_documents_all = DB::table('documents')->get();
            
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where('expired_date', '<', $todayDate)->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();

            $ldms_total_documents_number = 1;
            $ldms_searched_title = $_GET['ldms_documentTitleSearch'];
            $document_list = DB::table('documents')
                            ->where('title', $ldms_searched_title)->get();

            if (count($document_list)==0) {
                return redirect()->back()->with('message1', 'Searched item not exists.');
            }

            return view('document.search', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        } else {
             $ldms_documents_all = DB::table('documents')->where('role_id', $userData->role_id)->get();
            
            $ldms_expired_documents_all = DB::table('documents')
                                    ->where(
                                        [
                                        ['role_id',$userData->role_id],
                                        ['expired_date', '<', $todayDate]
                                        ]
                                    )->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();

            $ldms_total_documents_number = 1;
            $ldms_searched_title = $_GET['ldms_documentTitleSearch'];
            $document_list = DB::table('documents')
                            ->where(
                                [
                                ['role_id',$userData->role_id],
                                ['title', $ldms_searched_title]
                                ]
                            )->get();

            if (count($document_list)==0) {
                return redirect()->back()->with('message1', 'Searched item not exists.');
            }

            return view('document.search', compact('ldms_documents_all', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all', 'ldms_total_documents_number', 'document_list'));
        }
    }

    public function ldmsStore(Request $request)
    {
        $ldms_objDocumentModel = new Document();
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $ldms_objDocumentModel->role_id = $userData->role_id;
                    $ldms_objDocumentModel->category_id = $request->category_id;
        

        
        $ldms_objDocumentModel->title = $_POST["title"];
        
                $ldms_objDocumentModel->comentario = $_POST["comentario"];
        
        $ldms_objDocumentModel->file_name = strtotime(date('Y-m-d H:i:s')).$_FILES["ldms_documentFile"]["name"];
        
                $ldms_objDocumentModel->create_date = date('Y-m-d', strtotime($_POST["ldms_createDate"]));
        
        $ldms_objDocumentModel->expired_date = date('Y-m-d', strtotime($_POST["ldms_experiedDate"]));
        $ldms_objDocumentModel->email = $_POST["ldms_email"];
        $ldms_objDocumentModel->mobile = $_POST["mobile"];
        $todayDate = strtotime(date('Y-m-d'));
        $expiredDate = strtotime($_POST["ldms_experiedDate"]);
        $dateDifference = ($expiredDate - $todayDate);
        $totalRemainingDays = floor($dateDifference / (60 * 60 * 24));
        if ($totalRemainingDays>1) {
            $target_dir = "public/document/";
            $target_file = $target_dir . strtotime(date('Y-m-d H:i:s')).basename($_FILES["ldms_documentFile"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Check file size
            if ($_FILES["ldms_documentFile"]["size"] > 10000000) {
                return redirect("document/ldms_create")->with('message1', 'Lo sentimos, su archivo es demasiado grande. Cargue un archivo de menos de 10 MB.');
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx"
            ) {
                return redirect("document/ldms_create")->with('message1', 'Lo sentimos, solo se permiten archivos jpg, jpeg, png, pdf, doc, docx y pdf.');
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                return redirect("document/ldms_create")->with('message1', 'Lo sentimos, su archivo no fue subido.');
            } else {
                if (move_uploaded_file($_FILES["ldms_documentFile"]["tmp_name"], $target_file)) {
                } else {
                    return redirect("document/ldms_create")->with('message1', 'Lo sentimos, hubo un error al cargar su archivo.');
                }
            }

            if ($totalRemainingDays>30) {
                $alarmDate = array(date('Y-m-d', strtotime('-30 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-15 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            } elseif ($totalRemainingDays>15) {
                $alarmDate = array(date('Y-m-d', strtotime('-15 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            } elseif ($totalRemainingDays>7) {
                $alarmDate = array(date('Y-m-d', strtotime('-7 day', strtotime($_POST["ldms_experiedDate"]))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            } elseif ($totalRemainingDays>1) {
                $alarmDate = array(date('Y-m-d', strtotime('-1 day', strtotime($_POST["ldms_experiedDate"]))));
            }
            $alarmDateList = implode(",", $alarmDate);
            $ldms_objDocumentModel->alarm = $alarmDateList;
            $status = $ldms_objDocumentModel->save();
            if ($status) {
                return redirect("document/ldms_create")->with('message', 'Documento insertado correctamente');
            } else {
                return redirect("document/ldms_create")->with('message1', 'No se pudo guardar, inténtalo de nuevo.');
            }
        } else {
            return redirect("document/ldms_create")->with('message1', 'La fecha de vencimiento debe ser dentro de 2 días a partir de ahora');
        }
    }

    public function import(Request $request)
    {
        //get file
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext != 'csv')
            return redirect()->back()->with('message1', 'Cargue un archivo CSV');

        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through other columns
        while($columns=fgetcsv($file))
        {
            foreach ($columns as $key => $value) {
                if($value == '' && $key != 3)
                    return redirect()->back()->with('message1', '¡La columna no puede estar vacía!');
                if($key == 1){
                    $todayDate = strtotime(date('d-m-Y'));
                    $expiredDate = strtotime(date('d-m-Y', strtotime($value)));
                    $dateDifference = ($expiredDate - $todayDate);
                    $totalRemainingDays = floor($dateDifference / (60 * 60 * 24));
                    if($totalRemainingDays < 2)
                        return redirect()->back()->with('message1', 'La fecha de vencimiento debe ser dentro de 2 días a partir de ahora');
                }
            }
            $data= array_combine($escapedHeader, $columns);
            $old_name = "./public/document/".$data['filename'];
            $new_name = "./public/document/".strtotime(date('Y-m-d H:i:s')).$data['filename'];
            $file_name = strtotime(date('Y-m-d H:i:s')).$data['filename'];
            rename($old_name, $new_name);
            if ($totalRemainingDays>30) {
                $alarmDate = array(date('Y-m-d', strtotime('-30 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-15 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }
            elseif ($totalRemainingDays>15) {
                $alarmDate = array(date('Y-m-d', strtotime('-15 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-7 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }
            elseif ($totalRemainingDays>7) {
                $alarmDate = array(date('Y-m-d', strtotime('-7 day', strtotime($data['expireddate']))),
                                     date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }
            elseif ($totalRemainingDays>1) {
                $alarmDate = array(date('Y-m-d', strtotime('-1 day', strtotime($data['expireddate']))));
            }

            $alarmDateList = implode(",", $alarmDate);
            $document = new Document();
            $document->role_id = Auth::user()->role_id;
            $document->title = $data['title'];
                        $document->category_id = $data['category_id'];
            $document->file_name = $file_name;
            $document->expired_date = date('Y-m-d', strtotime($data['expireddate']));
            $document->email = $data['email'];
            $document->mobile = $data['mobile'];
            $document->alarm = $alarmDateList;
            $document->save();
        }
        return redirect()->back()->with('message', 'Documentos importados con éxito');
    }

    public function ldmsEdit($id)
    {
        $userData = DB::table('users')->where('id', Auth::id())->first();
        $roleData = DB::table('roles')->where('id', $userData->role_id)->first();
        $ldms_objDocumentModel = new Document();
        $document = $ldms_objDocumentModel->find($id);

        $file_path = public_path('document/'.$document->file_name);

		if (file_exists($file_path))
		{
			$file_exist = 1;
		}
		else {
			$file_exist = 0;
		}

        $todayDate = date('Y-m-d');
        $interval = date('Y-m-d', strtotime('+30 days'));
        if ($roleData->id == '4' || $roleData->id == '6') {
            $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
                        
                    $ldms_categoria_all = Categoria::all();      
                    
                    
                                $ldms_user_data = Document::findOrFail($id);    
                                 $categories = Categories::all();
                        
            return view('document.edit', compact('ldms_categoria_all','document','ldms_user_data', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all','file_exist','categories'));
        } else {
            $ldms_expired_documents_all = DB::table('documents')
                                ->where(
                                    [
                                    ['role_id',$userData->role_id],
                                    ['expired_date', '<', $todayDate]
                                    ]
                                )->get();
            $ldms_close_expired_documents_all = DB::table('documents')
                        ->where(
                            [
                            ['role_id', $userData->role_id],
                            ['expired_date', '>=', $todayDate],
                            ['expired_date', '<' , $interval]
                            ]
                        )->get();
                        
                          $ldms_categoria_all = Categoria::all();      
                                    $ldms_user_data = Document::findOrFail($id);   
                                    
                 $categories = Categories::all();                     
            return view('document.edit', compact('ldms_categoria_all','document','ldms_user_data', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all','file_exist','categories'));
        }
    }

    public function ldmsUpdate(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $role_id = $document->role_id;
        $ldms_objDocumentModel = new Document();
        if (!empty($_FILES["ldms_documentFile"]["name"])) {
            $target_dir = "public/document/";
            $target_file = $target_dir . strtotime(date('Y-m-d H:i:s')).basename($_FILES["ldms_documentFile"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Check file size
            if ($_FILES["ldms_documentFile"]["size"] > 10000000) {
                return redirect("document/ldms_create")->with('message1', 'El tamaño del archivo es demasiado grande. Cargue un archivo de menos de 10 MB..');
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "pdf" && $imageFileType != "doc" && $imageFileType != "docx"
            ) {
                return redirect("document/ldms_create")->with('message1', 'Lo sentimos, solo se permiten archivos jpg, jpeg, png, pdf, doc, docx y pdf.');
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                return redirect("document/ldms_create")->with('message1', 'Lo sentimos, su archivo no fue subido.');
            } else {
                if (move_uploaded_file($_FILES["ldms_documentFile"]["tmp_name"], $target_file)) {
                } else {
                    return redirect("document/ldms_create")->with('message1', 'Lo sentimos, hubo un error al cargar su archivo.');
                }
            }
            unlink(public_path().'/document/'.$_POST["previousFileName"]);
            $document = $ldms_objDocumentModel->find($_POST["id"]);
            $document->title = $_POST["ldms_documentTitle"];
            
                        $document->comentario = $_POST["comentario"];
            
            $document->file_name = strtotime(date('Y-m-d H:i:s')).$_FILES["ldms_documentFile"]["name"];
            
            
                        $document->create_date = date('Y-m-d', strtotime($_POST["ldms_createDate"]));
            
            
            $document->expired_date = date('Y-m-d', strtotime($_POST["ldms_experiedDate"]));
            $document->email = $_POST["ldms_email"];
            $document->mobile = $_POST["mobile"];
            $status = $document->update();
        } else {
            $document = $ldms_objDocumentModel->find($_POST["id"]);
            $document->title = $_POST["title"];
            
                        $document->comentario = $_POST["comentario"];
            
            $document->create_date = date('Y-m-d', strtotime($_POST["ldms_createDate"]));
            
            $document->expired_date = date('Y-m-d', strtotime($_POST["ldms_experiedDate"]));
               $document->category_id = $request->category_id;
            
            $document->email = $_POST["ldms_email"];
            $document->mobile = $_POST["mobile"];
            $status = $document->update();
        }
        if ($status) {
            return redirect("document/ldms_create")->with('message', 'Documento actualizado con éxito');
        } else {
            redirect("document/ldms_create")->with('message1', 'No se pudo actualizar, inténtalo de nuevo.');
        }
    }

    public function ldmsDelete($id, $fileName)
    {
        $ldms_objDocumentModel = new Document();
        $status = $ldms_objDocumentModel->find($id)->delete();
        unlink(public_path().'/document/'.$fileName);

        if ($status) {
            return redirect()->back()->with('message', 'Documento eliminado con éxito');
        } else {
            return redirect()->back()->with('message1', 'No se pudo eliminar, inténtalo de nuevo.');
        }
    }

    public function ldmsAlarmDate($id)
    {
        $ldms_objDocumentModel = new Document();
        $alarmDateList = $ldms_objDocumentModel->find($id);
        $todayDate = strtotime(date('Y-m-d'));
        $expiredDate = strtotime($alarmDateList['expired_date']);
        if ($expiredDate<$todayDate) {
            $document = $ldms_objDocumentModel->find($id);
            $alarmDateList = $document->alarm = "";
            DB::table('documents')
                ->where('id', $id)
                ->update(['alarm' => ""]);
            $alarmDateList = $ldms_objDocumentModel->find($id);
        }
        $todayDate = date('Y-m-d');
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)
                                ->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->whereRaw('expired_date > now() and expired_date < now()+INTERVAL 30 DAY')
                    ->get();
        return view('document.alarm_date', compact('alarmDateList', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
    }

    public function ldmsAlarmAdd()
    {
        $ldms_objDocumentModel = new Document();
        $id = $_POST["id"];
        $document = $ldms_objDocumentModel->find($id);
        $inputAlarm = strtotime($_POST["ldms_new_alarm"]);
        $newAlarm = date('Y-m-d',$inputAlarm);

        $previousAlarmDateList = $_POST["previousAlarmDateString"];
        if (strpos($previousAlarmDateList, $newAlarm) === false) {
            if (!empty($previousAlarmDateList)) {
                $alarmDateList = $previousAlarmDateList.",".$newAlarm;
            } else {
                $alarmDateList = $newAlarm;
            }
            $document->alarm = $alarmDateList;

            $status = $document->update();
            if ($status) {
                return redirect("document/ldms_alarm_date/$id")->with('message', 'Alarma añadida con éxito');
            } else {
                return redirect("document/ldms_alarm_date/$id")->with('message1', 'No se pudo agregar, inténtalo de nuevo.');
            }
        } else {
            return redirect("document/ldms_alarm_date/$id")->with('message1', '¡Advertencia! no se puede configurar una alarma duplicada.');
        }
    }

    public function ldmsAlarmDelete($alarmDate, $id, $alarmDateList)
    {
        $ldms_objDocumentModel = new Document();
        $alarmDateList = explode(",", $alarmDateList);
        $alarmDateList = (array_diff($alarmDateList, array($alarmDate)));
        $alarmDateList = implode(",", $alarmDateList);
        $document = $ldms_objDocumentModel->find($id);
        $document->alarm = $alarmDateList;
        $status = $document->update();
        if ($status) {
            return redirect("document/ldms_alarm_date/$id")->with('message', 'Alarma eliminada con éxito');
        } else {
            return redirect("document/ldms_alarm_date/$id")->with('message1', 'No se pudo eliminar, inténtalo de nuevo.');
        }
    }

    public function ldmsUpdateProfile()
    {
        $userID =  Auth::user()->id;
        $userInformation = DB::table('users')->where('id', '=', $userID)->get();
        $todayDate = date('Y-m-d');
        $ldms_expired_documents_all = DB::table('documents')
                                ->where('expired_date', '<', $todayDate)
                                ->get();
        $ldms_close_expired_documents_all = DB::table('documents')
                    ->whereRaw('expired_date > now() and expired_date < now()+INTERVAL 30 DAY')
                    ->get();
        return view('document.updateProfile', compact('userInformation', 'ldms_expired_documents_all', 'ldms_close_expired_documents_all'));
    }

    public function ldmsManageProfileUpdate()
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $userID = $_POST["id"];
        $status = DB::table('users')
                  ->where('id', $userID)
                ->update(
                    ['name_full' => $_POST["ldms_name_full"],
                    'name' => $_POST["ldms_name"],
                    'email' => $_POST["ldms_email"]]
                );
        if (isset($status)) {
            return redirect("document/ldms_updateProfile")->with('message', 'Perfil actualizado con éxito');
        } else {
            redirect("document/ldms_updateProfile")->with('message1', 'No se pudo actualizar el perfil, inténtalo de nuevo.');
        }
    }

    public function ldmsChangePassword()
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        
        $userID = $_POST["id"];
        $oldPassword = $_POST['ldms_old_password'];
        $allData = DB::table('users')->where('id', $userID)->get();
        if (Hash::check($oldPassword, $allData[0]->password)) {
            if ($_POST['ldms_new_password']==$_POST['ldms_confirm_password']) {
                $status = DB::table('users')
                ->where('id', $userID)
                ->update(['password' => bcrypt($_POST["ldms_new_password"])]);
                if (isset($status)) {
                    return redirect("document/ldms_updateProfile")->with('message', 'Contraseña cambiada con éxito');
                }
            } else {
                return redirect("document/ldms_updateProfile")->with('message1', "Nueva contraseña y Confirmar contraseña no coinciden");
            }
        } else {
            return redirect("document/ldms_updateProfile")->with('message1', "La contraseña actual no coincide");
        }
    }

    public function ldmsEmailSend()
    {
        $todayDate = date('Y-m-d');
        $ldms_alarm_sending_info = DB::table('documents')
                ->select('title', 'expired_date', 'email', 'mobile')
                ->where('alarm', 'like', '%'.$todayDate.'%')
                ->get();
        $ldms_general_setting_data = \App\GeneralSetting::latest()->first();

        foreach ($ldms_alarm_sending_info as $ldms_alarm_sending_info_single) {
            if($ldms_general_setting_data->notify_by == 'email') {
                
                $mails_in_arrays = explode( ',' ,  $ldms_alarm_sending_info_single->email);  
                 $count = 0;
                
                

                
                
                
                foreach( $mails_in_arrays as $ldms_alarm_sending_info_single->email )
                {
                     $count++;
                     
                                     $data['email'] = $ldms_alarm_sending_info_single->email;
                $data['document_name'] = $ldms_alarm_sending_info_single->title;
                $data['document_exp'] = $ldms_alarm_sending_info_single->expired_date;

                Mail::send( 'mail.expiration', $data, function( $message ) use ($data)
                {
                    $message->to( $data['email'] )->subject( 'Su ' .$data['document_name']. ' fecha de vencimiento: ' .$data['document_exp'] );
                });
                
                
                }
                
                
            }
            
            
            
            
            elseif($ldms_alarm_sending_info_single->mobile) {
                
           if( env('SMS_GATEWAY') == 'twilio') {
           
           $numbers_in_arrays = explode( ',' ,  $ldms_alarm_sending_info_single->mobile);
           
            $count = 0;
           
                    $account_sid = env('ACCOUNT_SID');
                    $auth_token = env('AUTH_TOKEN');
                    $twilio_phone_number = env('Twilio_Number');
     
                    try{
                        
                       $client = new Client($account_sid, $auth_token);
                   
                                       
                    
       foreach( $numbers_in_arrays as $ldms_alarm_sending_info_single->mobile )
           {        
                $count++;
                   
                        $client->messages->create(
                            $ldms_alarm_sending_info_single->mobile,
                            array(
                                "from" => $twilio_phone_number,
                                "body" => 'Titulo del documento : '.$ldms_alarm_sending_info_single->title.'. Fecha de vencimiento: '.$ldms_alarm_sending_info_single->expired_date
                            )
                        );
                        
                        
           }         
                        
                        
                    }
                
                    
                    catch(\Exception $e){
                        $message = 'Usuario creado con éxito. Configure su configuración de SMS para enviar SMS';
                    }
                }
                
                
                elseif( env('SMS_GATEWAY') == 'clickatell') {
                    try {
                        $clickatell = new \Clickatell\Rest(env('CLICKATELL_API_KEY'));
                        $result = $clickatell->sendMessage(['to' => [$ldms_alarm_sending_info_single->mobile], 'content' => 'Document Title : '.$ldms_alarm_sending_info_single->title.'. Expired Date : '.$ldms_alarm_sending_info_single->expired_date]);
                    } 
                    catch (ClickatellException $e) {
                        $message = 'Usuario creado con éxito. Configure su configuración de SMS para enviar SMS';
                    }
                }
            }
        }
    }
}
