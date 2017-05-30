<?php

namespace AoContacts\Models;

use Illuminate\Database\Eloquent\Model;

class EmailType extends Model
{

    //------------------------------------------------------------------------------------------------------------------
    // ATTRIBUTES
    //------------------------------------------------------------------------------------------------------------------

    protected $table = 'ao_contacts_email_types';

    //------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return Email[]|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::class, 'type_id');
    }

}