/**
 * Some javascript for Base map page
 */

/*jslint regexp: true */
/*global L, asCarto, register, getClusterLabel, OverlappingMarkerSpiderfier */

(function () {
    "use strict";

    var map = asCarto.addMap('map', {
            layer: 'Outdoors',
            controls: {pan: true, scale: true, zoomslider: true}
        }),

        // Path already traveled
        path = L.polyline(register.geoCoords, {
            clickable : false,
            color     : '#eca34c',
            weight    : 8
        }),

        // Entries of the travel register are clustered
        cluster = L.markerClusterGroup({
            showCoverageOnHover: false,
            disableClusteringAtZoom: 10
        }),

        // Some icons
        globeIcon        = L.AwesomeMarkers.icon({prefix: 'fa', markerColor: 'darkgreen', icon: 'globe'}),
        envelopeIcon     = L.AwesomeMarkers.icon({prefix: 'fa', markerColor: 'darkgreen', icon: 'envelope-o'}),
        currentPlaceIcon = L.AwesomeMarkers.icon({prefix: 'fa', markerColor: 'green',     icon: 'bicycle'}),

        // Various variables
        i,
        currentPlace,
        marker,
        markers = [],
        popup = new L.Popup({minWidth: 120, maxWidth: 400});

    /**
     * Create a marker for each travel register entry.
     * Then, add it to the cluster.
     */
    for (i = 1; i < register.geoCoords.length; i += 1) {
        markers.push(
            L.marker(register.geoCoords[i])
                .setIcon(register.hasMessage[i] ? envelopeIcon : globeIcon)
                .bindLabel(register.labels[i])
        );
    }
    cluster.addLayers(markers);

    /**
     * Add the current place
     */
    currentPlace = L.marker(register.geoCoords[0], {zIndexOffset: 100})
        .setIcon(currentPlaceIcon)
        .bindLabel(register.labels[0])
        .addTo(map);

    // When clicked => zoom in on it !
    currentPlace.on('click', function () {
        map.setView(currentPlace.getLatLng(), Math.max(12, map.getZoom()));
    });

    // Initially, center the map onto this current place.
    map.setView(currentPlace.getLatLng(), 5, {reset: true});

    /**
     * For each cluster, display (on "mouseover" event) an overview of its markers.
     */
    cluster.on('clustermouseover', function (e) {
        if (!e.layer.getLabel()) {
            e.layer.bindLabel(
                getClusterLabel(e.layer.getAllChildMarkers())
            );
        }
    });

    /**
     * Under the zoom level 5, hide the cluster of travel register entries.
     */
    map.on('zoomend', function () {
        if (map.getZoom() < 5) {
            if (map.hasLayer(cluster)) {
                // removeLayer() will remove marker labels too :-(
                map.removeLayer(cluster);
            }
        } else {
            if (!map.hasLayer(cluster)) {
                // For each marker, re-bind label
                for (i = 1; i < register.geoCoords.length; i += 1) {
                    markers[i-1].bindLabel(register.labels[i]);
                }
                map.addLayer(cluster);
            }
        }
    });

    /**
     * Finally, add layers
     */
    map.addLayer(path).addLayer(cluster);

}());
