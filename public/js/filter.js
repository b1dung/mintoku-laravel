document.addEventListener('DOMContentLoaded', () => {
    const locationSelect = document.getElementById('location');
    const provinceSelect = document.getElementById('province');
    if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
        jQuery('#location').select2();
        jQuery('#province').select2();
    }
	if(typeof(LOCATIONS) != "undefined"){
		var LOCATION_ARRS = JSON.parse(LOCATIONS);
		const handleLocationChange = () => {
			const selectedLocationId = locationSelect.value;
			var urlParams = new URLSearchParams(window.location.search);
			var t_location = urlParams.getAll('t_location[]').map(id => parseInt(id, 10));
			provinceSelect.innerHTML = '<option value="" selected>Chọn khu vực</option>';
			if (selectedLocationId && LOCATION_ARRS && LOCATION_ARRS[selectedLocationId]) {
				LOCATION_ARRS[selectedLocationId].forEach(location => {
					const option = new Option(location.name, location.term_id);
					if (t_location.includes(parseInt(location.term_id, 10))) {
						option.selected = true;
					}
					provinceSelect.appendChild(option);
				});
			}
			if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
				jQuery('#province').trigger('change.select2');
			}
		};
        $(locationSelect).on('select2:select', handleLocationChange);
		handleLocationChange();
	}
	
});


$(document).ready(function() {
    function updateCheckboxesByFilter(filterSelector, dataAttribute) {
        return function(selectedValue) {
            $('.input-checkbox input[type="checkbox"]').each(function() {
                const dataValue = $(this).data(dataAttribute);
                if (dataValue && dataValue != selectedValue) {
                    $(this).parent('.input-checkbox').hide();
                    $(this).prop('checked', false); 
                } else {
                    $(this).parent('.input-checkbox').show();
                }
            });
        };
    }
    const updateByVisa = updateCheckboxesByFilter('input[name="visa"]', 'visa');
    $('input#all').on('change', function() {
      $(window).location.href = window.location.origin+"?s=";
    });
    $('input[name="visa"]').on('change', function() {
        const selectedVisa = $(this).val();
        updateByVisa(selectedVisa);
    });
    const selectedVisa = $('input[name="visa"]:checked').val();
    if (selectedVisa) {
        updateByVisa(selectedVisa);
    }
    const updateByRegion = updateCheckboxesByFilter('input[name="location"]', 'region');
    $('input[name="location"]').on('change', function() {
        const selectedRegion = $(this).val();
        updateByRegion(selectedRegion);
    });
    const selectedRegion = $('input[name="location"]:checked').val();
    if (selectedRegion) {
        updateByRegion(selectedRegion);
    }
    var delayTime;
    $(document).on(
        "change",
        "#frm-filter .input-checkbox input[type='checkbox'], #frm-filter .input-checkbox input[type='radio'], #frm-filter input[name='order-by'], #frm-filter select[name='perpage']",
        function (e) {
            clearTimeout(delayTime);
            delayTime = setTimeout(function () {
                $("#frm-filter").submit();
            }, 1000);
        }
    );
    $('.group .parent-occupation .arrow').on('click', function() {
        var $parent = $(this).closest('.parent-occupation');
        var $childContainer = $parent.find('.child-occupations');
        $childContainer.slideToggle();
        $(this).toggleClass('is-show');
    });
    $('input[name="unit_salary"]').on('change', function() {
        $('input[name="salary[]"]').prop('checked', false);
    });
});