/**
 * Some global/bulk javascript
 */

/*global document, $ */

(function () {
    "use strict";

    $(document).ready(function () {
        $('body').tooltip({
            container: 'body',
            selector: '[title]'
        });
    });

}());
