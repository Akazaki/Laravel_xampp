<?php

namespace Laravel\Http\Controllers;

use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

use Laravel\Http\Requests\ContactRequest;
use Intervention\Image\Facades\Image;

class FileupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContactRequest $request)
    {
        //if(!empty($contact['upfile'])){
//     //getClientOriginalName():アップロードしたファイルのオリジナル名を取得します
//     $upfile = str_shuffle(time().$contact['upfile']->getClientOriginalName()). '.' . $contact['upfile']->getClientOriginalExtension();
//     //$upfile =  $contact['upfile']->getClientOriginalName();
//     //getRealPath():アップロードしたファイルのパスを取得します。
//     $image = Image::make($contact['upfile']->getRealPath());
//     //画像を保存する
//     $image->save(public_path().'/tmpfile/'.$upfile);
//     //パス
//     $contact['img_path'] = '/public/tmpfile/'.$upfile;
// }else if(!empty($contact['img'])){
//     //パス
//     $contact['img_path'] = $contact['img'];
// }
        //
        return response()->json(['status' => 'successful']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
