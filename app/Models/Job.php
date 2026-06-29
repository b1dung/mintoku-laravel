<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;
use App\Traits\HasBreadcrumbSchema;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasCommonFields;
    use HasBreadcrumbSchema;
    use HasSEO;

    protected $table = 'jobs';

    public function getTable()
    {
        return config('services.mintoku_public.jobs_table', $this->table);
    }

    protected $fillable = [
        'company_id',
        'title',
        'slug',
        'description',
        'requirements',
        'salary_text',
        'active',
        'ord',
        'extra_attributes'
    ];

    protected $casts = [
        'extra_attributes' => 'array',
        'active' => 'boolean',
    ];

    /**
     * Helper lấy dữ liệu từ JSON extra_attributes giống get_field của WP
     */
    public function get_field(string $key, $default = null)
    {
        $value = data_get($this->extra_attributes, $key);
        if (is_null($value)) {
            $value = $this->getAttribute($key);
        }
        return $value ?? $default;
    }

    /**
     * Tự động hóa SEO & Schema: 
     * Gói RalphJSmit sẽ ưu tiên dữ liệu nhập trong Admin, 
     * nếu trống sẽ tự chạy hàm này.
     */
    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title . ' | Mintoku',
            description: Str::limit(strip_tags($this->get_field('job_description')), 155),
            schema: $this->getJobSchema(),
        );
    }

    /**
     * Cấu trúc Schema JobPosting chuẩn cho Google Jobs
     */
    public function getJobSchema(): array
    {
        return [
            "@context" => "https://schema.org/",
            "@type" => "JobPosting",
            "title" => $this->title,
            "description" => strip_tags($this->get_field('job_description') ?: $this->title),
            "datePosted" => $this->created_at ? $this->created_at->toIso8601String() : now()->toIso8601String(),
            "validThrough" => $this->get_field('posting_ended') ? date('c', strtotime($this->get_field('posting_ended'))) : null,
            "employmentType" => "FULL_TIME",
            "hiringOrganization" => [
                "@type" => "Organization",
                "name" => $this->company?->name ?: 'Mintoku',
                "logo" => asset('images/logo.png')
            ],
            "jobLocation" => [
                "@type" => "Place",
                "address" => [
                    "@type" => "PostalAddress",
                    "addressLocality" => $this->locations->first()?->name ?: 'Japan',
                    "addressCountry" => "JP"
                ]
            ],
            "baseSalary" => [
                "@type" => "MonetaryAmount",
                "currency" => strtoupper($this->get_field('unit_salary', 'JPY')),
                "value" => [
                    "@type" => "QuantitativeValue",
                    "value" => (int) $this->get_field('salary_by_month', 0),
                    "unitText" => "MONTH"
                ]
            ]
        ];
    }

    // --- Relationships ---

    public function seo()
    {
        return $this->morphOne(\RalphJSmit\Laravel\SEO\Models\SEO::class, 'seoable');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function responsible()
    {
        return $this->morphTo();
    }
    public function labels()
    {
        return $this->belongsToMany(
            JobLabel::class,
            'job_label_pivot',
            'job_id',
            'label_id'
        );
    }
    public function jobFairs()
    {
        return $this->belongsToMany(
            JobFair::class,
            'job_jobfair_pivot',
            'job_id',
            'jobfair_id'
        );
    }
    public function incorporations()
    {
        return $this->belongsToMany(
            Incorporation::class,
            'job_incorporation_pivot',
            'job_id',
            'incorporation_id'
        );
    }
    public function typeJobs()
    {
        return $this->belongsToMany(TypeJob::class, 'job_type_job', 'job_id', 'type_job_id');
    }
    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'job_campaign_pivot', 'job_id', 'campaign_id');
    }
    public function categories()
    {
        return $this->belongsToMany(JobCategory::class, 'job_category_pivot', 'job_id', 'category_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'job_location_pivot');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'job_language_pivot');
    }

    public function visa(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Visa::class, 'id', 'id');
    }
    public function visas()
    {
        return $this->belongsToMany(Visa::class, 'job_visa_pivot');
    }

    public function experiences()
    {
        return $this->belongsToMany(Experience::class, 'job_experience_pivot');
    }

    public static function getRelated($currentJobId, $limit = 6)
    {
        $job = self::with(['locations', 'visas', 'categories'])->find($currentJobId);

        if (!$job) {
            return collect();
        }

        $locationIds = $job->locations->pluck('id')->toArray();
        $visaIds = $job->visas->pluck('id')->toArray();
        $categoryIds = $job->categories->pluck('id')->toArray();

        return self::where('id', '!=', $currentJobId)
            ->where('active', true)
            ->where(function ($query) use ($locationIds, $visaIds, $categoryIds) {

                if (!empty($locationIds)) {
                    $query->orWhereHas('locations', function ($q) use ($locationIds) {
                        $q->whereIn('locations.id', $locationIds);
                    });
                }

                if (!empty($visaIds)) {
                    $query->orWhereHas('visas', function ($q) use ($visaIds) {
                        $q->whereIn('visas.id', $visaIds);
                    });
                }

                if (!empty($categoryIds)) {
                    $query->orWhereHas('categories', function ($q) use ($categoryIds) {
                        $q->whereIn('job_category_pivot.category_id', $categoryIds);
                    });
                }
            })
            ->limit($limit)
            ->orderBy('ord', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
