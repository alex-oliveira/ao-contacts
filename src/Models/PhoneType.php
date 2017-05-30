<?php

namespace AoContacts\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneType extends Model
{

    //------------------------------------------------------------------------------------------------------------------
    // ATTRIBUTES
    //------------------------------------------------------------------------------------------------------------------

    protected $table = 'ao_contacts_phone_types';

    //------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return Phone[]|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones()
    {
        return $this->hasMany(Phone::class, 'type_id');
    }

}