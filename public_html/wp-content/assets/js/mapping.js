var SITE_URL = 'http://'+window.location.hostname+'/';
var global_obj = {};
var globalSector = '';
var globalZoom = '';
var globalLatLng = '';

var $ = jQuery;
var mapStyle =[
   {  
      "featureType":"administrative",
      "elementType":"labels.text.fill",
      "stylers":[  
         {  
            "color":"#02215d"
         }
      ]
   },

      {  
      "featureType":"landscape",
      "elementType":"all",
      "stylers":[  
         {  
            "color":"#f2f2f2"
         }
      ]
   },
   {  
      "featureType":"poi",
      "elementType":"all",
      "stylers":[  
         {  
            "visibility":"off"
         }
      ]
   },
   {  
      "featureType":"poi.park",
      "elementType":"geometry",
      "stylers":[  
         {  
            "color":"#d2d2d2"
         },
          {  
            "visibility":"on"
         }
      ]
   },
   {  
      "featureType":"poi.business",
      "elementType":"geometry",
      "stylers":[  
         {  
            "color":"#d2d2d2"
         },
          {  
            "visibility":"on"
         }
      ]
   },
      {  
      "featureType":"poi",
      "elementType":"labels",
      "stylers":[  
          { 
            "saturation": -100 
          },
          { 
            "lightness" : 20 
          },
          {
           "visibility" : 'on' 
         }
      ]
   },
   {  
      "featureType":"road",
      "elementType":"geometry",
      "stylers":[  
         {  
            "saturation": -100
         },
         {  
            "lightness": 45
         },
         {
           "hue" : 0
         },
         {
            "gamma" : 1.0
         }
      ]
   },
   {  
      "featureType":"road.highway",
      "elementType":"all",
      "stylers":[  
         {  
            "visibility":"on"
         }
      ]
   },
      {  
      "featureType":"road.highway",
      "elementType":"labels.icon",
      "stylers":[
          { 
            "saturation": -100 
          },
          { 
            "lightness" : 20
          },
          {
           "visibility" : 'off' 
         }
      ]
   },
   {  
      "featureType":"road.highway.controlled_access",
      "elementType":"labels.icon",
      "stylers":[  
          { 
            "saturation": -100 
          },
          { 
            "lightness" : 20 
          },
          {
           "visibility" : 'on' 
         }
      ]
   },
   {  
      "featureType":"road.highway",
      "elementType":"geometry.fill",
      "stylers":[  
         {  
            "color":"#02215d"
         }
      ]
   },
   {  
      "featureType":"road.highway",
      "elementType":"labels.text",
      "stylers":[  
         {  
            "color":"#ffffff"
         }
      ]
   },
  {  
      "featureType":"road.highway",
      "elementType":"labels.text.stroke",
      "stylers":[  
         {  
            "visibility":"off"
         }
      ]
   },
   {  
      "featureType":"road.arterial",
      "elementType":"labels.icon",
      "stylers":[  
         {  
            "visibility":"off"
         }
      ]
   },
   {  
      "featureType":"transit",
      "elementType":"all",
      "stylers":[  
         {  
            "visibility":"off"
         },
         {  
            "color":"#138995"
         }
      ]
   },
   {  
      "featureType":"transit.line",
      "elementType":"all",
      "stylers":[  
         {  
            "color":"#138995"
         },
         {  
            "visibility":"off"
         }
      ]
   },
   {  
      "featureType":"transit.line",
      "elementType":"geometry",
      "stylers":[  
         {  
            "visibility":"on"
         },
         {  
            "color":"#138995"
         }
      ]
   },
   {  
      "featureType":"transit.line",
      "elementType":"geometry.fill",
      "stylers":[  
         {  
            "color":"#138995"
         }
      ]
   },
   {  
      "featureType":"transit.station.rail",
      "elementType":"all",
      "stylers":[  
         {  
            "visibility":"off"
         },
         {  
            "color":"#138995"
         }
      ]
   },
   {  
      "featureType":"transit.station.rail",
      "elementType":"geometry",
      "stylers":[  
         {  
            "color":"#138995"
         },
         {  
            "visibility":"on"
         }
      ]
   },
   {  
      "featureType":"transit.station.rail",
      "elementType":"geometry.fill",
      "stylers":[  
         {  
            "color":"#138995"
         },
         {  
            "visibility":"on"
         }
      ]
   },
   {  
      "featureType":"water",
      "elementType":"geometry",
    "stylers": [
        { "color": "#a6ddee" },

      ]
   },
   {
        "featureType": "transit.station.airport",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "color": "#d2d2d2"
            }
        ]
    }
]



