<?php

namespace Laravel\Http\Controllers;

use Illuminate\Http\Request;
 
use Laravel\Http\Requests;
use Laravel\Http\Controllers\Controller;

use Laravel\Http\Requests\FileupRequest;
use Intervention\Image\Facades\Image;

class FileupController extends Controller
{
    function __construct(){
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $request->validate([
            'body' => 'required',
            'image' => 'image|max:3',
        ]);

        $messages = [
            'image'    => 'The :attribute and :other must match.'
        ];

        //$validator = Validator::make($input, $rules, $messages);

        // $rules = [
        //     'image' => 'image|max:3000',
        // ];
        // //バリデーションされているファイルは (jpeg, png, bmp, gif, or svg)にしないといけません。
        // //3000Kb以下のファイルにする必要です。

        // // バリデーターにルールとインプットを入れる
        // $validation = Validator::make($request, $rules);

        // バリデーションチェックを行う
        // if ($validation->fails()) {
        //     return redirect('/')->with('message', 'ファイルを確認してください！');
        // }
        $file = $request->file('image');

        $reasult = [];
        if(!empty($request->file('image'))){
            //getClientOriginalName():アップロードしたファイルのオリジナル名を取得します
            $upfile = str_shuffle(time().$request->file('image')->getClientOriginalName()). '.' . $request->file('image')->getClientOriginalExtension();
            //$upfile =  $request->file('image')->getClientOriginalName();
            //getRealPath():アップロードしたファイルのパスを取得します。
            $image = Image::make($request->file('image')->getRealPath());
            //画像を保存する
            $image->save(public_path().'/tmpfile/'.$upfile);
            //パス
            $reasult['img_path'] = '/public/tmpfile/'.$upfile;
        }

        //
        return response()->json($reasult);
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
