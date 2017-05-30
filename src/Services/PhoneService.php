<?php

namespace AoContacts\Services;

use AoContacts\Models\Phone;
use AoScrud\Services\ScrudService;

class PhoneService extends ScrudService
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
            ->model(Phone::class)
            ->columns(['contact_id', 'type_id', 'number', 'branch'])
            ->rules([
                'contact_id' => 'required|int|exists:sac_contacts,id',
                'type_id' => 'required|int|exists:sac_phone_types,id',
                'number' => 'required|max:50',
                'branch' => 'required|max:10'
            ]);

        // UPDATE //----------------------------------------------------------------------------------------------------

        $select = function ($config){
            $contact = $this->contactService->read(AoScrud()->params()->put('id', $config->data()->get('contact_id'))->all());
            return $config->model()->where('contact_id', $contact->id)->where('id', $config->data()->get('id'))->first();
        };

        $this->update
            ->model(Phone::class)
            ->select($select)
            ->columns($this->create->columns()->all())
            ->rules($this->create->rules()->all());

        // DESTROY //---------------------------------------------------------------------------------------------------

        $this->destroy
            ->model(Phone::class)
            ->select($select)
            ->title('telefone');
    }

}