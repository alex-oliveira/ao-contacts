<?php

namespace AoContacts\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

    //------------------------------------------------------------------------------------------------------------------
    // ATTRIBUTES
    //------------------------------------------------------------------------------------------------------------------

    protected $table = 'ao_contacts_phones';

    protected $fillable = ['contact_id', 'type_id', 'number', 'branch'];

    //------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return PhoneType|\Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(PhoneType::class, 'type_id');
    }

    /**
     * @return Contact|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

}