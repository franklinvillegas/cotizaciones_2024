<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;

class DocumentoController extends Controller
{
    protected $rutaDocumento = 'Documentos';
    //
    public function listar(){
        $lista = Documento::select();
        return $lista->get();
    }

    public function verDocumento(Request $request){      
        $documento = $request->documento;
        // $doczip=$this->rutaDocumento.$request->documento.".zip";

        try {
            // $zip = new ZipArchive();
            // if($zip->open($doczip)==true){
            // $zip->setPassword($documento);
            // $zip->extractTo($this->rutaDocumento);    
            // $zip->close();
            // }
            return response()->json(['ruta' =>$this->rutaDocumento ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Tuvimos un problema inténtelo denuevo más tarde']);
        }
    }
}
