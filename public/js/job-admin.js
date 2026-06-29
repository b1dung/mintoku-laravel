jQuery(document).ready(function($) {
    function removeVietnameseDiacritics(str) {
        return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D');
    }
    function getAbbreviation(text) {
        if (!text) return '';
        return text
            .split(' ')
            .map(word => {
                const cleanWord = removeVietnameseDiacritics(word);
                return cleanWord.charAt(0).toUpperCase();
            })
            .join('');
    }
    function getSelectedTexts() {
        var visaText = $('div.acf-taxonomy-field[data-taxonomy="visa"] input[type="radio"]:checked')
            .closest('label').find('span').text() || '';
	  	visaText = visaText.replace(/\([^()]*\)/g, '').trim();
        var visaAbbr = getAbbreviation(visaText);
        const occupationTexts = [];
        $('[data-taxonomy="occupation-tokuteigino"] input[type="checkbox"]:checked').each(function() {
            var text = $(this).closest('label').find('span').text();
            if (text) occupationTexts.push(text);
        });
        const locationTexts = [];
        $('[data-taxonomy="location"] input[type="checkbox"]:checked').each(function() {
            var text = $(this).closest('label').find('span').text();
            if (text) locationTexts.push(getAbbreviation(text));
        });
		var locationAbbr = typeof(locationTexts[0]) != undefined ? locationTexts[0] : '';
        var postId = $('#post_ID').val() || '';
        var idJobValue = [visaAbbr, locationAbbr, postId].filter(Boolean).join('-');
        $('[data-name="id_job"] input').val(idJobValue);
        var result = {
            visa: visaAbbr,
            location: locationAbbr,
            postId: postId,
            idJob: idJobValue
        };
        return result;
    }
    $('[data-taxonomy="occupation-tokuteigino"] ul.children input[type="checkbox"], [data-taxonomy="location"] ul.children input[type="checkbox"]').on('change', function() {
        if ($(this).is(':checked')) {
            let currentLi = $(this).closest('li[data-id]');
            while (currentLi.length) {
                const parentLi = currentLi.closest('ul').closest('li[data-id]');
                if (!parentLi.length) break;
                const parentCheckbox = parentLi.find('> label > input[type="checkbox"]');
                if (parentCheckbox.length) {
                    parentCheckbox.prop('checked', true);
                }
                currentLi = parentLi;
            }
        }
        getSelectedTexts(); 
    });

    $('div.acf-taxonomy-field[data-taxonomy="visa"] input[type="radio"]').on('change', function() {
        getSelectedTexts(); 
    });
    getSelectedTexts();
});