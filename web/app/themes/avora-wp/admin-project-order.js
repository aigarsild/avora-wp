(function($) {
    $(function() {
        var $table = $('#the-list');
        if (!$table.length) return;

        // Only enable on Projects list
        var postType = new URLSearchParams(window.location.search).get('post_type');
        if (postType !== 'project') return;

        $table.sortable({
            items: '> tr',
            cursor: 'move',
            axis: 'y',
            containment: 'parent',
            helper: function(e, ui) {
                ui.children().each(function() {
                    $(this).width($(this).width());
                });
                return ui;
            },
            update: function() {
                var orderedIds = $table.sortable('toArray', { attribute: 'id' })
                    .map(function(id) {
                        // IDs are in the form 'post-123'
                        var m = String(id).match(/post-(\d+)/);
                        return m ? parseInt(m[1], 10) : null;
                    })
                    .filter(function(v){ return v !== null; });

                $.post(AvoraOrder.ajaxUrl, {
                    action: 'avora_update_project_order',
                    nonce: AvoraOrder.nonce,
                    order: orderedIds
                });
            }
        });
    });
})(jQuery);


