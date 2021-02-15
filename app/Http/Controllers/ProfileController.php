<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return view('profile.index');
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
        // $user_id = AuthenticatesUsers::->user->id();
        
        $data = User::find($id);
        $data_post = FacadesDB::table('users')
            ->join('posts', 'users.id', '=', 'posts.user_id')
            ->select('posts.*')
            ->orderBy('posts.id', 'desc')
            ->get();
        $data_edit = null;
 
        return view('profile.show', compact('data', 'data_post','data_edit'));
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
        // $data_edit = Post::find('id' , $post);
        $data_edit = FacadesDB::table('posts')
            ->select('*')->where('id', '=', $id)
            ->get();

        return  view('profile.show', compact('data_edit'));
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

        $data = $request->all();

        if ($request->file()) {
            $type_file = $request->file('profile_image')->getClientOriginalExtension();
            $filename = md5($request->file('profile_image')->getClientOriginalName() . time()) . '.' . $type_file;

            $request->file('profile_image')->storeAs('profile', $filename, 'public');
            $this->deleteOldImage();
            // ลบ path public เอาไปใช้เรียกรูปตอนดึงค่าจาก DB
            $data['profile_image'] = $filename;
        }

        $data['birth_day'] = Carbon::createFromFormat('d/m/Y', $request->birth_day)->format('Y-m-d');

        User::find($id)->update($data);
        return redirect()->back();
    }

    protected function deleteOldImage()
    {
        if (auth()->user()->profile_image) {
            Storage::delete('/public/profile/' . auth()->user()->profile_image);
        }
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
