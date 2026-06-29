<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobResource\Pages;
use App\Models\Job;
use App\Models\Visa;
use App\Models\JobCategory;
use App\Models\Location;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;
    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Job Management')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Overview')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Forms\Components\Grid::make(4)->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->label('Job Title')
                                        ->required()
                                        ->lazy()
                                        ->afterStateUpdated(fn($set, $state) => $set('slug', Str::slug($state))),

                                    Forms\Components\TextInput::make('slug')
                                        ->label('URL Slug')
                                        ->required()
                                        ->unique(ignoreRecord: true),
                                    Forms\Components\TextInput::make('ord')->numeric()->default(0)->label('Sort Order'),
                                    Forms\Components\Toggle::make('active')->default(true)->label('Status'),
                                ]),

                                Forms\Components\Section::make('Taxonomy Classification')->schema([
                                    Forms\Components\Grid::make(1)->schema([
                                        Forms\Components\Radio::make('visas')
                                            ->label('Visa')
                                            ->options(Visa::all()->pluck('name', 'id'))
                                            ->columns(4)
                                            ->required()
                                            ->reactive()
                                            ->saveRelationshipsUsing(function ($record, $state) {
                                                $record->visas()->sync($state ? [$state] : []);
                                            })
                                            ->formatStateUsing(function ($record) {
                                                return $record?->visas->first()?->id;
                                            })
                                            ->afterStateUpdated(fn($set, $get) => self::updateJobId($set, $get)),
                                    ]),

                                    Forms\Components\Grid::make(2)->schema([
                                        Forms\Components\CheckboxList::make('categories')
                                            ->label('Occupations')
                                            ->relationship('categories', 'name')
                                            ->options(fn() => self::getTreeOptions(JobCategory::class))
                                            ->columns(2)
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, $set) {
                                                if (!$state) return;
                                                $parentIds = \App\Models\JobCategory::whereIn('id', $state)
                                                    ->where('parent_id', '!=', 0)
                                                    ->pluck('parent_id')
                                                    ->toArray();

                                                if (!empty($parentIds)) {
                                                    $newState = array_unique(array_merge($state, $parentIds));
                                                    $set('categories', array_values($newState));
                                                }
                                            }),

                                        Forms\Components\CheckboxList::make('locations')
                                            ->label('Areas *')
                                            ->relationship('locations', 'name')
                                            ->options(fn() => self::getTreeOptions(Location::class))
                                            ->required()
                                            ->columns(2)
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                if (empty($state)) return;
                                                $fullPathIds = self::getAllParentIds(\App\Models\Location::class, $state);
                                                $set('locations', array_values($fullPathIds));
                                                self::updateJobId($set, $get);
                                            }),
                                    ]),

                                    Forms\Components\Grid::make(4)->schema([
                                        Forms\Components\Select::make('labels')
                                            ->label('Job Categories')
                                            ->relationship('labels', 'name')
                                            ->multiple()
                                            ->preload(),

                                        Forms\Components\Select::make('jobFairs')
                                            ->label('Job Fairs')
                                            ->relationship('jobFairs', 'name')
                                            ->multiple()
                                            ->preload(),

                                        Forms\Components\Select::make('experiences')
                                            ->label('Experience Requirements')
                                            ->relationship('experiences', 'name')
                                            ->multiple()
                                            ->preload(),

                                        Forms\Components\Select::make('campaigns')
                                            ->label('Campaigns')
                                            ->relationship('campaigns', 'name')
                                            ->multiple()
                                            ->preload(),

                                        Forms\Components\Select::make('typeJobs')
                                            ->label('Type Job')
                                            ->relationship('typeJobs', 'name')
                                            ->multiple()
                                            ->preload(),

                                        Forms\Components\Select::make('company_id')
                                            ->label('Hiring Company')
                                            ->relationship('company', 'name')
                                            ->searchable()
                                            ->required(),

                                        Forms\Components\Select::make('incorporations')
                                            ->label('Support Organization')
                                            ->relationship('incorporations', 'name')
                                            ->multiple()
                                            ->preload(),

                                        Forms\Components\TextInput::make('extra_attributes.manager')
                                            ->label('Person in Charge'),

                                    ]),
                                ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Highlights')
                            ->icon('heroicon-o-star')
                            ->schema([
                                Forms\Components\Textarea::make('extra_attributes.highlight')
                                    ->label('Highlight Information')
                                    ->rows(5),
                            ]),

                        Forms\Components\Tabs\Tab::make('Description')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\RichEditor::make('description')
                                    ->label('Job Description')
                                    ->required(),

                                Forms\Components\RichEditor::make('extra_attributes.overview_description')
                                    ->label('Overview Description'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Requirements')
                            ->icon('heroicon-o-academic-cap')
                            ->schema([
                                Forms\Components\RichEditor::make('requirements')
                                    ->label('Application Requirement'),

                                Forms\Components\Section::make('Job Requirements')->schema([
                                    Forms\Components\TextInput::make('extra_attributes.require')
                                        ->label('Require'),

                                    Forms\Components\Repeater::make('extra_attributes.require_others')
                                        ->label('Other Requirements')
                                        ->schema([
                                            Forms\Components\TextInput::make('title')
                                                ->label('Additional Info'),
                                            Forms\Components\TextInput::make('note')
                                                ->label('Specific Notes'),
                                        ])
                                        ->columns(2)
                                        ->createItemButtonLabel('Add Other Requirement'),
                                ]),

                                Forms\Components\Section::make('Japanese Language Proficiency')->schema([
                                    Forms\Components\Repeater::make('extra_attributes.levels')
                                        ->label('Language Skills')
                                        ->schema([
                                            Forms\Components\TextInput::make('title')->label('Level (N1, N2...)'),
                                            Forms\Components\TextInput::make('note')->label('Specific Notes'),
                                        ])->columns(2)->createItemButtonLabel('Add Level'),
                                ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Information')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\TextInput::make('extra_attributes.id_job')
                                        ->label('ID Job')
                                        ->disabled()
                                        ->dehydrated(),
                                    Forms\Components\TextInput::make('extra_attributes.circulate')->label('Circulate'),
                                    Forms\Components\TextInput::make('extra_attributes.posting_period')->label('Posting Period'),
                                    Forms\Components\TextInput::make('extra_attributes.posting_ended')->label('Posting Ended'),
                                ]),

                                Forms\Components\TextInput::make('extra_attributes.work_address')->label('Work Address'),

                                Forms\Components\Section::make('Operational Description')->schema([
                                    Forms\Components\Grid::make(3)->schema([
                                        Forms\Components\TextInput::make('extra_attributes.work_by')->label('Work By (Transportation)'),
                                        Forms\Components\TextInput::make('extra_attributes.type_of_employment')->label('Type of Employment'),
                                        Forms\Components\TextInput::make('extra_attributes.working_time')->label('Working Time'),
                                    ]),
                                    Forms\Components\TextArea::make('extra_attributes.annual_holiday')->label('Annual Holiday'),
                                    Forms\Components\RichEditor::make('extra_attributes.benefits_allowances')->label('Benefits & Allowances'),

                                    Forms\Components\Repeater::make('extra_attributes.insurances')
                                        ->label('Insurances')
                                        ->schema([
                                            Forms\Components\TextInput::make('title')->label('Insurance Type'),
                                            Forms\Components\TextInput::make('note')->label('Details'),
                                        ])->columns(2),
                                ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Salary')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\Select::make('extra_attributes.unit_salary')
                                        ->label('Unit Salary *')
                                        ->options(['usd' => 'USD', 'vnd' => 'VND', 'jpy' => 'JPY'])
                                        ->required()
                                        ->default('jpy'),
                                    Forms\Components\TextInput::make('extra_attributes.salary_by_hour')->label('Salary By Hour'),
                                    Forms\Components\TextInput::make('extra_attributes.salary_by_month')->label('Salary By Month'),

                                    Forms\Components\Select::make('extra_attributes.by_level_salary')
                                        ->label('By Level Salary')
                                        ->options(['Upto' => 'Upto', 'From' => 'From', '~' => 'Approx']),

                                    Forms\Components\TextInput::make('extra_attributes.region')->label('Region'),
                                ]),
                                Forms\Components\Textarea::make('extra_attributes.salary_other_conditions')->label('Salary Other Conditions'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Application Method')
                            ->icon('heroicon-o-paper-airplane')
                            ->schema([
                                Forms\Components\RichEditor::make('extra_attributes.application_method')
                                    ->label('Application Method Content'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Documents')
                            ->icon('heroicon-o-paper-clip')
                            ->schema([
                                Forms\Components\TextInput::make('extra_attributes.pdf_url')
                                    ->label('PDF URL')
                                    ->url(),
                            ]),

                        Forms\Components\Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-search')
                            ->schema([
                                Forms\Components\Group::make()->relationship('seo')->schema([
                                    Forms\Components\TextInput::make('title')->label('Meta Title'),
                                    Forms\Components\Textarea::make('description')->label('Meta Description')->rows(3),
                                    Forms\Components\FileUpload::make('image')->label('Social Image')->directory('seo-images')->image(),
                                ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    protected static function getTreeOptions($modelClass): array
    {
        $all = $modelClass::all();
        $options = [];

        $traverse = function ($items, $prefix = '') use (&$traverse, &$options) {
            foreach ($items as $item) {
                $options[$item->id] = $prefix . $item->name;
                $children = $item->children;
                if ($children && $children->count() > 0) {
                    $traverse($children, $prefix . '— ');
                }
            }
        };

        $roots = $all->where('parent_id', null)->count() > 0 ? $all->where('parent_id', null) : $all->where('parent_id', 0);
        $traverse($roots);

        return $options;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextInputColumn::make('ord')
                    ->label('Order')
                    ->sortable()
                    ->extraAttributes([
                        'style' => 'width: 50px;',
                    ]),

                Tables\Columns\TextColumn::make('title')
                    ->label('Job Info')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Job $record): string => "Slug: {$record->slug}")
                    ->limit(40),

                Tables\Columns\TextColumn::make('company.name')
                    ->label('Company')
                    ->searchable()
                    ->description(fn(Job $record): string => "Posted: " . $record->created_at->format('M d, Y')),

                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Category')
                    ->getStateUsing(fn($record) => $record->categories->pluck('name')->join(', '))
                    ->wrap()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('visas.name')
                    ->label('Visa Type')
                    ->getStateUsing(fn($record) => $record->visas->pluck('name')->join(', '))
                    ->wrap()
                    ->fontFamily('mono'),

                Tables\Columns\TextColumn::make('locations.name')
                    ->label('Geography')
                    ->getStateUsing(fn($record) => $record->locations->pluck('name')->join(', '))
                    ->color('success')
                    ->wrap(),

                Tables\Columns\TextColumn::make('labels.name')
                    ->label('Tags')
                    ->getStateUsing(fn($record) => $record->labels->pluck('name')->join(', '))
                    ->color('warning')
                    ->wrap(),

                Tables\Columns\TextColumn::make('salary_display')
                    ->label('Monthly Salary')
                    ->getStateUsing(function (Job $record) {
                        $amount = $record->get_field('salary_by_month');
                        $unit = strtoupper($record->get_field('unit_salary', 'JPY'));
                        return $amount ? number_format((float) $amount) . " $unit" : 'Negotiable';
                    }),

                Tables\Columns\ToggleColumn::make('active')
                    ->label('Status'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Active Status'),

                Tables\Filters\SelectFilter::make('categories')
                    ->label('Category')
                    ->relationship('categories', 'name')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('visas')
                    ->label('Visa')
                    ->relationship('visas', 'name')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('locations')
                    ->label('Location')
                    ->relationship('locations', 'name')
                    ->multiple(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view_public')
                        ->label('View Site')
                        ->icon('heroicon-o-eye')
                        ->url(fn(Job $record): string => route('jobs.show', $record->slug))
                        ->openUrlInNewTab(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
    protected static function updateJobId($set, $get)
    {
        $visaId = $get('visa_id');
        $locationIds = $get('locations') ?? [];
        $recordId = $get('id') ?? 'NEW';

        $visaName = $visaId ? \App\Models\Visa::find($visaId)?->name : '';

        $locationName = '';
        if (!empty($locationIds)) {
            $rootLocation = \App\Models\Location::whereIn('id', $locationIds)
                ->where('parent_id', 0)
                ->first();
            $locationName = $rootLocation ? $rootLocation->name : '';
        }

        $set('extra_attributes.id_job', trim("{$visaName}{$locationName}{$recordId}"));
    }
    protected static function getAllParentIds($modelClass, $currentIds)
    {
        if (empty($currentIds)) return [];

        $allIds = $currentIds;
        $parents = $modelClass::whereIn('id', $currentIds)
            ->where('parent_id', '!=', 0)
            ->pluck('parent_id')
            ->toArray();

        if (!empty($parents)) {
            $allIds = array_merge($allIds, self::getAllParentIds($modelClass, $parents));
        }

        return array_unique($allIds);
    }
}
