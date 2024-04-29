var j = jQuery.noConflict();

var Configuration = Class.create({
    initialize: function (options) {
        this.containerId = options.containerId;
        this.url = options.url;
        this.checkUrl = options.checkUrl;
        this.formKey = options.formKey;
        this.saveUrl = options.saveUrl;
        this.header = '';
        this.bindEvents();
    },
    bindEvents: function () {
        // console.log(this.formKey);   
        var self = this;
        var brandDropdown = $(this.containerId).down('#brandName');
        brandDropdown.observe('change', self.loadUploadContainer.bind(this));


    },

    loadUploadContainer: function (event) {
        // asdfghj
        $('brand-table').innerHTML = "";
        var self = this;
        // console.log(self.formKey);
        var selectedBrand = event.target.value;

        var formData = new FormData();
        formData.append('brandId', selectedBrand);
        formData.append('form_key', self.formKey);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', this.checkUrl, true);
        // console.log( this.checkUrl);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.headers) {
                        // console.log('Headers:', response);
                        self.createBrandTable(response.headers);
                        self.header = response.headers;
                        self.loadTable(JSON.parse(response.configuration));
                    } else {
                        console.error('Invalid response format:', response);
                    }
                } else {
                    console.error('Failed to retrieve headers:', xhr.status);
                }
            }
        }.bind(this); // Bind the context of the function to 'this'

        xhr.send(formData);

        var fileUploadContainer = $(this.containerId).down('#file-upload-container');

        if (selectedBrand) {
            fileUploadContainer.innerHTML = '<input type="file" id="file-upload" name="file" accept=".csv,.xls,xml"><button id="upload-btn">Upload</button>';
            $('upload-btn').observe('click', self.processFile.bind(this));
        } else {
            fileUploadContainer.innerHTML = '';
        }
    },

    processFile: function (event) {
        var self = this;
        $('brand-table').innerHTML = "";
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


        self.getHeadersFromCSV(file);
    },

    getHeadersFromCSV: function (file) {
        var self = this;
        var formData = new FormData();
        formData.append('file', file);
        formData.append('form_key', this.formKey);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', this.url, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response && response.headers) {
                        // console.log('Headers:', response.headers);
                        self.createBrandTable(response.headers);
                        self.header = response.headers;
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

    createBrandTable: function (headers) {
        var self = this;
        // console.log(this.saveUrl);
        // console.log(headers);

        var parentContainer = $('brand-table');

        var table = document.createElement('table');
        table.border = '1';
        // $('brand-table').appendChild(table);

        var headerRow = document.createElement('tr');


        ['1SBColoumns', 'Brand Coloumns', 'DataType', 'Operators', 'Condition'].forEach(function (headerText) {
            var headerCell = document.createElement('th');
            headerCell.textContent = headerText;
            headerRow.appendChild(headerCell);
        });

        table.appendChild(headerRow);

        var staticValues = ['sku', 'instock', 'instock_qty', 'restock_date', 'restock_qty', 'status', 'discontinued'];
        staticValues.forEach(function (value, index) {
            var row = document.createElement('tr');
            row.setAttribute('name', value);

            var staticCell = document.createElement('td');
            staticCell.textContent = value;
            row.appendChild(staticCell);

            var dropdownCell = document.createElement('td');
            var dropdownSelect = document.createElement('select');

            headers.forEach(function (header) {
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
            dataTypeOptions.forEach(function (optionText) {
                var option = document.createElement('option');
                option.value = optionText;
                option.textContent = optionText;
                dataTypeSelect.appendChild(option);
            });
            dataTypeCell.appendChild(dataTypeSelect);
            row.appendChild(dataTypeCell);

            var operatorsCell = document.createElement('td');
            var operatorsSelect = document.createElement('select');
            ['=', '<', '>', '<=', '>=', '!='].forEach(function (optionText) {
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
            addButton.observe('click', self.addConditionRow);
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
        saveButton.setAttribute('type', 'button');
        saveButton.onclick = () => {
            self.handleSave()
        };
        parentContainer.appendChild(table);
        parentContainer.appendChild(saveButton);


    },

    addConditionRow: function (event) {
        var clickedButton = event.target;
        var clickedRow = clickedButton.parentNode.parentNode;

        // var radioRow = document.createElement('tr');
        var radioCell = document.createElement('p');
        // radioCell.colSpan = 6;

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

        var newRow = document.createElement('tr');
        newRow.setAttribute('name', clickedRow.getAttribute('name'));
        // clickedRow.parentNode.insertBefore(radioRow, clickedRow.nextSibling);


        clickedRow.querySelectorAll('td').forEach(function (cell) {
            var newCell = document.createElement('td');
            newCell.innerHTML = cell.innerHTML;
            newRow.appendChild(newCell);
        });

        newRow.removeChild(newRow.lastElementChild);
        j(newRow).find('td').eq(1).find('select').before(radioCell);
        // console.log( j(newRow).find('td').eq(1));

        var deleteCell = document.createElement('td');
        var deleteButton = document.createElement('button');
        deleteButton.innerText = 'Delete';
        deleteButton.type = 'button';
        deleteButton.addEventListener('click', function () {

            newRow.parentNode.removeChild(newRow);
            // radioRow.parentNode.removeChild(radioRow);
        });
        deleteCell.appendChild(deleteButton);

        newRow.appendChild(deleteCell);

        j(clickedRow).after(newRow);
    },

    prepareArray: function () {
        // console.log(123);
        // var self = this;
        // console.log(this.saveUrl);
        var brandId = j('#brandName').val();
        var configArray = {};
        configArray[brandId] = {};
        j("#configuration-container table tr").not(":first").each(function () {
            var obj = {};
            var tds = j(this).find("td");
            var name = j(this).attr('name');

            var brandCol = tds.eq(1).find('select').val();

            obj[brandCol] =
            {
                'data_type': tds.eq(2).find('select').val(),
                'condition_operator': tds.eq(3).find('select').val(),
                'condition_value': tds.eq(4).find('input').val()
            }


            if (configArray[brandId].hasOwnProperty(name)) {
                var radioValue = tds.eq(1).find('input[type="radio"]:checked').val();
                if (radioValue) {
                    // If radio button is checked, include its value in the object
                    configArray[brandId][name].push(radioValue);
                }
                // If it exists, push the obj to the existing array
                configArray[brandId][name].push(obj);
            } else {
                // If it doesn't exist, create a new array with obj
                configArray[brandId][name] = [obj];
            }
        })
        // console.log(JSON.stringify(configArray));
        return configArray;
    },

    handleSave: function () {
        var self = this;
        // console.log(self.header);
        // return;
        var configurationArray = self.prepareArray();
        // console.log(configurationArray); 
        // return;
        var saveUrl = this.saveUrl;
        // console.log(this.saveUrl);
        var formData = new FormData();
        formData.append('configuration', JSON.stringify(configurationArray));
        formData.append('headers', self.header);
        // console.log(this.currentFile);
        // formData.append('file', this.currentFile[0]);
        formData.append('form_key', this.formKey);
        j.ajax({
            url: saveUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
            },
            error: function (error) {
                alert('Failed to retrieve CSV headers.' + error);
            }
        });
    },

    createRadioInput: function (id, name, value, checked = false) {
        var radioInput = new Element('input');
        radioInput.id = id;
        radioInput.name = name;
        radioInput.type = 'radio';
        radioInput.value = value;
        radioInput.checked = checked;
        return radioInput;
    },

    createLabel: function (text, for_id) {
        var label = new Element('label');
        label.setAttribute('for', for_id);
        label.textContent = text;
        return label;
    },

    createButton: function (text) {
        var button = new Element('button');
        button.textContent = text;
        return button;
    },

    handleDelete: function (button) {
        var currentRow = button.parentNode;
        currentRow.parentNode.removeChild(currentRow);
    },

    loadTable: function (config) {
        var self = this;
        var row_count = 0;

        j('#configuration-container table tr').not(':first').each(function (index, tr) {
            row_count++;
            var rowConfig = config[tr.getAttribute('name')];
            var p;
            var prevRow = tr;
            var row_id = 0;
            rowConfig.forEach(function (row, _index) {
                row_id++;
                if (_index >= 1) {
                    if (row == 'AND' || row == 'OR') {
                        // var row_id = tr.getAttribute("row_id");
                        // var row_count = j("#table-container").children("table").find("tr[class=" + row_id + "]").length;
                        
                        // console.log(row_count);
                        p = new Element('p');
                        p.appendChild(self.createRadioInput("radio_and_" + row_id + "_" + (row_count + 1), 'condition_' + row_id + '_' + (row_count + 1), 'AND', row == 'AND'));
                        p.appendChild(self.createLabel("AND", "radio_and_" + row_id + "_" + (row_count + 1)))
                        p.appendChild(self.createRadioInput("radio_or_" + row_id + "_" + (row_count + 1), 'condition_' + row_id + '_' + (row_count + 1), 'OR', row == 'OR'))
                        p.appendChild(self.createLabel("OR", "radio_or_" + row_id + "_" + (row_count + 1)))
                    } else {
                        var rowClone = tr.cloneNode(true);
                        j(rowClone).find('select').eq(0).before(p);
                        var tds = j(rowClone).find("td");
                        for (var _row in row) {
                            // console.log(row); return;
                            tds.eq(1).find('select').val(_row)
                            tds.eq(2).find('select').val(row[_row]['data_type'])
                            tds.eq(3).find('select').val(row[_row]['condition_operator'])
                            tds.eq(4).find('input').val(row[_row]['condition_value'])
                        }
                        var lastTd = rowClone.lastElementChild;
                        if (lastTd) {
                            rowClone.removeChild(lastTd);
                        }
                        var removeBtn = self.createButton('Delete');
                        removeBtn.observe('click', (event) => {
                            self.handleDelete(event.target);
                        })
                        rowClone.append(new Element('td').appendChild(removeBtn));
                        rowClone.firstChild.innerText = '';

                        $(prevRow).after(rowClone);
                        prevRow = rowClone;
                    }
                }
                else {
                    var tds = j(tr).find("td");
                    for (var _row in row) {
                        tds.eq(1).find('select').val(_row)
                        tds.eq(2).find('select').val(row[_row]['data_type'])
                        tds.eq(3).find('select').val(row[_row]['condition_operator'])
                        tds.eq(4).find('input').val(row[_row]['condition_value'])
                    }
                }
            })
        })
        // console.log(JSON.stringify(self.prepareArray()));
    }
});