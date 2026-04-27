// Iterate over each select element
$('select').each(function () {
    var $this = $(this),
        numberOfOptions = $this.children('option').length;

    // Hides the select element
    $this.addClass('s-hidden');

    // Wrap the select element in a div
    $this.wrap('<div class="select"></div>');

    // Insert a styled div to sit over the top of the hidden select element
    $this.after('<div class="styledSelect"></div>');

    // Cache the styled div
    var $styledSelect = $this.next('div.styledSelect');

    // Show the first select option in the styled div
    $styledSelect.text($this.children('option:selected').text());

    // Insert an unordered list after the styled div and also cache the list
    var $list = $('<ul />', { 'class': 'options' }).insertAfter($styledSelect);

    // Insert a list item into the unordered list for each select option
    for (var i = 0; i < numberOfOptions; i++) {
        var $option = $this.children('option').eq(i);
        $('<li />', {
            text: $option.text(),
            rel: $option.val(),
            class: $option.is(':disabled') ? 'disabled' : '' // Add "disabled" class if option is disabled
        }).appendTo($list);
    }

    // Cache the list items
    var $listItems = $list.children('li');

    // Set initial border color if the default option is disabled
    if ($this.children('option:selected').is(':disabled')) {
        $styledSelect.css('border', '3px solid red');
    }

    // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
    $styledSelect.click(function (e) {
        if ($this.is('[disabled]')) {
            return; // If the element has "disabled" attribute, do nothing
        }
        e.stopPropagation(); // Prevent event propagation
        $('div.styledSelect.active').each(function () {
            if ($(this)[0] !== $styledSelect[0]) { // If it's not the currently clicked div, hide it
                $(this).removeClass('active').next('ul.options').hide();
            }
        });
        $(this).toggleClass('active').next('ul.options').toggle();
    });

    // Update original select and styled div on list item click
    $listItems.click(function (e) {
        if ($(this).hasClass('disabled')) {
            e.preventDefault(); // Block disabled items
            return;
        }
        e.stopPropagation();

        // Update the styled select text
        $styledSelect.text($(this).text()).removeClass('active');

        // Update the hidden select element
        $this.val($(this).attr('rel')).change(); // Trigger "change" event on original select

        // Hide the options list
        $list.hide();

        // Update border based on the selected option
        if ($this.children('option:selected').is(':disabled')) {
            $styledSelect.css('border', '3px solid red');
        } else {
            $styledSelect.css('border', '');
        }
    });

    // Hide the list when clicking outside of it
    $(document).click(function (e) {
        if (!$(e.target).closest('.select').length) { 
            $('div.styledSelect.active').removeClass('active');
            $('ul.options').hide();
        }
    });
});
