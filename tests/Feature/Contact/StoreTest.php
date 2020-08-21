<?php

namespace Tests\Feature\Contact;

use Tests\TestCase;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class StoreTest extends TestCase
{

    private function storeContactThroughTheApi(Contact $contact = null) {
        $contact = $contact ?? collect([]);
        return $this->postJson(route('contacts.store'), $contact->toArray());
    }

    private function checkContactDatabaseHas($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseHas('contacts', $item);
    }

    private function checkContactDatabaseMissing($item, $merged) {
        $item = array_merge($item->toArray(), $merged);
        $this->assertDatabaseMissing('contacts', $item);
    }

    private function unitInputApi($input, $meta = null) {
        Carbon::setTestNow(now());


        $merge = [];

        $merge[$input] = $meta;
        if ($meta) {
            $meta = explode(':', $meta);
            if ($meta[0] == 'max') {
                if ($input == 'file') {
                    $merge[$input] = ['type' => 'max', 'size' => $meta[1]];
                } else {
                    $merge[$input] = Str::random($meta[1]+1);
                }
            } else if ($meta[0] == 'exists') {
                $meta[1] = explode(',', $meta[1]);
                return $this->assertDatabaseMissing($meta[1][0], [$meta[1][1] => '']);
            } else if ($meta[0] == 'unique') {
                $contact = factory(Contact::class)->create();
                $merge = [$input => $contact->email];
            } else if ($meta[0] == 'mimes') {
                if ($input == 'file') {
                    $merge[$input] = ['type' => 'mime', 'extension' => $meta[1]];
                }
            }
        }

        $contact = factory(Contact::class)->make($merge);

        $this->storeContactThroughTheApi($contact, $merge)
        ->assertStatus(422);
        
        $merge['created_at'] = now(); 
        $merge['updated_at'] = now();
        $this->checkContactDatabaseMissing($contact, $merge);
    }

    /** @test */
    public function it_should_store_in_database() {
        Carbon::setTestNow(now());

        $contact = factory(Contact::class)->make();

        $store = $this->storeContactThroughTheApi($contact);
        $path = storage_path('app/'.$store->json()['data']['file']);
        unlink($path);
        $store->assertSuccessful();
        $contact->file = $store->json()['data']['file'];
        $this->checkContactDatabaseHas($contact, ['created_at' => now(), 'updated_at' => now()]);
    }
    
    /** @test */
    public function name_input_field_is_required() {
        $this->unitInputApi('name');
    }

    /** @test */
    public function email_input_field_is_required() {
        $this->unitInputApi('email');
    }

    /** @test */
    public function email_input_field_is_email() {
        $this->unitInputApi('email', 'string');
    }

    /** @test */
    public function message_input_field_is_required() {
        $this->unitInputApi('message');
    }

    /** @test */
    public function file_input_field_is_required() {
        $this->unitInputApi('file');
    }

    /** @test */
    public function file_input_field_is_file() {
        $this->unitInputApi('file', 'string');
    }


    /** @test */
    public function file_input_field_is_max_500() {
        $this->unitInputApi('file', 'max:500');
    }

     /** @test */
     public function file_input_field_is_support_mimes() {
        $this->unitInputApi('file', 'mimes:xls');
    }
}
