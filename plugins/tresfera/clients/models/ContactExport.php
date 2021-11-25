<?php namespace Tresfera\Clients\Models;

use Model;

/**
 * contact Model
 */
class ContactExport extends \Backend\Models\ExportModel
{    
	public function exportData($columns, $sessionKey = null)
    {
        $contacts = Contact::all();
        $contacts->each(function($contact) use ($columns) {
            $contact->addVisible($columns);
        });
        return $contacts->toArray();
    }
}