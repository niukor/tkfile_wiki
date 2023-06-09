<?php
function tree($array, $parent, $parts = array(), $step = 0) {

    if (!count($array)) {
        return '';
    }

    $tid = ($step == 0) ? 'id="tree"' : '';
    $t = '<ul class="unstyled" '.$tid.'>';

    foreach ($array as $key => $item) {
        if (is_array($item)) {
            $open = $step !== false && (isset($parts[$step]) && $key == $parts[$step]);

            $t .= '<li class="directory'. ($open ? ' open' : '') .'">';
                $t .= '<a href="#" data-role="directory"><i class="far fa-folder'. ($open ? '-open' : '') .'"></i>&nbsp; ' . $key . '</a>';
                $t .= tree($item, "$parent/$key", $parts, $open ? $step + 1 : false);
            $t .=  '</li>';
        } else {
            $selected = (isset($parts[$step]) && $item == $parts[$step]);
            $t .= '<li class="file'. ($selected ? ' active' : '') .'"><a href="'. $parent .'/'. $item . '">'.$item.'</a></li>';
        }
    }

    $t .= '</ul>';

    return $t;
}
?>

<div id="tree-filter" class="input-group">
  <input type="text" id="tree-filter-query" class="form-control" placeholder="Search file &amp; directory names." aria-label="Search" aria-describedby="search-addon">
  <div class="input-group-append">
    <button type="button" id="tree-filter-clear-query" class="btn  btn-outline-secondary" title="Clear current search..." disabled>
      <i class="fas fa-times"></i>
    </button>
  </div>
</div>

<ul class="unstyled" id="tree-filter-results"></ul>

<?php echo tree($this->_getTree(), BASE_URL, isset($parts) ? $parts : array()); ?>

<script>
    // Case-insensitive alternative to :contains():
    // All credit to Mina Gabriel:
    // http://stackoverflow.com/a/15033857/443373
    $.expr[':'].containsIgnoreCase = function (n, i, m) {
        return jQuery(n).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };

    //enable / disable buttons
    jQuery.fn.extend({
      disable: function(state) {
        return this.each(function() {
            this.disabled = state;
        });
      }
    });

    $(document).ready(function() {
        var iconFolderOpenClass  = 'far fa-folder-open',
            iconFolderCloseClass = 'far fa-folder',

            // Handle live search/filtering:
            tree             = $('#tree'),
            resultsTree      = $('#tree-filter-results')
            filterInput      = $('#tree-filter-query'),
            clearFilterInput = $('#tree-filter-clear-query')
        ;

        // Auto-focus the search field:
        filterInput.focus();

        // Cancels a filtering action and puts everything back
        // in its place:
        function cancelFilterAction()
        {

            filterInput.val('').removeClass('active');
            resultsTree.empty();
            tree.show();
            clearFilterInput.disable(true);
        }

        // Clear the filter input when the X to its right is clicked:
        clearFilterInput.click(cancelFilterAction);


        // Same thing if the user presses ESC and the filter is active:
        $(document).keyup(function(e) {
            e.keyCode == 27 && filterInput.hasClass('active') && cancelFilterAction();
        });

        // Perform live searches as the user types:
        // @todo: check support for 'input' event across more browsers?
        filterInput.bind('input', function() {
            var value         = filterInput.val(),
                query         = $.trim(value),
                isActive      = value != ''
            ;

            // Add a visual cue to show that the filter function is active:
            filterInput.toggleClass('active', isActive);

            clearFilterInput.disable(false);

            // If we have no query, cleanup and bail out:
            if(!isActive) {
                cancelFilterAction();
                return;
            }

            // Hide the actual tree before displaying the fake results tree:
            if(tree.is(':visible')) {
                tree.hide();
            }

            // Sanitize the search query so it won't so easily break
            // the :contains operator:
            query = query
                        .replace(/\(/g, '\\(')
                        .replace(/\)/g, '\\)')
                    ;

            // Get all nodes containing the search query (searches for all a, and returns
            // their parent nodes <li>).
            resultsTree.html(tree.find('a:containsIgnoreCase(' + query + ')').parent().clone());
        });

        // Handle directory-tree expansion:
        $(document).on('click', '#sidebar a[data-role="directory"]', function (event) {
            event.preventDefault();

            var icon = $(this).children('.far');
            var open = icon.hasClass(iconFolderOpenClass);
            var subtree = $(this).siblings('ul')[0];

            icon.removeClass(iconFolderOpenClass).removeClass(iconFolderCloseClass);

            if (open) {
                if (typeof subtree != 'undefined') {
                    $(subtree).slideUp({ duration: 100 });
                }
                icon.addClass(iconFolderCloseClass);
            } else {
                if (typeof subtree != 'undefined') {
                    $(subtree).slideDown({ duration: 100 });
                }
                icon.addClass(iconFolderOpenClass);
            }
        });
    });
</script>
