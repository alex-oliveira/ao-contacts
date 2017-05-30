<?php

namespace AoContacts\Models;

use AoComments\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    //------------------------------------------------------------------------------------------------------------------
    // DYNAMIC
    //------------------------------------------------------------------------------------------------------------------

    public $dynamicClass;

    public $dynamicTable;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dynamicWith()
    {
        return $this->belongsToMany($this->dynamicClass, $this->dynamicTable);
    }

    //------------------------------------------------------------------------------------------------------------------
    // ATTRIBUTES
    //------------------------------------------------------------------------------------------------------------------

    protected $table = 'ao_contacts_contacts';

    protected $fillable = ['name', 'image', 'activity', 'site'];

    //------------------------------------------------------------------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------------------------------------------------------------------

    /**
     * @return Phone[]|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * @return Email[]|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

}