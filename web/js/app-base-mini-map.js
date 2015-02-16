/**
 * Some javascript for Base mini-map page
 */

/*jslint regexp: true */
/*global L, asCarto, currentPlace, register */

(function () {
    "use strict";

    // Map centered on the current place
    var map = asCarto.addMap('map', {
            center: currentPlace,
            minZoom: 2,
            maxZoom: 8
        }),

        // Path already traveled
        path = L.polyline(register.geoCoords, {
            clickable : false,
            color     : 'orange',
            weight    : 8
        }).addTo(map),

        marker = L.marker(currentPlace, {
            clickable: false,
            icon: L.AwesomeMarkers.icon({prefix: 'fa', markerColor: 'green', icon: 'bicycle'}),
            zIndexOffset: 1000
        }).addTo(map);

}());
