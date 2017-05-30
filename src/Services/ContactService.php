<?php

namespace AoContacts\Services;

use AoContacts\Models\Contact;
use AoScrud\Services\ScrudService;

class ContactService extends ScrudService
{

    //------------------------------------------------------------------------------------------------------------------
    // DYNAMIC
    //------------------------------------------------------------------------------------------------------------------

    protected $dynamicClass;

    protected $dynamicTable;

    protected $dynamicForeign;

    public function setDynamicClass($dynamicClass)
    {
        $parts = explode('.', app()->make($dynamicClass)->contacts()->getQualifiedForeignKeyName());

        $this->dynamicClass = $dynamicClass;
        $this->dynamicTable = $parts[0];
        $this->dynamicForeign = $parts[1];

        return $this;
    }

    protected function applyDynamicFilter($config)
    {
        $model = $config->model();
        $model->dynamicClass = $this->dynamicClass;
        $model->dynamicTable = $this->dynamicTable;

        $id = $config->data()->get($this->dynamicForeign);

        if (!app()->make($this->dynamicClass)->find($id))
            abort(404);

        $config->model($model->whereHas('dynamicWith', function ($query) use ($id) {
            $query->where('id', $id);
        }));
    }

    //------------------------------------------------------------------------------------------------------------------
    // OWNER
    //------------------------------------------------------------------------------------------------------------------

    private $owner;

    protected function setOwner($config)
    {
        $this->owner = app()->make($this->dynamicClass)->find($config->data()->get($this->dynamicForeign));
        if (!$this->owner)
            abort(404);
    }

    //------------------------------------------------------------------------------------------------------------------
    // CONSTRUCTOR
    //------------------------------------------------------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // SEARCH //----------------------------------------------------------------------------------------------------
        $this->search
            ->model(Contact::class)
            ->columns(['id', 'name', 'activity'])
            ->otherColumns(['image', 'site', 'created_at', 'updated_at'])
            ->setAllOrders()
            ->with([
                'phones' => [
                    'columns' => ['number', 'branch'],
                    'otherColumns' => ['type_id', 'created_at', 'updated_at']
                ],
                'emails' => [
                    'columns' => ['email'],
                    'otherColumns' => ['type_id', 'created_at', 'updated_at']
                ]
            ])
            ->rules([
                'default' => '=',
                [
                    ['name' => '%like%|get:search'],
                    ['activity' => '%like%|get:search'],
                ]
            ])
            ->onPrepare(function ($config) {
                $this->applyDynamicFilter($config);

            });

        // READ //------------------------------------------------------------------------------------------------------
        $this->read
            ->model(Contact::class)
            ->columns($this->search->columns()->all())
            ->with($this->search->with()->all())
            ->otherColumns($this->search->otherColumns()->all())
            ->onPrepare(function ($config) {
                $this->applyDynamicFilter($config);
            });

        // CREATE //----------------------------------------------------------------------------------------------------
        $this->create
            ->model(Contact::class)
            ->columns(['name', 'image', 'activity', 'site'])
            ->rules([
                'name' => 'required|max:255',
                'image' => 'required|max:255',
                'activity' => 'required|max:255',
                'site' => 'required|max:255',
            ])->onPrepareEnd(function ($config) {
                $this->setOwner($config);
            })->onExecuteEnd(function ($config, $result) {
                $this->owner->contacts()->attach($result->id);
            });

        // UPDATE //----------------------------------------------------------------------------------------------------

        $this->update
            ->model(Contact::class)
            ->columns($this->create->columns()->all())
            ->rules($this->create->rules())
            ->onPrepare(function ($config) {
                $this->applyDynamicFilter($config);
            });

        // DESTROY //---------------------------------------------------------------------------------------------------

        $this->destroy
            ->model(Contact::class)
            ->title('contato')
            ->onPrepare(function ($config) {
                $this->applyDynamicFilter($config);
            })->onExecute(function ($config) {
                $this->setOwner($config);
                $this->owner->contacts()->detach($config->data()->get('id'));
            });

        // RESTORE //---------------------------------------------------------------------------------------------------

        $this->restore
            ->model(Contact::class)
            ->onPrepare(function ($config) {
                $this->applyDynamicFilter($config);
            });
    }

}