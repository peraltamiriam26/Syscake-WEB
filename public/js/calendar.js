  window.addEventListener('load', function () {
    flatpickr('#flatpickr-date', {
            monthSelectorType: 'static',
            enableTime: false,
            dateFormat: "d-m-Y",
            locale: "es",
            minDate: "today"
        }
    )
  });