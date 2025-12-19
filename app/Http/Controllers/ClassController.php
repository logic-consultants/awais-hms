<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassModel;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = ClassModel::where('school_id',schoolId())->orderBy('id', 'DESC')->get();
        return view('backend.classes.class-add',compact('classes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'class_name' => 'required|string|max:191',
        ]);

        $class = new ClassModel();

        $class->class_name = $request->class_name;
        $class->school_id = schoolId();

        $class->save();

        return redirect('class')->with('success', _lang('Information has been added'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'class'=>ClassModel::find($id),
            'classes'=>ClassModel::where('school_id',schoolId())->orderBy('id', 'DESC')->get(),
        ];
        if ($data['class']->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        return view('backend.classes.class-edit' ,$data);
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
        $this->validate($request, [
            'class_name' => 'required|string|max:191',
        ]);

        $class = ClassModel::find($id);
        if ($class->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $class->class_name = $request->class_name;

        $class->save();

        return redirect('class')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = ClassModel::find($id);
        if ($class->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $class->delete();

        return redirect('class')->with('success', _lang('Information has been deleted'));
    }
}
