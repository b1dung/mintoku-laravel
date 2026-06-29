<?php

namespace Mintoku\UserAuth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Visa;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserJobController extends Controller
{
    public function index()
    {
        $my_jobs = Auth::user()->jobs()->latest()->get();

        return view('user-auth::manage-jobs', [
            'my_jobs' => $my_jobs,
            'seoData' => new \RalphJSmit\Laravel\SEO\Support\SEOData(title: 'Quản lý tin tuyển dụng')
        ]);
    }

    public function create()
    {
        $categories  = \App\Models\JobCategory::where('parent_id', 0)->with('children.children')->get();
        $locations   = \App\Models\Location::where('parent_id', 0)->with('children.children')->get();
        $visas       = \App\Models\Visa::all();
        $companies   = \App\Models\Company::all();
        $jobLabels   = \App\Models\JobLabel::all();
        $experiences = \App\Models\Experience::all();
        $campaigns   = \App\Models\Campaign::all();
        $jobFairs    = \App\Models\JobFair::all();
        $job = null;

        return view('user-auth::post-job', compact(
            'job',
            'categories',
            'locations',
            'visas',
            'companies',
            'jobLabels',
            'experiences',
            'campaigns',
            'jobFairs'
        ));
    }

    private function generateJobIdCode($job, $request)
    {
        $visaCode = '';
        if ($request->visas) {
            $visa = Visa::find(is_array($request->visas) ? $request->visas[0] : $request->visas);
            if ($visa) {
                $words = explode(' ', preg_replace('/\s+/', ' ', trim($visa->name)));
                foreach ($words as $w) {
                    $visaCode .= mb_substr($w, 0, 1);
                }
            }
        }
        $visaCode = strtoupper($visaCode);

        $locCode = '';
        if ($request->locations) {
            $locId = is_array($request->locations) ? $request->locations[0] : $request->locations;
            $location = Location::find($locId);
            if ($location) {
                $rootLocation = $location;
                while ($rootLocation->parent_id != 0) {
                    $rootLocation = Location::find($rootLocation->parent_id);
                }

                if ($rootLocation->name == 'Việt Nam') {
                    $locCode = 'VN';
                } elseif ($rootLocation->name == 'Nhật Bản') {
                    $locCode = 'JP';
                } else {
                    $words = explode(' ', preg_replace('/\s+/', ' ', trim($rootLocation->name)));
                    foreach ($words as $w) {
                        $locCode .= mb_substr($w, 0, 1);
                    }
                }
            }
        }
        $locCode = strtoupper($locCode);

        return trim("{$visaCode}-{$locCode}-{$job->id}", '-');
    }

    public function store(Request $request)
    {
        $extra = $request->only([
            'highlight',
            'description',
            'application_requirement',
            'require',
            'levels',
            'require_others',
            'work_address',
            'work_by',
            'type_of_employment',
            'application_method',
            'posting_period',
            'posting_ended',
            'overview_description',
            'working_time',
            'annual_holiday',
            'benefits_allowances',
            'insurances',
            'unit_salary',
            'by_level_salary',
            'salary_by_month',
            'salary_by_hour',
            'salary_other_conditions',
            'pdf_url'
        ]);

        $job = Auth::user()->jobs()->create([
            'title'            => $request->name,
            'slug'             => Str::slug($request->name) . '-' . Str::random(6),
            'company_id'       => $request->company_id,
            'visa_id'          => is_array($request->visas) ? ($request->visas[0] ?? null) : $request->visas,
            'description'      => $request->description,
            'requirements'     => $request->application_requirement,
            'extra_attributes' => $extra,
            'salary_text'      => ($request->by_level_salary ?? '') . ' ' .
                number_format($request->salary_by_month ?? 0) . ' ' .
                strtoupper($request->unit_salary ?? 'JPY'),
            'active'           => false,
            'ord'              => 0,
        ]);

        $generatedId = $this->generateJobIdCode($job, $request);
        $extra['id_job'] = $generatedId;
        $job->update(['extra_attributes' => $extra]);

        $job->categories()->sync($request->job_categories ?? []);
        $job->locations()->sync($request->locations ?? []);
        $job->labels()->sync($request->job_labels ?? []);
        $job->experiences()->sync($request->experiences ?? []);
        $job->campaigns()->sync($request->campaigns ?? []);
        $job->jobFairs()->sync($request->job_fairs ?? []);
        $job->typeJobs()->sync($request->type_of_job ?? []);
        $job->visas()->sync($request->visas ?? []);

        if (method_exists($job, 'addSEO')) {
            $job->addSEO();
        }

        return redirect()->route('user.job.index')
            ->with('success', 'Đăng tin tuyển dụng thành công! Tin đang chờ duyệt.');
    }

    public function edit($id)
    {
        $job = Auth::user()->jobs()->findOrFail($id);

        $categories  = \App\Models\JobCategory::where('parent_id', 0)->with('children.children')->get();
        $locations   = \App\Models\Location::where('parent_id', 0)->with('children.children')->get();
        $visas       = \App\Models\Visa::all();
        $companies   = \App\Models\Company::all();
        $jobLabels   = \App\Models\JobLabel::all();
        $experiences = \App\Models\Experience::all();
        $campaigns   = \App\Models\Campaign::all();
        $jobFairs    = \App\Models\JobFair::all();

        return view('user-auth::post-job', compact(
            'job',
            'categories',
            'locations',
            'visas',
            'companies',
            'jobLabels',
            'experiences',
            'campaigns',
            'jobFairs'
        ));
    }

    public function update(Request $request, $id)
    {
        $job = Auth::user()->jobs()->findOrFail($id);

        $extra = $request->only([
            'highlight',
            'description',
            'application_requirement',
            'require',
            'levels',
            'require_others',
            'work_address',
            'work_by',
            'type_of_employment',
            'application_method',
            'posting_period',
            'posting_ended',
            'overview_description',
            'working_time',
            'annual_holiday',
            'benefits_allowances',
            'insurances',
            'unit_salary',
            'by_level_salary',
            'salary_by_month',
            'salary_by_hour',
            'salary_other_conditions',
            'pdf_url'
        ]);

        $generatedId = $this->generateJobIdCode($job, $request);
        $extra['id_job'] = $generatedId;

        $job->update([
            'title'            => $request->name,
            'company_id'       => $request->company_id ?? $job->company_id,
            'visa_id'          => is_array($request->visas) ? ($request->visas[0] ?? null) : $request->visas,
            'description'      => $request->description,
            'requirements'     => $request->application_requirement,
            'extra_attributes' => $extra,
            'salary_text'      => ($request->by_level_salary ?? '') . ' ' .
                number_format($request->salary_by_month ?? 0) . ' ' .
                strtoupper($request->unit_salary ?? 'JPY'),
            'active'           => false,
        ]);

        $job->visas()->sync($request->visas ?? []);
        $job->categories()->sync($request->job_categories ?? []);
        $job->locations()->sync($request->locations ?? []);
        $job->labels()->sync($request->job_labels ?? []);
        $job->experiences()->sync($request->experiences ?? []);
        $job->campaigns()->sync($request->campaigns ?? []);
        $job->jobFairs()->sync($request->job_fairs ?? []);
        $job->typeJobs()->sync($request->type_of_job ?? []);

        return redirect()->route('user.job.index')
            ->with('success', 'Cập nhật tin tuyển dụng thành công!');
    }
}
