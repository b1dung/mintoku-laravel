<aside class="aside filter">
    <div class="group">
        <div class="input-checkbox">
            <input type="checkbox" id="all" name="all" {{ !request()->except('page') ? 'checked' : '' }}
                onclick="window.location.href='{{ route('jobs.index') }}'" />
            <label for="all">Tất cả</label>
        </div>
    </div>

    <div class="group">
        <h3 class="title">Quốc gia</h3>
        @foreach($locations as $term)
        <div class="input-checkbox">
            <input type="checkbox" id="location-{{ $term->id }}"
                name="locations[]"
                value="{{ $term->id }}"
                {{ collect(request('locations'))->contains($term->id) ? 'checked' : '' }} />
            <label for="location-{{ $term->id }}">{{ $term->name }}</label>
        </div>
        @endforeach
    </div>

    <div class="group">
        <h3 class="title">Hình thức</h3>
        @foreach($visas as $term)
        <div class="input-checkbox">
            <input type="radio" id="visa-{{ $term->id }}"
                name="visa"
                value="{{ $term->id }}"
                {{ request('visa') == $term->id ? 'checked' : '' }} />
            <label for="visa-{{ $term->id }}">{{ $term->name }}</label>
        </div>
        @endforeach
    </div>

    <div class="group">
        <h3 class="title">Ngành nghề</h3>
        @foreach($categories as $parent)
        @php $isParentActive = collect(request('categories'))->contains($parent->id); @endphp
        <div class="parent-occupation">
            <div class="input-checkbox parent-checkbox">
                <input type="checkbox" name="categories[]"
                    id="cat-{{ $parent->id }}"
                    value="{{ $parent->id }}"
                    {{ $isParentActive ? 'checked' : '' }} />
                <label for="cat-{{ $parent->id }}">{{ $parent->name }}</label>
                @if($parent->children->isNotEmpty())
                <svg class="arrow {{ $isParentActive ? 'is-show' : '' }}" width="16" height="16" viewBox="0 0 24 24">
                    <path d="M6 9l6 6 6-6" fill="none" stroke="currentColor" stroke-width="2" />
                </svg>
                @endif
            </div>
            @if($parent->children->isNotEmpty())
            <div class="child-occupations" style="display: {{ $isParentActive ? 'block' : 'none' }};">
                @foreach($parent->children as $child)
                <div class="input-checkbox child-checkbox">
                    <input type="checkbox" name="categories[]"
                        id="cat-{{ $child->id }}"
                        value="{{ $child->id }}"
                        {{ collect(request('categories'))->contains($child->id) ? 'checked' : '' }} />
                    <label for="cat-{{ $child->id }}">{{ $child->name }}</label>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <div class="group">
        <h3 class="title">Đơn vị tiền</h3>
        @foreach(['usd' => 'USD', 'jpy' => 'JPY', 'vnd' => 'VND'] as $val => $label)
        <div class="input-checkbox">
            <input type="radio" id="unit-{{ $val }}" name="unit_salary" value="{{ $val }}"
                {{ request('unit_salary') == $val ? 'checked' : '' }}>
            <label for="unit-{{ $val }}">{{ $label }}</label>
        </div>
        @endforeach
    </div>

    @if(request()->filled('unit_salary') && $rangeSalary->isNotEmpty())
    <div class="group">
        <h3 class="title">Mức lương ({{ strtoupper(request('unit_salary')) }})</h3>
        @foreach($rangeSalary as $index => $salary)
        <div class="input-checkbox">
            <input type="checkbox" id="salary-{{ $index }}" name="salaries[]" value="{{ $salary['value'] }}"
                {{ collect(request('salaries'))->contains($salary['value']) ? 'checked' : '' }}>
            <label for="salary-{{ $index }}">{{ $salary['label'] }}</label>
        </div>
        @endforeach
    </div>
    @endif

    @php
    $taxonomies = [
    ['title' => 'Hình thức làm việc', 'name' => 'job_types', 'data' => $typeJobs],
    ['title' => 'Kinh nghiệm', 'name' => 'experiences', 'data' => $experiences],
    ['title' => 'Ngôn ngữ', 'name' => 'languages', 'data' => $languages],
    ['title' => 'Danh mục công việc', 'name' => 'labels', 'data' => $jobLabels],
    ];
    @endphp

    @foreach($taxonomies as $tax)
    @if(!empty($tax['data']))
    <div class="group">
        <h3 class="title">{{ $tax['title'] }}</h3>
        @foreach($tax['data'] as $term)
        <div class="input-checkbox">
            <input type="checkbox" id="{{ $tax['name'] }}-{{ $term->id }}"
                name="{{ $tax['name'] }}[]"
                value="{{ $term->id }}"
                {{ collect(request($tax['name']))->contains($term->id) ? 'checked' : '' }} />
            <label for="{{ $tax['name'] }}-{{ $term->id }}">{{ $term->name }}</label>
        </div>
        @endforeach
    </div>
    @endif
    @endforeach
</aside>