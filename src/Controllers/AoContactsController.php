<?php

namespace AoContacts\Controllers;

use AoContacts\Services\ContactService;
use AoContacts\Services\EmailService;
use AoContacts\Services\PhoneService;
use AoScrud\Controllers\ScrudController;

class AoContactsController extends ScrudController
{

    //------------------------------------------------------------------------------------------------------------------
    // DYNAMIC
    //------------------------------------------------------------------------------------------------------------------

    protected $dynamicClass;

    public function getDynamicClass()
    {
        return $this->dynamicClass;
    }

    //------------------------------------------------------------------------------------------------------------------
    // CONSTRUCTOR
    //------------------------------------------------------------------------------------------------------------------

    public function __construct(ContactService $service)
    {
        $this->service = $service->setDynamicClass($this->dynamicClass);
    }

    //------------------------------------------------------------------------------------------------------------------
    // PHONES
    //------------------------------------------------------------------------------------------------------------------

    public function storePhone(PhoneService $phones)
    {
        $data = $phones->setContactService($this->service)->create(AoScrud()->params()->all());
        return response()->json($this->toArray($data), 201);
    }

    public function updatePhone(PhoneService $phones)
    {
        $updated = $phones->setContactService($this->service)->update(AoScrud()->params()->all());
        return response()->json([], ($updated ? 204 : 200));
    }

    public function destroyPhone(PhoneService $phones)
    {
        $phones->setContactService($this->service)->destroy(AoScrud()->params()->all());
        return response()->json([], 204);
    }

    //------------------------------------------------------------------------------------------------------------------
    // EMAILS
    //------------------------------------------------------------------------------------------------------------------

    public function storeEmail(EmailService $emails)
    {
        $data = $emails->setContactService($this->service)->create(AoScrud()->params()->all());
        return response()->json($this->toArray($data), 201);
    }

    public function updateEmail(EmailService $emails)
    {
        $updated = $emails->setContactService($this->service)->update(AoScrud()->params()->all());
        return response()->json([], ($updated ? 204 : 200));
    }

    public function destroyEmail(EmailService $emails)
    {
        $emails->setContactService($this->service)->destroy(AoScrud()->params()->all());
        return response()->json([], 204);
    }

}