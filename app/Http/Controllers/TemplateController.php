<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $filter = [
            'search_key' => $request->search_key,
            'search_value' => $request->search_value,
        ];

        $templates = Template::orderBy('templates.id', 'desc')
            ->when($filter['search_key'] && $filter['search_value'], function ($q) use ($filter) {
                if ($filter['search_key'] == 1) {
                    $q->where('id', $filter['search_value']);
                }
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($template) => [
                'id' => $template->id,
                'title' => $template->title,
                'updated_at' => dateFormat($template->updated_at),
            ]);
            
        return Inertia::render('Template/Index', [
            'templates' => $templates,
        ]);
    }

    public function save($request, $edit_mode = false)
    {        
        $rules = [
            'title' => 'required|string|min:3|max:50',
            'items' => 'required|array',
            'items.*.particular' => 'required|max:250',
            'items.*.amount' => 'required|numeric|gte:0',
            'items.*.qty' => 'required|numeric|gte:1',
        ];

        $validate = $request->validate($rules);

        $data = [
            'title' => $request->title,
            'particulars' => \json_encode($request->items),
        ];

        if ($request->template_id) {
            $user = Template::find($request->template_id);
            $user->update($data);
        } else {
            $user = Template::create($data);
        }
    }

    public function store(Request $request)
    {        
        // dd($request->all());

        $this->save($request);
        return redirect()->back()->with('success', 'Record created.');
    }

    public function update(Request $request)
    {
        $this->save($request, true);
        return redirect()->back()->with('success', 'Record updated.');
    }

    public function fetchParticulars($id){
        $template = Template::find($id);

        $data = [
            'particulars' => json_decode($template->particulars),
        ];

        return response()->json($data);
    }
}
