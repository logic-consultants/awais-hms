<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Section;
use App\ClassModel;
use App\User;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class = "")
    {
        $sections = array();
        if ($class != "") {
            $sections = Section::select('*', 'sections.id AS id')
                ->join('classes', 'classes.id', '=', 'sections.class_id')
                ->where('sections.class_id', $class)
                ->where('sections.school_id', schoolId())
                ->orderBy('sections.rank', 'ASC')
                ->get();
        } else {
            $sections = Section::select('*', 'sections.id AS id')
                ->join('classes', 'classes.id', '=', 'sections.class_id')
                ->where('sections.school_id', schoolId())
                ->orderBy('sections.rank', 'ASC')
                ->get();
        }
        return view('backend.sections.section-add', compact('sections', 'class'));
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
            'section_name' => 'required|string|max:191',
            'class_id' => 'required',
            'capacity' => 'required|numeric',
            'room_rent' => 'required'
        ]);

        if (checkSchoolId('classes', $request->class_id) != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }

        $section = new Section();
        $section->section_name = $request->section_name;
        $section->school_id = schoolId();
        $section->class_id = $request->class_id;
        $section->capacity = $request->capacity;
        $section->room_no = $request->room_no;
        $section->room_rent = $request->room_rent;
        $section->save();
        return redirect('sections')->with('success', _lang('Information has been added'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_section(Request $request)
    {
        // Capture the Class ID (Floor ID) sent from your JS
        $class_id = $request->input('class_id');
        $school_id = schoolId(); // Assuming you use this helper function

        // Start building the query
        $query = Section::where('school_id', $school_id);

        // CRITICAL FIX: Only filter by class_id if it is present and NOT 'all'
        if ($class_id && $class_id != 'all') {
            $query->where('class_id', $class_id);
        }

        $sections = $query->get();

        // Build the HTML Options for the dropdown
        $options = '<option value="all">' . _lang('All Room') . '</option>';
        foreach ($sections as $section) {
            $options .= '<option value="' . $section->id . '">' . $section->section_name . '</option>';
        }

        return $options;
    }
    public function get_all_section(Request $request)
    {
        // dd($request);
        $results = Section::get();
        // dd($results);
        $sections = '';

        $sections = '<option value="all">Select All</option>';

        foreach ($results as $data) {
            $sections .= <<<HTML
<option value="{$data->id}">{$data->section_name}</option>
HTML;
        }

        // dd($sections);
        return $sections;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $section = Section::select('*', 'sections.id AS id')
            ->join('classes', 'classes.id', '=', 'sections.class_id')
            ->where('sections.id', $id)
            ->first();
        if ($section->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }
        return view('backend.sections.section-edit', compact('section'));
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
            'section_name' => 'required|string|max:191',
            'class_id' => 'required',
            'capacity' => 'required|numeric',
            'room_rent' => 'required|numeric'
        ]);

        if (checkSchoolId('classes', $request->class_id) != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }

        $section = Section::find($id);
        if ($section->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }

        $section->section_name = $request->section_name;
        $section->class_id = $request->class_id;
        $section->room_no = $request->room_no;
        $section->capacity = $request->capacity;
        $section->room_rent = $request->room_rent;
        $section->save();
        return redirect('sections')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);
        if ($section->school_id != schoolId()) {
            return redirect()->back()->with('error', 'access denied');
        }
        $section->delete();
        return redirect('sections')->with('success', _lang('Information has been deleted'));
    }
}
