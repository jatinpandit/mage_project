var j = jQuery.noConflict();

var Configuration = Class.create({
    initialize: function(options) {
        this.containerId = options.containerId;
        this.url = options.url;
        this.formKey = options.formKey;
        this.bindEvents();
    },
    bindEvents: function() {
        // console.log(this.formKey);   
        var brandDropdown = $(this.containerId).down('#brandName');
        brandDropdown.observe('change', this.loadUploadContainer.bind(this));
    },

    loadUploadContainer: function(event) {
        var selectedBrand = event.target.value;
        var fileUploadContainer = $(this.containerId).down('#file-upload-container');

        if (selectedBrand) {
            fileUploadContainer.innerHTML = '<input type="file" id="file-upload" name="file" accept=".csv,.xls,xml"><button id="upload-btn">Upload</button>';
            $('upload-btn').observe('click', this.processFile.bind(this));
        } else {
            fileUploadContainer.innerHTML = '';
        }
    },

    processFile: function(event) {
        event.preventDefault();
        var fileInput = $('file-upload');
        var file = fileInput.files[0];

        if (!file) {
            alert('Please select a file.');
            return;
        }

        if (!file.name.toLowerCase().endsWith('.csv')) {
            alert('Please select a valid CSV file.');
            return;
        }

        var formData = new FormData();
        formData.append('file', file);
        

        this.getHeadersFromCSV(file);
    },

    getHeadersFromCSV: function(file) {
        var formData = new FormData();
        formData.append('file', file);
        formData.append('form_key', this.formKey);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', this.url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.headers) {
                        // console.log('Headers:', response.headers);
                        this.createBrandTable(response.headers); 
                    } else {
                        console.error('Invalid response format:', response);
                    }
                } else {
                    console.error('Failed to retrieve headers:', xhr.status);
                }
            }
        }.bind(this); // Bind the context of the function to 'this'

        xhr.send(formData);
    },

    createBrandTable: function(headers) {
        
        var parentContainer = $(this.containerId);
    
        var table = document.createElement('table');
        table.border = '1';
        
        var headerRow = document.createElement('tr');
    
        
        ['1SBColoumns', 'Brand Coloumns', 'DataType', 'Operators', 'Condition'].forEach(function(headerText) {
            var headerCell = document.createElement('th');
            headerCell.textContent = headerText;
            headerRow.appendChild(headerCell);
        });
        
        table.appendChild(headerRow);
    
        var staticValues = ['sku', 'instock', 'instock qty', 'Restock Date', 'Restock Qty', 'Status', 'Discontinued'];
        staticValues.forEach(function(value) {
            var row = document.createElement('tr');
    
            var staticCell = document.createElement('td');
            staticCell.textContent = value;
            row.appendChild(staticCell);

            var dropdownCell = document.createElement('td');
            var dropdownSelect = document.createElement('select');
            
            headers.forEach(function(header) {
                var option = document.createElement('option');
                option.value = header;
                option.textContent = header;
                dropdownSelect.appendChild(option);
            });
            
            
            dropdownCell.appendChild(dropdownSelect);
            row.appendChild(dropdownCell);
    
        var dataTypeCell = document.createElement('td');
        var dataTypeSelect = document.createElement('select');
        var dataTypeOptions = ['Number', 'Date', 'Count', 'Text'];
        dataTypeOptions.forEach(function(optionText) {
            var option = document.createElement('option');
            option.value = optionText;
            option.textContent = optionText;
            dataTypeSelect.appendChild(option);
        });
        dataTypeCell.appendChild(dataTypeSelect);
        row.appendChild(dataTypeCell);

        var operatorsCell = document.createElement('td');
        var operatorsSelect = document.createElement('select');
        ['=','<', '>','<=','>=','!='].forEach(function(optionText) {
            var option = document.createElement('option');
            option.value = optionText;
            option.textContent = optionText;
            operatorsSelect.appendChild(option);
        });
        operatorsCell.appendChild(operatorsSelect);
        row.appendChild(operatorsCell);

        var conditionCell = document.createElement('td');
        var textBox = document.createElement('input');
        textBox.setAttribute('type', 'text');
        conditionCell.appendChild(textBox);
        row.appendChild(conditionCell);
    
            var blankCell = document.createElement('td');
            var addButton = document.createElement('button');
            addButton.observe('click', Configuration.prototype.addConditionRow);
            addButton.innerText = 'Add';
            addButton.setAttribute('type', 'button'); 
            // addButton.setAttribute('value', 'Add'); 
            // addButton.setAttribute('name', 'Add'); 
            blankCell.appendChild(addButton);
            row.appendChild(blankCell);
            
            
            table.appendChild(row);
            // addButton.observe('click', Configuration.addConditionRow.bind(this));
        });
        var saveButton = document.createElement('button');
        saveButton.innerText = 'Save';
        saveButton.setAttribute('type','button');

        parentContainer.appendChild(table);
        parentContainer.appendChild(saveButton);
    },

    // addConditionRow: function(event) {
    //     var clickedButton = event.target;
    //     var clickedRow = clickedButton.parentNode.parentNode;

        
    //     var newRow = clickedRow.cloneNode(  );
    //     clickedRow.parentNode.insertBefore(newRow, clickedRow.nextSibling);
    // }
    addConditionRow : function(event) {
        var clickedButton = event.target;
        var clickedRow = clickedButton.parentNode.parentNode;

        var radioRow = document.createElement('tr');
        var radioCell = document.createElement('td');
        radioCell.colSpan = 6;
    
        var andRadioButton = document.createElement('input');
        andRadioButton.type = 'radio';
        andRadioButton.name = 'conditionRadio_' + Date.now();
        andRadioButton.value = 'AND';
        var andLabel = document.createElement('label');
        andLabel.textContent = 'AND';
        andLabel.htmlFor = 'and-radio-' + Date.now();
    
        var orRadioButton = document.createElement('input');
        orRadioButton.type = 'radio';
        orRadioButton.name = 'conditionRadio_' + Date.now();
        orRadioButton.value = 'OR';
        var orLabel = document.createElement('label');
        orLabel.textContent = 'OR';
        orLabel.htmlFor = 'or-radio-' + Date.now;
    
        radioCell.appendChild(andRadioButton);
        radioCell.appendChild(andLabel);
        radioCell.appendChild(orRadioButton);
        radioCell.appendChild(orLabel);
    
        radioRow.appendChild(radioCell);
    
        clickedRow.parentNode.insertBefore(radioRow, clickedRow.nextSibling);
    
        var newRow = document.createElement('tr');
    
        clickedRow.querySelectorAll('td').forEach(function(cell) {
            var newCell = document.createElement('td');
            newCell.innerHTML = cell.innerHTML;
            newRow.appendChild(newCell);
        });

        newRow.removeChild(newRow.lastElementChild);
        
        var deleteCell = document.createElement('td');
        var deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.type = 'button';
        deleteButton.addEventListener('click', function() {

            newRow.parentNode.removeChild(newRow);
            radioRow.parentNode.removeChild(radioRow);
        });
        deleteCell.appendChild(deleteButton);
    
        newRow.appendChild(deleteCell);
    
        clickedRow.parentNode.insertBefore(newRow, radioRow.nextSibling);
    }
    

});