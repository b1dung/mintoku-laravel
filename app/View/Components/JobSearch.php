<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Location;
use App\Models\JobCategory;

class JobSearch extends Component
{
    public $categories;
    public $locations;
    public $structuredLocations;

    public function __construct()
    {
        $this->categories = JobCategory::where('active', 1)->get();

        $parentLocs = Location::where("show", 1)
            ->where("parent_id", 0)
            ->get();

        $this->locations = $parentLocs;

        $structured = [];
        foreach ($parentLocs as $parent) {
            $structured[$parent->id] = Location::where('parent_id', $parent->id)
                ->where('show', 1)
                ->get()
                ->map(function ($child) {
                    return ['id' => $child->id, 'name' => $child->name];
                })
                ->values();
        }

        $this->structuredLocations = $structured;
    }

    public function render(): View|Closure|string
    {
        return view('components.job-search');
    }
}
