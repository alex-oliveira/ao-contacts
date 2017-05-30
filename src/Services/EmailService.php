<?php

namespace AoContacts\Services;

use AoContacts\Models\Email;
use AoScrud\Services\ScrudService;

class EmailService extends ScrudService
{

    //------------------------------------------------------------------------------------------------------------------
    // CONTACT
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @var ContactService
     */
    protected $contactService;

    /**
     * @return ContactService;
     */
    public function getContactService()
    {
        return $this->contactService;
    }

    /**
     * @param $contactService ContactService
     * @return $this;
     */
    public function setContactService($contactService)
    {
        $this->contactService = $contactService;
        return $this;
    }

    //------------------------------------------------------------------------------------------------------------------
    // CONSTRUCTOR
    //------------------------------------------------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // CREATE //----------------------------------------------------------------------------------------------------
        $this->create
            ->model(Email::class)
            ->columns(['contact_id','type_id', 'email'])
            ->rules([
                'contact_id' => 'required|int|exists:sac_contacts,id',
                'type_id' => 'required|int|exists:sac_email_types,id',
                'email' => 'required|email|max:50',
            ]);

        // UPDATE //----------------------------------------------------------------------------------------------------

        $select = function ($config){
            $contact = $this->contactService->read(AoScrud()->params()->put('id', $config->data()->get('contact_id'))->all());
            return $config->model()->where('contact_id', $contact->id)->where('id', $config->data()->get('id'))->first();
        };

        $this->update
            ->model(Email::class)
            ->select($select)
            ->columns($this->create->columns()->all())
            ->rules($this->create->rules()->all());

        // DESTROY //---------------------------------------------------------------------------------------------------

        $this->destroy
            ->model(Email::class)
            ->select($select)
            ->title('email');
    }

}