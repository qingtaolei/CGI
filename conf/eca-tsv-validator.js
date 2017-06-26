function ECAVariantValidator(options) {
    if (!(this instanceof ECAVariantValidator)) {
        return new ECAVariantValidator(options);
    }
    Validator.call(this, options);

    // this._header = true;
    this._duplicates = {};
    this._sorted = true;
    this._columnsSize = null;

}

ECAVariantValidator.prototype = Object.create(Validator.prototype);

ECAVariantValidator.prototype.validateLine = function (line) {

    if (this.isHeaderLine(line)) { // parse Header
        this.parseHeader(line);
    } else {
        this.parseData(line);
    }

}

ECAVariantValidator.prototype.isHeaderLine = function () {
    return this.line === 1;
}
ECAVariantValidator.prototype.validateEnd = function () {
    if (this.numLines < 2) {
        this.addLog("error", "The file contains one line or less.");
    }
}

ECAVariantValidator.prototype.parseHeader = function (line) {
    var cols = line.split('\t');
    this._columnsSize = cols.length;

    if (cols.length != 6) {
        this.addLog("error", "Header columns should include 6 columns.");
    } else {
        var v = parseFloat(cols[1]);
        if (isNaN(v)) {

        } else {
            this.addLog("warning", "Header could not be set correctly, sample names seems to be numbers.")
        }
    }
}

ECAVariantValidator.prototype.parseData = function (line) {

    if (line == "") {
        this.addLog("warning", "Empty line.");
    }else{
        var columns = line.split("\t");

        if (this._columnsSize !== columns.length) {
            this.addLog("error", "Column length must be same as the header column length.");
        } else {
            if (columns.length > 1) {
                var found = false;
                for (var i = 1; i < columns.length; i++) {
                    var c = columns[i];
                    var v = parseFloat(c);
                    /*if (isNaN(v)) {
                        found = true;
                        break;
                    }*/
                }
                /*if (found) {
                    this.addLog("error", "Column values must be numbers");
                }*/
            } else {
                this.addLog("error", "Number of columns must be 6.");
            }
        }
    }



    // this.addLog("info", "checking line");

    // if (this._columnsSize == null) {
    //     this._columnsSize = columns.length;
    // }
    //
    // if (columns.length < 3) {
    //     this.addLog("error", "Must contain at least 3 columns");
    // }
    //
    // if (this._columnsSize != columns.length) {
    //     this.addLog("error", "All ines must have the same number of columns");
    // }
    //
    // // Chromosome
    // var chr = columns[0];
    // if (chr == "") {
    //     this.addLog("error", "Chromosome must not be empty");
    // }
    //
    // if (chr.search(" ") >= 0) {
    //     this.addLog("error", "Chromosome must not contain whitespaces");
    // }
    //
    // // Start
    // var start = columns[1]
    // if (start == "") {
    //     this.addLog("error", "Start must not be empty");
    // }
    // start = parseInt(start)
    // if (isNaN(start)) {
    //     this.addLog("error", "Start must be numeric");
    // } else {
    //     if (start < 0) {
    //         this.addLog("error", "Start must be greater or equal than 0");
    //     }
    // }
    //
    // // Start
    // var end = columns[1]
    // if (end == "") {
    //     this.addLog("error", "End must not be empty");
    // }
    // end = parseInt(end)
    // if (isNaN(end)) {
    //     this.addLog("error", "End must be numeric");
    // } else {
    //     if (end < 0) {
    //         this.addLog("error", "End must be greater or equal than 0");
    //     }
    //     if (end > start) {
    //         this.addLog("error", "End must be greater or equal than Start");
    //     }
    // }

}