$.ajax({
    type: "GET",
    url: SITE_URL + "api/core/get_category_posts/?slug=relax",
    contentType: "application/json",
    processData: false,
    cache: false,
    success: function(propertyJSON) {
        global_obj = propertyJSON.posts;
        console.log(global_obj)
        initMap();
    },
    error: function(e) {
        console.log(e.message);
    }
});

function ZoomControl(controlDiv, map) {

  // Creating divs & styles for custom zoom control
  controlDiv.style.padding = '5px';

  // Set CSS for the control wrapper
  var controlWrapper = document.createElement('div');
  controlWrapper.style.backgroundColor = 'transparent';

  controlWrapper.style.cursor = 'pointer';
  controlWrapper.style.textAlign = 'center';
  controlWrapper.style.width = '3.28125vw';
  controlWrapper.style.height = '6.56vw';
  if ($( window ).width() < 670) {
    controlWrapper.style.width = '9.84375vw';
    controlWrapper.style.height = '19.6875vw';
  }
  controlWrapper.style.marginRight = '24px';
  controlWrapper.style.marginBottom = '21px';
  controlDiv.appendChild(controlWrapper);

  // Set CSS for the zoomIn
  var zoomInButton = document.createElement('div');
  zoomInButton.style.width = '3.28125vw';
  zoomInButton.style.height = '3.28125vw';
  if ($( window ).width() < 670) {
    zoomInButton.style.width = '9.84375vw';
    zoomInButton.style.height = '9.84375vw';
  }
  zoomInButton.style.marginBottom = '0.67vw';
  zoomInButton.style.borderRadius = '50%';
  /* Change this to be the .png image you want to use */
  zoomInButton.style.backgroundImage = 'url("/wp-content/assets/images/zoom_in.png")';
  controlWrapper.appendChild(zoomInButton);
  zoomInButton.style.backgroundSize = 'cover';

  // Set CSS for the zoomOut
  var zoomOutButton = document.createElement('div');
  zoomOutButton.style.width = '3.28125vw';
  zoomOutButton.style.height = '3.28125vw';
  if ($( window ).width() < 670) {
    zoomOutButton.style.width = '9.84375vw';
    zoomOutButton.style.height = '9.84375vw';
  }
  controlWrapper.style.marginRight = '15px';
  zoomOutButton.style.borderRadius = '50%';
  /* Change this to be the .png image you want to use */
  zoomOutButton.style.backgroundImage = 'url("/wp-content/assets/images/zoom_out.png")';
  controlWrapper.appendChild(zoomOutButton);
  zoomOutButton.style.backgroundSize = 'cover';

  // Setup the click event listener - zoomIn
  google.maps.event.addDomListener(zoomInButton, 'click', function() {
    map.setZoom(map.getZoom() + 1);
  });

  // Setup the click event listener - zoomOut
  google.maps.event.addDomListener(zoomOutButton, 'click', function() {
    map.setZoom(map.getZoom() - 1);
  });

}



