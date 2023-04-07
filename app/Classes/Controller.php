<?php

namespace App\Classes;

use Session;
use App\Classes\Utility;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $_responseFormat = 'json';
    protected $modelObj;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $res  = $this->modelObj->_index($request);
        $view = $this->modelObj->_getView('index');

        return $this->_response($res['data'], $res['message'], $view);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = $this->modelObj->_getView('create');

        return view($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result    = $this->modelObj->_storeOrUpdate($request);
        $routeName = $this->modelObj->_getRouteName('index');

        if ($this->_responseFormat === 'view') {
            Session::flash('message', $result['message']);
            return redirect()->route($routeName)->with('success', $result);
        } else {
            return $this->_response($result['data'], $result['message']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->modelObj->_show($id);
        $view   = $this->modelObj->_getView('show');

        return $this->_response($result['data'], $result['message'], $view);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $result = $this->modelObj->_show($id);
        $view   = $this->modelObj->_getView('edit');

        return view($view, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $result    = $this->modelObj->_storeOrUpdate($request, $id, 'update');
        $routeName = $this->modelObj->_getRouteName('index');

        if ($this->_responseFormat === 'view') {
            Session::flash('message', $result['message']);
            return back()->with('success', $result);
        } else {
            return $this->_response($result['data'], $result['message']);
        }
    }

    // response function
    public function _response($data = null, $message = null, $view = '', $code = 200)
    {
        $type = $this->_responseFormat;
        $utility = new Utility();

        return $utility->sendResponse($data, $message, $type, $view, $code);
    }
}
