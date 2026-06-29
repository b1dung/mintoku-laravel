<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Visa;
use App\Models\Location;
use App\Models\JobCategory;
use App\Models\JobLabel;
use App\Models\TypeJob;
use App\Models\Experience;
use App\Models\Language;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function syncAllJobs(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '1G');

        $baseUrl = "https://mintoku.vn/";
        $token = "my_secret_key_123";
        $page = $request->query('paged_sync', 1);

        Log::info("========== BẮT ĐẦU SYNC TRANG: $page ==========");

        try {
            $response = Http::timeout(600)->get($baseUrl, [
                'export_token' => $token,
                'paged_sync'   => $page,
                'nocache'      => time(),
            ]);

            if ($response->failed()) {
                Log::error("Lỗi kết nối API trang $page: " . $response->status());
                return response()->json(['status' => 'error', 'message' => "Lỗi kết nối trang $page"], 500);
            }

            $jobs = $response->json();

            // COMMENT dòng dd($jobs) này để code chạy tiếp xuống phần LOG
            // dd($jobs); 

            if (empty($jobs) || !is_array($jobs)) {
                Log::warning("Dữ liệu trang $page trống hoặc không đúng định dạng mảng.");
                return response()->json(['status' => 'empty', 'message' => "Dữ liệu trống"]);
            }

            $count = 0;
            foreach ($jobs as $item) {
                $cleanSlug = urldecode($item['post_name']);

                // 1. Cập nhật hoặc tạo mới Job chính
                $job = Job::updateOrCreate(
                    ['slug' => $cleanSlug],
                    [
                        'title'       => html_entity_decode($item['post_title'] ?? '', ENT_QUOTES, 'UTF-8'),
                        'description' => $item['job_description'] ?? '',
                        'requirements' => $item['application_requirement'] ?? '',
                        'company' => $item['company'] ?? null,
                        'active' => (isset($item['post_status']) && $item['post_status'] === 'publish') ? 1 : 0,
                        'extra_attributes' => [
                            'id_job'                  => $item['id_job'] ?? null,
                            'person_in_charge'        => $item['person_in_charge'] ?? null,
                            'highlight'               => $item['highlight'] ?? null,
                            'require'                 => $item['require'] ?? null,
                            'require_others'          => $item['require_others'] ?? null,
                            'levels'                  => $item['levels'] ?? null,
                            'overview_description'    => $item['overview_description'] ?? null,
                            'work_address'            => $item['work_address'] ?? null,
                            'posting_period'          => $item['posting_period'] ?? null,
                            'posting_ended'           => $item['posting_ended'] ?? null,
                            'working_time'            => $item['working_time'] ?? null,
                            'annual_holiday'          => $item['annual_holiday'] ?? null,
                            'unit_salary'             => $item['unit_salary'] ?? null,
                            'salary_by_hour'          => $item['salary_by_hour'] ?? null,
                            'salary_by_month'         => $item['salary_by_month'] ?? null,
                            'by_level_salary'         => $item['by_level_salary'] ?? null,
                            'salary_other_conditions' => $item['salary_other_conditions'] ?? null,
                            'benefits_allowances'     => $item['benefits_allowances'] ?? null,
                            'insurances'              => $item['insurances'] ?? null,
                            'type_of_employment'      => $item['type_of_employment'] ?? null,
                            'application_method'      => $item['application_method'] ?? null,
                            'circulate'               => $item['circulate'] ?? null,
                            'work_by'                 => $item['work_by'] ?? null,
                            'pdf_url'                 => $item['pdf_url'] ?? null,
                        ]
                    ]
                );

                // 2. Đồng bộ Taxonomy (Phân loại)
                $this->syncJobTaxonomies($job, $item);

                $count++;
            }

            Log::info("========== HOÀN TẤT SYNC TRANG $page. TỔNG CỘNG: $count JOB ==========");
            return response()->json(['status' => 'success', 'total_items' => $count]);
        } catch (\Exception $e) {
            Log::error("Lỗi hệ thống khi Sync: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function syncJobTaxonomies($job, $item)
    {
        // Bản đồ mapping giữa Key trong JSON và Model trong Laravel
        $map = [
            't_visa'         => Visa::class,
            't_location'     => Location::class,
            't_occupation'   => JobCategory::class,
            't_job_category' => JobLabel::class,
            't_type-job'     => TypeJob::class,
            't_experience'   => Experience::class,
            't_language'     => Language::class,
            'region'         => Location::class,
        ];

        Log::debug("--- Đang xử lý Taxonomy cho Job: [{$job->id}] {$job->title} ---");

        foreach ($map as $jsonKey => $modelClass) {

            // KIỂM TRA 1: Key có tồn tại trong JSON trả về không?
            if (!isset($item[$jsonKey])) {
                Log::warning("Job ID [{$item['id_job']}]: Key '{$jsonKey}' KHÔNG TỒN TẠI trong JSON.");
                continue;
            }

            $rawData = $item[$jsonKey];

            // KIỂM TRA 2: Dữ liệu có trống không?
            if (empty($rawData)) {
                Log::info("Job ID [{$item['id_job']}]: Key '{$jsonKey}' tồn tại nhưng DỮ LIỆU TRỐNG.");
                continue;
            }

            $names = is_array($rawData) ? $rawData : [$rawData];
            $ids = [];

            foreach ($names as $name) {
                if (empty($name)) continue;

                $name = trim($name); // Xóa khoảng trắng thừa

                // KIỂM TRA 3: Tìm Record trong DB theo tên (Chính xác từng dấu)
                $record = $modelClass::where('name', $name)->first();

                if (!$record) {
                    // Nếu không tìm thấy, tạo mới và Log lại để biết tại sao lệch tên
                    $record = $modelClass::create([
                        'name' => $name,
                        'slug' => Str::slug($name),
                        'parent_id' => 0 // Mặc định là cha nếu tạo mới
                    ]);
                    Log::notice("Tạo mới {$modelClass}: '{$name}' (Do không tìm thấy tên khớp trong DB)");
                }

                if ($record) {
                    $ids[] = $record->id;
                }
            }

            // 3. Logic xác định tên Relationship trong Model Job
            $relationName = Str::camel(Str::plural(str_replace('t_', '', $jsonKey)));

            // Override các trường hợp đặc biệt để khớp với tên hàm trong Job.php
            if ($jsonKey === 'region' || 't_location') $relationName = 'locations';
            if ($jsonKey === 't_occupation')   $relationName = 'categories';
            if ($jsonKey === 't_job_category') $relationName = 'labels';
            if ($jsonKey === 't_type-job')     $relationName = 'typeJobs';

            // 4. Tiến hành Sync vào bảng trung gian
            if (method_exists($job, $relationName)) {
                if (!empty($ids)) {
                    // syncWithoutDetaching giúp giữ lại các quan hệ cũ, chỉ thêm mới
                    $job->$relationName()->syncWithoutDetaching($ids);
                    Log::debug("Sync thành công '{$relationName}' cho Job. Danh sách ID: " . implode(',', $ids));
                }
            } else {
                Log::error("LỖI: Model Job không có hàm relationship tên là '{$relationName}'");
            }
        }
    }
}