function initMap(sector, zoom, myLatLng) {
    console.log(sector)
    sector = sector || 'Europe'
    globalSector = sector;
    zoom = zoom || 5;
    globalZoom = zoom;
    myLatLng = myLatLng || {lat: 48.9148213, lng: 16.2493038};
    globalLatLng = myLatLng;
    var map = new google.maps.Map(document.getElementById('relaxMap'), {
      zoom: zoom,
      center: myLatLng,
      disableDefaultUI: true,
      scrollwheel: false
    });
    styledMap = new google.maps.StyledMapType(mapStyle, {
        name: 'Styled Map'
    });
    map.mapTypes.set('map-style', styledMap);
    map.setMapTypeId('map-style');
    
    // Markers
    var markersLatLng = {};
    for (i in global_obj) {
      if (sector == global_obj[i].custom_fields.sector.join()) {
        markersLatLng['position'+i] = {
          lat:parseFloat(global_obj[i].custom_fields.coords_lat),
          lng:parseFloat(global_obj[i].custom_fields.coords_lng)
        };
      } else if (sector == 'All') {
        markersLatLng['position'+i] = {
          lat:parseFloat(global_obj[i].custom_fields.coords_lat),
          lng:parseFloat(global_obj[i].custom_fields.coords_lng)
        };
      }
    }

    var markers = {};
    for (i in global_obj) {
      // Icon Url
      var iconURL = '/wp-content/assets/images/marker.png';
      // if (global_obj[i].custom_fields.sector.join() == 'Europe') {iconURL = '/wp-content/assets/images/marker.png';}
      // if (global_obj[i].custom_fields.sector.join() == 'Asia') {iconURL = '/wp-content/assets/images/orange.png';}

      if (sector == global_obj[i].custom_fields.sector.join()) {
        markers["marker"+i] = new google.maps.Marker({
          position: markersLatLng["position"+i],
          map: map,
          icon: iconURL
        })
      } else if (sector == 'All') {
        markers["marker"+i] = new google.maps.Marker({
          position: markersLatLng["position"+i],
          map: map,
          icon: iconURL
        })
      }
    }

    // Window content
    function getConcatValue(object) {
        console.log(object)
        return ['<div id="content" style="width:auto;max-height:auto;">',
          '<h4>'+object.title+'</h4>',
          '<img src="'+object.thumbnail+'" style="margin:0" id="firstHeading" class="firstHeading">',
          '<div id="bodyContent">',
            '<a target="_blank" href="'+object.url+'">',
              'Читати',
            '</a>',
          '</div>',
        '</div>'].join('');
    }
    var content = [];
    for (i in global_obj) {
      if (sector == global_obj[i].custom_fields.sector.join()) {
        content[i] = getConcatValue(global_obj[i])
      } else if (sector == 'All') {
        content[i] = getConcatValue(global_obj[i])
      }
    }
    var lastOpenedInfoWindow = false;

     //Info Window
    var markerWindows = [];
    for (i in global_obj) {
      if (sector == global_obj[i].custom_fields.sector.join()) {
        markerWindows["window"+i] = new google.maps.InfoWindow({
          content: content[i]
        });
         google.maps.event.addListener(markerWindows["window"+i],'domready',function(){ 
            $('.gm-style-iw')//the root of the content
              .addClass('custom-iw');
          });
      } else if (sector == 'All') {
        markerWindows["window"+i] = new google.maps.InfoWindow({
          content: content[i]
        });
         google.maps.event.addListener(markerWindows["window"+i],'domready',function(){ 
            $('.gm-style-iw')//the root of the content
              .addClass('custom-iw');
          });
      }
    }
   
    for (var i in markers) {
      (function(i){
        markers[i].addListener('click', function() {
          closeLastOpenedInfoWindow();
          markerWindows["window"+i.slice(6)].open(map, markers[i]);
          lastOpenedInfoWindow = markerWindows["window"+i.slice(6)];
        });
      })(i);
    }
    function closeLastOpenedInfoWindow() {
      if (lastOpenedInfoWindow) {
          lastOpenedInfoWindow.close();
      }
    }
    
    google.maps.event.addListener(map, "click", function(event) {
      closeLastOpenedInfoWindow();
    });
    // Create the DIV to hold the control and call the ZoomControl() constructor
    // passing in this DIV.
    var zoomControlDiv = document.createElement('div');
    var zoomControl = new ZoomControl(zoomControlDiv, map);

    zoomControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(zoomControlDiv);
}