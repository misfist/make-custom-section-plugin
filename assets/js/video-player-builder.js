(function (window, Backbone, $, _, oneApp) {

  oneApp.models['video-player'] = oneApp.models.section.extend();

  oneApp.views['video-player'] = oneApp.views.section.extend({
    events: function() {
      return _.extend({}, oneApp.views.section.prototype.events, {
        'view-ready': 'onViewReady',
        'overlay-close': 'onOverlayClose',
      });
    },

    onViewReady: function() {
      this.refresh();
    },

    onOverlayClose: function(e, changeset) {
      oneApp.views.section.prototype.onOverlayClose.apply(this, arguments);
      this.model.set(changeset);

      this.refresh();
    },

    refresh: function() {
      var $iframe = $('iframe', this.$el);
      var $notice = $('.make-video-player-notice', this.$el);
      var videoUrl = this.model.get('video-url');

      if (videoUrl !== '') {
        $notice.hide();
        $iframe.attr('src', videoUrl);
        $iframe.show();
      } else {
        $notice.show();
        $iframe.hide();
      }
    }
  });

})(window, Backbone, jQuery, _, oneApp);