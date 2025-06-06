$(document).ready(function() {
    $('.select-recipes').select2({
  ajax: {
    url: 'search-recipe',
    dataType: 'json',
    processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      return {
        results: data.items
      };
    }
  }
});
});
