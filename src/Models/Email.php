<?php

namespace AoContacts\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

    //------------------------------------------------------------------------------------------------------------------
    // ATTRIBUTES
    //------------------------------------------------------------------------------------------------------------------

    protected $table = 'ao_contacts_emails';

    protected $fillable = ['contact_id', 'type_id', 'email'];

    //------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return EmailType|\Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(EmailType::class, 'type_id');
    }

    /**
     * @return Contact|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

}