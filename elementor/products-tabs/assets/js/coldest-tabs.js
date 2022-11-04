jQuery(document).ready(function () {
    jQuery('.tab-a').click(function (event) {
        event.preventDefault();
        jQuery(".tab").removeClass('tab-active');
        jQuery(".tab[data-id='" + jQuery(this).attr('data-id') + "']").addClass("tab-active");
        jQuery(".tab-a").removeClass('active-a');
        jQuery(this).parent().find(".tab-a").addClass('active-a');
    });
});