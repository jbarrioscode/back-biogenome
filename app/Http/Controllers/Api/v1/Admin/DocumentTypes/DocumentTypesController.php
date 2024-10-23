<?php

namespace App\Http\Controllers\Api\v1\Admin\DocumentTypes;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\DocumentType\DocumentTypeRepositoryInterface;
use Illuminate\Http\Request;

class DocumentTypesController extends Controller
{
    //
    protected DocumentTypeRepositoryInterface $documentTypeRepository;

    public function __construct(DocumentTypeRepositoryInterface $documentTypeRepository)
    {
        $this->documentTypeRepository = $documentTypeRepository;
    }

    public function getDocumentTypeRepository()
    {
        try {

            return $this->documentTypeRepository->getDocumentTypeList();

        } catch (\Throwable $th) {
            return $th;
        }
    }

}
