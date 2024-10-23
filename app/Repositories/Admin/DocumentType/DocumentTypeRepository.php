<?php

namespace App\Repositories\Admin\DocumentType;

use App\Models\GeneralSettings\DocumentType;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\JsonResponse;

class DocumentTypeRepository implements DocumentTypeRepositoryInterface
{

    // Importing Trait
    use RequestResponseFormatTrait;
    public function getDocumentTypeList(): JsonResponse
    {
        try {

            $docTypes = DocumentType::all();

            if (!$docTypes) return $this->error('No existen TIPOS de DOCUMENTOS registrados', 204, []);

            return $this->success($docTypes, count($docTypes), 'Tipos de documentos RETORNADOS', 200);

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500, []);
        }
    }
}
