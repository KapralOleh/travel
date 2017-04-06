if (document.getElementById("map")) {
              var map_hgr5808a7966a028;
              var gmap_location_hgr5808a7966a028 = new google.maps.LatLng(49.829837, 24.029413
);

              var GMAP_MODULE_hgr5808a7966a028 = "custom_style";
              function initialize() {
                var featureOpts = [
                      {
                        stylers: [
                        { hue: "#0288d1" },
                        { saturation: -60 },
                        { lightness: -7 },
                        { gamma: 1.1 }
                      ]
                      }
                    ];
                var mapOptions = {
                  zoom: 15,
                  scrollwheel: false,
                  center: gmap_location_hgr5808a7966a028,
                  mapTypeControlOptions: {
                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, GMAP_MODULE_hgr5808a7966a028]
                  },
                  mapTypeId: GMAP_MODULE_hgr5808a7966a028
                };
                
                map_hgr5808a7966a028 = new google.maps.Map(document.getElementById("map"), mapOptions);
                
                marker_hgr5808a7966a028 = new google.maps.Marker({
                  map: map_hgr5808a7966a028,
                  draggable: false,
                  animation: google.maps.Animation.DROP,
                  position: gmap_location_hgr5808a7966a028,
                  icon: ""
                  });

                google.maps.event.addListener(marker_hgr5808a7966a028, "click", function() {
                  if (marker_hgr5808a7966a028.getAnimation() != null) {
                    marker_hgr5808a7966a028.setAnimation(null);
                  } else {
                    marker_hgr5808a7966a028.setAnimation(google.maps.Animation.BOUNCE);
                  }
                });

                var styledMapOptions = {
                  name: "Travel look"
                };

                var customMapType_hgr5808a7966a028 = new google.maps.StyledMapType(featureOpts, styledMapOptions);

                map_hgr5808a7966a028.mapTypes.set(GMAP_MODULE_hgr5808a7966a028, customMapType_hgr5808a7966a028);
              }

              google.maps.event.addDomListener(window, "load", initialize);
}


jQuery('i.fa-vk').on('click', function(){
     window.open('https://vk.com/club142540416', '_blank');
});
jQuery('i.fa-facebook').on('click', function(){
     window.open('https://www.facebook.com/TravelLook.Lviv/', '_blank');
});
jQuery('i.fa-instagram').on('click', function(){
     window.open('https://www.instagram.com/travellook_lviv/', '_blank');
});
// Tabs 
 jQuery('ul.tabs').each(function(){
    var $active, $content, $links = jQuery(this).find('a');

    $active = jQuery('ul.tabs a').first();
   
    $active = jQuery($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
    $active.addClass('active');

    $content = jQuery($active[0].hash);

    $links.not($active).each(function () {
      jQuery(this.hash).hide();
    });

    jQuery(this).on('click', 'a', function(e){
      $active.removeClass('active');
      $content.hide();
      
      $active = jQuery(this);
      $content = jQuery(this.hash);

      $active.addClass('active');
      $content.show();
      
      e.stopPropagation();
      e.preventDefault();
    });
  });