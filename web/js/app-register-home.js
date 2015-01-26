/**
 * Some javascript for Register home page
 */

/*jslint regexp: true */
/*global $, L, asCarto, document, register, window */

(function () {
    "use strict";

    var map = asCarto.addMap('map', {
            layer: 'OSM',
            minZoom: 2,
            maxZoom: 8
        }),

        // Path already traveled
        path = L.polyline(register.geoCoords, {
            clickable : false,
            color     : 'blue',
            weight    : 8
        }),

        // The current geo. coordinates on the map
        currentCoords = [0, 0],

        // Marker for the the current geo. coordinates
        marker = L.marker(currentCoords);

    map.addLayer(path).addLayer(marker);

    $(document).ready(function () {

        // Ask for confirmation before to delete a register entry
        $('#register .delete').click(function () {
            return window.confirm(
                register.deleteMessage.replace('ID', $(this).data('id'))
            );
        });

        // Init. DataTable for the list of register entries
        $('#register').DataTable({
            order: [],

            columns: [
                {type: "string"},                     // datetime
                {type: "string", orderable: false},   // geo coords
                {type: "num", orderData: [2, 0]},     // temperature
                {type: "num", orderData: [3, 0]},     // weather
                {type: "string", orderable: false},   // message
                {orderable: false, searchable: false} // actions
            ],

            language: {
                url: $.DataTableLanguage
            },

            lengthMenu: [25, 50, 100]
        });

        /**
         * Hack to a good displaying of the Leaflet map.
         * See: http://stackoverflow.com/questions/20400713/leaflet-map-not-showing-properly-in-bootstrap-3-0-modal
         */
        $('#modal-map').on('shown.bs.modal', function () {
            window.setTimeout(function () {
                map.invalidateSize();
            }, 1);
        });

         // When geo. coordinates are cliked, show them on the "modal map"
        $('.geoCoords').click(function (e) {
            e.preventDefault();

            currentCoords    = String.split($(this).html(), ',');
            currentCoords[0] = parseFloat(currentCoords[0]);
            currentCoords[1] = parseFloat(currentCoords[1]);

            marker.setLatLng(currentCoords);

            map.setView(currentCoords, 6);

            $('#modal-map').modal('show');
        });
    });
}());
