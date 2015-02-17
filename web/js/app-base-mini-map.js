/**
 * Some javascript for Base mini-map page
 */

/*jslint regexp: true */
/*global $, L, asCarto, currentPlace, register */

(function () {
    "use strict";

    // Map centered on the current place
    var map = asCarto.addMap('map', {
            attributionControl: false,
            center: currentPlace,
            controls: { layers: false },
            minZoom: 2,
            maxZoom: 8,
            zoom: 4
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
        $('#last-message').fadeIn(200);
    });

    // Hide the mini-message
    $('#last-message').mouseleave(function () {
        $(this).fadeOut(200);
    });

}());
