jQuery(document).ready(function ($) {
  if ($(".wpuf-form-add").length > 0) {
    function removeVietnameseDiacritics(str) {
      return str
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .replace(/đ/g, "d")
        .replace(/Đ/g, "D");
    }
    function getAbbreviation(text) {
      if (!text) return "";
      return text
        .split(" ")
        .map((word) => {
          const cleanWord = removeVietnameseDiacritics(word);
          return cleanWord.charAt(0).toUpperCase();
        })
        .join("");
    }
    function getSelectedTexts() {
      var visaText = $('#visa').find(":selected").text() || "";
	  visaText = visaText.replace(/\([^()]*\)/g, '').trim();
	  visaText = visaText === "– Chọn Visa –" ? "N O" : visaText;
      var visaAbbr = getAbbreviation(visaText);
      const occupationTexts = [];
      $(
        '.occupation-tokuteigino input[type="checkbox"]:checked'
      ).each(function () {
        var text = $(this).closest("label").text();
        if (text) occupationTexts.push(text);
      });
      const locationTexts = [];
      $('.location  input[type="checkbox"]:checked').each(
        function () {
          var text = $(this).closest("label").text();
          if (text) locationTexts.push(getAbbreviation(text));
        }
      );
      var locationAbbr =
        typeof locationTexts[0] != undefined ? locationTexts[0] : "";
      var idJobValue = [visaAbbr, locationAbbr]
        .filter(Boolean)
        .join("-");
      $('[name="id_job"]').val(idJobValue);
      var result = {
        visa: visaAbbr,
        location: locationAbbr,
        idJob: idJobValue,
      };
      return result;
    }
    $(
      '.occupation-tokuteigino .wpuf-category-checklist input[type="checkbox"], .location .wpuf-category-checklist input[type="checkbox"]'
    ).on("change", function () {
      if ($(this).is(":checked")) {
        let currentLi = $(this).closest("li");
        while (currentLi.length) {
          const parentLi = currentLi.closest("ul").closest("li");
          if (!parentLi.length) break;
          const parentCheckbox = parentLi.find(
            '> label > input[type="checkbox"]'
          );
          if (parentCheckbox.length) {
            parentCheckbox.prop("checked", true);
          }
          currentLi = parentLi;
        }
      }
      getSelectedTexts();
    });

    $('#visa').on(
      "change",
      function () {
        getSelectedTexts();
      }
    );
    getSelectedTexts();
  }
});