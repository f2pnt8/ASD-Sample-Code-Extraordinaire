/**
 * JS for the Admin Edit Pages
 *
 * @author: Alex Stillwagon
 * @package ASD Photo Catalog
 * Author URI: http://alexstillwagon.com
 * @version: 1.1
 */
jQuery(document).ready(function ($) {
    /* Remove option to delete the General Category */

    // Find the General Category Delete button and remove it
    $('.edit-tags-php.taxonomy-asd_photo_catalog').find('table.wp-list-table').find('span.view a[href*="/asd_photo_catalog/general/"]').parent().parent().find('span.delete').remove();

    // Find the Bulk Edit select box the General Category  and remove it
    $('#the-list').find('label:contains("Select General") + input').remove();

    /* Set the Map Category to 'General' automatically for all New Places */

    // Setup vars
    let $checkbox = $('#asd_photo_catalog-checklist');

    // If on Edit Place Page
    if ( $checkbox.length ) {

        // Check if any Category is already chosen
        let atLeastOneIsChecked = $checkbox.find(':checkbox:checked').length > 0;

        // If no Category is already chosen
        if ( ! atLeastOneIsChecked ) {

            // Find the General Category
            $checkbox.find('label').each(function() {
                if ( $( this ).text() === ' General' ) {
                    // Choose the 'General' Category
                    $( this ).find('input').prop( "checked", true );
                }
            });
        }
    }

});