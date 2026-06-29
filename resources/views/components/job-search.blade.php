<div id="search">
    <form action="{{ route('jobs.index') }}" method="GET">
        <div class="group">
            <input type="text" name="s" value="{{ request('s') }}" placeholder="Nhập từ khóa" autocomplete="off">
            <input type="hidden" name="unit_salary" value="{{ request('unit_salary', '') }}" />

            <div class="search-box">
                <div class="search-box-inner">
                    <div class="search-box--item">
                        <p class="search-box--head">Việc làm phổ biến</p>
                        <div class="item-keywords">
                            <ul>
                                @foreach($categories as $term)
                                <li>
                                    <a href="{{ route('jobs.index', ['categories[]' => $term->id]) }}" title="{{ $term->name }}">
                                        {{ $term->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="group">
            <select name="locations[]" js-select2 id="location">
                <option value="">Địa điểm</option>
                @foreach($locations as $loc)
                <option value="{{ $loc->id }}" {{ collect(request('locations'))->contains($loc->id) ? 'selected' : '' }}>
                    {{ $loc->name }}
                </option>
                @endforeach
            </select>

            <select name="locations[]" js-select2 id="province">
                <option value="">Chọn khu vực</option>
            </select>

            <script>
                const LOCATIONS_DATA = @json($structuredLocations);

                document.addEventListener('DOMContentLoaded', function() {
                    const $locSelect = jQuery('#location');
                    const $provinceSelect = jQuery('#province');
                    const selectedValues = @json(request('locations', [])).map(id => String(id));

                    function populateProvinces(parentId, selectedId = null) {
                        $provinceSelect.html('<option value="">Chọn khu vực</option>');

                        if (parentId && LOCATIONS_DATA[parentId]) {
                            LOCATIONS_DATA[parentId].forEach(item => {
                                const isSelected = (item.id == selectedId || selectedValues.includes(String(item.id))) ? 'selected' : '';
                                const newOption = `<option value="${item.id}" ${isSelected}>${item.name}</option>`;
                                $provinceSelect.append(newOption);
                            });
                        }

                        if ($provinceSelect.data('select2')) {
                            $provinceSelect.trigger('change');
                        }
                    }

                    $locSelect.on('change', function() {
                        populateProvinces(this.value);
                    });

                    const initialLoc = $locSelect.val();
                    if (initialLoc) {
                        populateProvinces(initialLoc);
                    }
                });
            </script>

            <button type="submit">Tìm kiếm</button>
        </div>
    </form>
</div>