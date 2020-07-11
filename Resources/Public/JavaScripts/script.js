$('[hc-wrapper]').find('[hc-href]:not("[hc-active]")').next().hide();

$('[hc-href]').on('click', function (e) {
    e.preventDefault();
    toggle_accordion($(this));
});

function toggle_accordion(that) {
    var hcId = that.attr('hc-href'),
        active = that.attr('hc-active');

    // Slide Clicked Element
    if (active) {
        that.removeAttr('hc-active');
        $('[hc-id="'+hcId+'"]').stop().slideUp();
    } else {
        that.attr('hc-active', true);
        $('[hc-id="'+hcId+'"]').stop().slideDown();
    }
}