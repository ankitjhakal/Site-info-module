/**
 * @file
 * Updates time automatically.
 */

(function updateTime($) {
  Drupal.behaviors.updateTime = {
    attach: function updateTime() {


      // function to update time automatically.
      function updateClock() {
        $.ajax({
          url: Drupal.url('get-time'),
          type: 'GET',
          success: function (response) {
            if (response.time) {
              time.html(response.time);
            } else {
              time.html('No data is available due to missing timezone value.');
            }
          },
          error: function () {
            time.html('Failed to fetch data.')
          },
        });
      }
      const time = $('.site-info-parent #time');
      if (time) {
        // update time without page refresh.
        setInterval(function() {
            updateClock();
        }, 1000);
      }
    },
  };
}(jQuery));
