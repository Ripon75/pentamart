<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    protected $_messages = [];
    protected $_className = '';
    protected $_columns = [];
    protected $_with = [];
    protected $_defaultWith = [];
    protected $_maxPaginateLimit = 2000;

    protected $searchable = [];
    protected $fillable = [];
    protected $casts = [];

    // All view templates
    protected $_views = [
        'index'  => '',
        'create' => '',
        'edit'   => '',
        'show'   => ''
    ];

    // All routes
    protected $_routeNames = [
        'index'  => '',
        'create' => '',
        'edit'   => '',
        'show'   => ''
    ];

    function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    // protected static function newFactory() { }

    /**
     * Covert & set slug as a string slug :).
     *
     * @param  string  $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    // =====================================================================================================
    // All custom functions
    // =====================================================================================================
    protected function _init()
    {
        $className = $this->_className ? $this->_className : 'Unknown';
        $this->_maxPaginateLimit = $this->_maxPaginateLimit ? $this->_maxPaginateLimit : config('crud.paginate.max');

        $this->_messages = [
            'index'         => "{$className} list",
            'store'         => "{$className} create successfully",
            'update'        => "{$className} update successfully",
            'single'        => "{$className} single view",
            'not_found'     => "{$className} not found",
            'failed_store'  => "{$className} not create successfully",
            'failed_update' => "{$className} not update successfully",
            'exist'         => "{$className} value exist",
            'enum'          => "{$className} data found"
        ];

        $this->_initModelProperties();
    }

    protected function _initModelProperties()
    {
        foreach ($this->_columns as $col => $meta) {
            if (array_key_exists('fillable', $meta)) {
                if ($meta['fillable']) {
                   return $this->fillable[] = $col;
                }
            }

            if (array_key_exists('cast', $meta)) {
                $this->casts[$col] = $meta['cast'];
            }
        }
    }

    /**
     * Method _index
     *
     * @param $paginate $paginate [explicite description]
     *
     * @return response
     */
    public function _index($request, $resource = false)
    {
        $paginate = $request->input('paginate');
        $paginate = $this->_checkPaginate($paginate);
        $data     = $this->orderBy('id', 'desc')->paginate($paginate);

        if ($resource) {
            $data = $this->_makeResourceCollection($data);
        }
        $msg = $this->_getMessage('index');

        return $this->_makeResponse(true, $data, $msg);
    }

    public function _show($id, $resource = false)
    {
        $data = $this->with($this->_defaultWith)->find($id);
        if(!$data) {
            $msg = $this->_getMessage('not_found');

            return $this->_makeResponse(false, null, $msg);
        }
        if ($resource) {
            $data = $this->_makeResource($data);
        }
        $msg = $this->_getMessage('single');

        return $this->_makeResponse(true, $data, $msg);
    }

    /**
     * Method _storeOrUpdate for store or update a model
     *
     * @param $request $request [the http request]
     * @param $id $id [if $action is 'update', the $id is required]
     * @param $action $action [is 'store' or 'update']
     *
     * @return response
     */
    public function _storeOrUpdate($request, $id = 0, $action = 'store') {}

    /**
     * Check is data exist by a value in a column
     *
     * @param [type] $request
     * @return void
     */
    public function _exist($request)
    {
        $request->validate([
            'column'   => ['required', 'string'],
            'value'    => ['required'],
            'opration' => [Rule::in(['=', 'like', '>', '<', '<>'])]
        ]);

        $column   = $request->input('column');
        $value    = $request->input('value');
        $opration = $request->input('opration', '=');

        $data = $this->where($column, $opration, $value)->get();
        $msg = $this->_getMessage('exist');

        return $this->_makeResponse(true, $data, $msg);
    }

    public function _enum($request)
    {
        $request->validate([
            'label_column'    => ['required'],
            'value_column'    => ['string'],
            'order_by_column' => ['string'],
            'order'           => [Rule::in(['asc', 'desc'])],
            'take'            => ['integer'],
            'search_query'    => ['string'],
            'opration'        => [Rule::in(['=', 'like', '>', '<', '<>'])]
        ]);

        $labelColumn   = $request->input('label_column');
        $valueColumn   = $request->input('value_column', 'id');
        $orderByColumn = $request->input('order_by_column', $labelColumn);
        $order         = $request->input('order', 'asc');
        $take          = $request->input('take', 20);
        $searchQuery   = $request->input('search_query', null);
        $opration      = $request->input('opration', 'like');

        $obj = $this->select([
            "{$labelColumn} as label",
            "{$valueColumn} as value"
        ]);

        if ($searchQuery) {
            $obj = $obj->where($labelColumn, $opration, $searchQuery);
        }

        $data = $obj->orderBy($orderByColumn, $order)->take(20)->get();
        $msg = $this->_getMessage('enum');

        return $this->_makeResponse(true, $data, $msg);
    }


    // response
    public function _makeResponse($res, $data, $msg)
    {
        return [
            'res'     => $res,
            'data'    => $data,
            'message' => $msg
        ];
    }

    public function _getMessage($key)
    {
        return $this->_messages[$key];
    }

    public function _getView($key)
    {
        return $this->_views[$key];
    }

    public function _getRouteName($key)
    {
        return $this->_routeNames[$key];
    }

    public function _getImageUploadPath()
    {
        $now = Carbon::now();
        return "images/{$this->table}/{$now->year}/{$now->month}";
    }

    public function _checkPaginate($paginate)
    {
        if ($paginate) {
            return $paginate > $this->_maxPaginateLimit ? $this->_maxPaginateLimit : $paginate;
        } else {
            return config('crud.paginate.default');
        }
    }
}
