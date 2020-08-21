<?php

namespace App\Repositories;

use App\Models\Contact;
use Request;
class ContactRepository
{
    
    public function store($data) {
        try {
            \DB::beginTransaction();
            $path = null;

            if($data->hasFile('file')){ 
                $path = $data->file('file')->storeAs(
                    'contacts', time().'.'.$data->file('file')->getClientOriginalExtension()
                );

                $data->file = $path;
            }
            $data = $data->toArray();
            $data['file'] = $path;
            $data['ip_request'] = trim(shell_exec("dig +short myip.opendns.com @resolver1.opendns.com"));
            $contact = Contact::create($data);
            \DB::commit();

            return ['message' => $data, 'status' => 200];
        } catch (\Exception $e) {
            return ['message' => $e->getMessage(), 'status' => 500];
        }
    }
}
