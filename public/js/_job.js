$(document).ready(function () {
  function _buildQueryForm() {
    var locations = $('.jobs-filter [name="location"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get()
      .join(",");

    var visas = $('.jobs-filter [name="visa"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get()
      .join(",");

    var occupations = $('.jobs-filter [name="occupation-tokuteigino"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get()
      .join(",");

    var status = $('.jobs-filter [name="status"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get()
      .join(",");
    $("#formFilter #location").val(locations);
    $("#formFilter #visa").val(visas);
    $("#formFilter #occupation-tokuteigino").val(occupations);
    $("#formFilter #status").val(status);
  }

  var form = $("#formFilter form");
  var asideSubmit = $(".jobs-filter button").first();
  asideSubmit.click(function (e) {
    e.preventDefault();
    _buildQueryForm();
    form.submit();
  });
});
