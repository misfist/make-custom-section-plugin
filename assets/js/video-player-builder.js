( function( $, _, Backbone, builderSettings, sectionData ) {

	var Model = Backbone.Model.extend( {
		defaults: function() {
			return _.extend( {}, sectionData.defaults['video-player'], {
				id: _.uniqueId( 'video-player_' ),
			} );
		},
	} );

	var View = make.classes.SectionView.extend( {
		template: wp.template( 'ttfmake-section-video-player' ),

		initialize: function() {
			make.classes.SectionView.prototype.initialize.apply( this, arguments );

			this.listenTo( this.model, 'change:video-url', this.refresh );
		},

		afterRender: function() {
			this.refresh();
		},

		// A simple example of view logic. Toggles the preview iframe,
    // if the video-url field is empty.
    refresh: function() {
      var $iframe = $( 'iframe', this.$el );
      var $notice = $( '.make-video-player-notice', this.$el );
      var videoUrl = this.model.get('video-url');

      if ( videoUrl !== '' ) {
        $notice.hide();
        $iframe.attr( 'src', videoUrl );
        $iframe.show();
      } else {
        $notice.show();
        $iframe.hide();
      }
    }

	} );

	make.factory.model = _.wrap( make.factory.model, function( func, attrs, BaseClass ) {
		switch ( attrs[ 'section-type' ] ) {
			case 'video-player': BaseClass = Model; break;
		}

		return func( attrs, BaseClass );
	} );

	make.factory.view = _.wrap( make.factory.view, function( func, options, BaseClass ) {
		switch ( options.model.get( 'section-type' ) ) {
			case 'video-player': BaseClass = View; break;
		}

		return func( options, BaseClass );
	} );

} ) ( jQuery, _, Backbone, ttfmakeBuilderSettings, ttfMakeSections );


/*
(function (window, Backbone, $, _, oneApp) {
  // Model and View classes for the Builder side of this section.

  // The model class for this section. The key used for
  // oneApp.models should be the section ID passed to ttfmake_add_section().
  oneApp.models['video-player'] = oneApp.models.section.extend();

  // The view class for this section.
  // Some commonly used handlers are showcased here:
  oneApp.views['video-player'] = oneApp.views.section.extend({
    events: function() {
      return _.extend({}, oneApp.views.section.prototype.events, {
        // Called when this section has finished rendering
        'view-ready': 'onViewReady',
        // Called every time an overlay for this section gets closed.
        // Overlays can be relative to settings, content or widgets.
        // The handler gets passed an hash of changes, if any, coming from the overlay.
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

    // A simple example of view logic. Toggles the preview iframe,
    // if the video-url field is empty.
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
*/