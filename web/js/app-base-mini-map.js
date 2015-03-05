/**
 * Some javascript for Base mini-map page
 */

/*jslint regexp: true */
/*global $, L, currentPlace, register */

(function () {
    "use strict";

    // Map centered on the current place
    var map = L.easyMap('map', {
            baseLayer: 'WaterColor',
            center: currentPlace,
            controls: { attribution: false, layers: false },
            minZoom: 2,
            maxZoom: 8,
            zoom: 6
        }),

        // Path already traveled
        path = L.polyline(register.geoCoords, {
            clickable : false,
            color     : 'darkorange',
            opacity   : 0.7,
            weight    : 8
        }).addTo(map),

        marker = L.marker(currentPlace, {
            icon: L.AwesomeMarkers.icon({prefix: 'fa', markerColor: 'green', icon: 'bicycle'}),
            zIndexOffset: 1000
        }).addTo(map);

    // Show the mini-message
    marker.on('mouseover', function () {
        $('#mini-message').fadeIn(200);
    });

    // Hide the mini-message
    $('#mini-message').mouseleave(function () {
        $(this).fadeOut(200);
    });

}());
