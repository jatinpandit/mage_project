console.log(123);
function createDropdown() {
    // Create a select element
    var select = document.createElement('select');
    
    // Create some options and append them to the select element
    var options = ['Option 1', 'Option 2', 'Option 3'];
    options.forEach(function(optionText) {
        var option = document.createElement('option');
        option.text = optionText;
        select.add(option);
    });
    
    // Append the select element to the body
    document.body.appendChild(select);
}

// Call the function to create the dropdown menu
createDropdown();