<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Location;
use App\Models\Visa;
use App\Models\JobCategory;
use App\Models\TypeJob;
use App\Models\Experience;
use App\Models\Language;
use App\Models\JobLabel;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobTable = (new Job())->getTable();

        $query = Job::with(['company', 'locations', 'categories', 'visas', 'labels', 'typeJobs'])
            ->where("{$jobTable}.active", true);

        if ($request->filled('s') && trim($request->s) !== '') {
            $search = trim($request->s);
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('locations') && !empty($request->input('locations'))) {
            $locIds = array_filter((array) $request->input('locations'), fn($v) => !is_null($v) && $v !== '');
            if (!empty($locIds)) {
                $query->whereHas('locations', function ($q) use ($locIds) {
                    $q->whereIn('locations.id', $locIds);
                });
            }
        }

        if ($request->has('visa') && !empty($request->input('visa'))) {
            $visaIds = array_filter((array) $request->input('visa'), fn($v) => !is_null($v) && $v !== '');
            if (!empty($visaIds)) {
                $query->whereHas('visas', function ($q) use ($visaIds) {
                    $q->whereIn('visas.id', $visaIds);
                });
            }
        }

        if ($request->has('categories') && !empty($request->input('categories'))) {
            $catIds = array_filter((array) $request->input('categories'), fn($v) => !is_null($v) && $v !== '');
            if (!empty($catIds)) {
                $query->whereHas('categories', function ($q) use ($catIds) {
                    $q->whereIn('job_categories.id', $catIds);
                });
            }
        }

        if ($request->has('job_types') && !empty($request->input('job_types'))) {
            $typeIds = array_filter((array) $request->input('job_types'), fn($v) => !is_null($v) && $v !== '');
            if (!empty($typeIds)) {
                $query->whereHas('typeJobs', function ($q) use ($typeIds) {
                    $q->whereIn('type_jobs.id', $typeIds);
                });
            }
        }

        if ($request->has('experiences') && !empty($request->input('experiences'))) {
            $expIds = array_filter((array) $request->input('experiences'), fn($v) => !is_null($v) && $v !== '');
            if (!empty($expIds)) {
                $query->whereHas('experiences', function ($q) use ($expIds) {
                    $q->whereIn('experiences.id', $expIds);
                });
            }
        }

        if ($request->has('languages') && !empty($request->input('languages'))) {
            $langIds = array_filter((array) $request->input('languages'), fn($v) => !is_null($v) && $v !== '');
            if (!empty($langIds)) {
                $query->whereHas('languages', function ($q) use ($langIds) {
                    $q->whereIn('languages.id', $langIds);
                });
            }
        }

        if ($request->has('labels') && !empty($request->input('labels'))) {
            $labelIds = array_filter((array) $request->input('labels'), fn($v) => !is_null($v) && $v !== '');
            if (!empty($labelIds)) {
                $query->whereHas('labels', function ($q) use ($labelIds) {
                    $q->whereIn('job_label_pivot.label_id', $labelIds);
                });
            }
        }

        if ($request->filled('unit_salary') && trim($request->unit_salary) !== '') {
            $unit = trim($request->unit_salary);
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(extra_attributes, '$.unit_salary')) = ?", [$unit]);
        }

        if ($request->filled('salaries') && !empty($request->input('salaries'))) {
            $ranges = array_filter((array) $request->input('salaries'), fn($v) => trim($v) !== '' && str_contains($v, '-'));
            
            if (!empty($ranges)) {
                $query->where(function ($q) use ($ranges) {
                    foreach ($ranges as $range) {
                        [$min, $max] = array_map('intval', explode('-', $range));
                        if ($min > $max) {
                            [$min, $max] = [$max, $min];
                        }
                        $q->orWhereRaw(
                            "CAST(JSON_UNQUOTE(JSON_EXTRACT(extra_attributes, '$.salary_by_month')) AS UNSIGNED) BETWEEN ? AND ?",
                            [$min, $max]
                        );
                    }
                });
            }
        }

        $locations   = Location::where('parent_id', 0)->where('show', 1)->get();
        $visas       = Visa::all();
        $categories  = JobCategory::whereNull('parent_id')->orWhere('parent_id', 0)
            ->with('children')
            ->orderBy("name", "ASC")
            ->get();
        $typeJobs    = TypeJob::all();
        $experiences = Experience::all();
        $languages   = Language::all();
        $jobLabels   = JobLabel::all();

        $rangeSalary = collect();
        if ($request->filled('unit_salary') && trim($request->unit_salary) !== '') {
            $currentUnit = trim($request->unit_salary);

            $allSalaries = Job::where('active', true)
                ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(extra_attributes, '$.unit_salary')) = ?", [$currentUnit])
                ->pluck('extra_attributes')
                ->map(fn($attr) => isset($attr['salary_by_month']) ? (int)$attr['salary_by_month'] : null)
                ->filter()
                ->unique();

            if ($allSalaries->isNotEmpty()) {
                $minVal = $allSalaries->min();
                $maxVal = $allSalaries->max();
                $unitLabel = strtoupper($currentUnit);

                if ($minVal === $maxVal) {
                    $rangeSalary->push([
                        'value' => "$minVal-$maxVal",
                        'label' => number_format($minVal) . " $unitLabel",
                        'sort'  => $minVal
                    ]);
                } else {
                    $stepCount = 8;
                    $stepSize = ceil(($maxVal - $minVal) / $stepCount) ?: 1;

                    for ($i = 0; $i < $stepCount; $i++) {
                        $currentMin = $minVal + ($i * $stepSize);
                        $currentMax = ($i === $stepCount - 1) ? $maxVal : ($currentMin + $stepSize - 1);

                        if ($currentMin > $maxVal) break;

                        $rangeSalary->push([
                            'value' => "$currentMin-$currentMax",
                            'label' => number_format($currentMin) . " - " . number_format($currentMax) . " $unitLabel",
                            'sort'  => $currentMin
                        ]);
                    }
                }
                $rangeSalary = $rangeSalary->sortByDesc('sort')->values();
            }
        }

        $jobs = $query->orderBy('ord', 'asc')
            ->orderBy('id', 'desc')
            ->paginate($request->input('perpage', 10))
            ->withQueryString();

        $searchTitle = $this->buildSearchTitle($request);
        $seoData = new SEOData(title: $searchTitle);

        return view('jobs.index', compact(
            'jobs',
            'searchTitle',
            'locations',
            'visas',
            'typeJobs',
            'experiences',
            'categories',
            'languages',
            'jobLabels',
            'rangeSalary',
            'seoData'
        ));
    }

    private function buildSearchTitle(Request $request)
    {
        $title = 'Tìm kiếm việc làm';
        if ($request->filled('s')) {
            $title .= ' cho "' . $request->s . '"';
        }
        return $title . ' | Mintoku Work';
    }

    public function show($slug)
    {
        $job = Job::with(['company', 'locations', 'categories', 'experiences', 'visas', 'labels'])
            ->where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $relatedJobs = Job::getRelated($job->id, 4);

        $seoData = new SEOData(
            title: $job->title,
            description: strip_tags(Str::limit($job->description, 160)),
        );

        return view('jobs.show', compact('job', 'relatedJobs', 'seoData'));
    }
}
