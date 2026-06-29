<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class ViewApplications extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'CV Applications';
    protected static ?string $title = 'Manage Remote Applications';
    protected static ?string $slug = 'manage-applications';
    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.manage-applications';

    public $applications = [];
    public $currentPage = 1;

    public function mount()
    {
        $this->currentPage = request()->get('page', 1);
        $this->loadData();
    }

    public function loadData()
    {
        $response = Http::timeout(30)->get('https://cv.mintoku.vn/admin/applications', [
            'page' => $this->currentPage,
            'name' => request()->get('f_name'),
            'email' => request()->get('f_email'),
        ]);

        if ($response->successful()) {
            $this->applications = $response->json();
        }
    }

    public function getPaginator()
    {
        if (empty($this->applications) || ! isset($this->applications['data'])) {
            return null;
        }

        return new LengthAwarePaginator(
            $this->applications['data'],
            $this->applications['total'],
            $this->applications['per_page'],
            $this->currentPage,
            [
                'path' => route('filament.pages.manage-applications'),
                'query' => request()->query(),
            ]
        );
    }

    protected static function canAccess(): bool
    {
        return true;
    }
}
