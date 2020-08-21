<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Responses\GenericResponse;
use App\Http\Requests\ContactRequest;
use App\Repositories\ContactRepository;

class ContactController extends Controller
{
    
    public function __construct()
    {
        $this->contactRepository = new ContactRepository();
    }
    
    public function store(ContactRequest $request) {
        $response = $this->contactRepository->store($request);
        return GenericResponse::response($response);
    }
}
