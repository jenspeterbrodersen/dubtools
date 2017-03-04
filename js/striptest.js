window.onload = function () {

    // Print file properties to screen
    var filename;
    function handleFileSelect(evt) {
        var f = evt.target.files[0];
        document.getElementById('list').innerHTML = 'Filename: <strong>' + f.name;
        filename = f.name;  
        // remove .txt from filename
        filename = filename.replace(/.[^.]*$/, "");
    }

    document.getElementById('inputfile').addEventListener('change', handleFileSelect, false);
    document.getElementById('inputfile').onchange = function () {
       
    // Add each line to array 
    var file = this.files[0];
    var reader = new FileReader();
    
    reader.onload = function (progressEvent) {
        var lines = this.result.split('\n');
        var data = [];

        // Print csv data on page
        div = document.getElementById('csv');
        div.innerHTML = "<div class='col-md-3'><strong>NAME</strong></div><div class='col-md-9'><strong>DIALOGUE</strong></div>";
            for (var line = 0; line < lines.length; line++) {
                check = lines[line];

                if (check.match(/^[0-9]/)) {
                    var arr = check.split(/(\s{4,}|\t+)/g);
                    var arrTrim = arr[2].trim();
                    var name = arr[0].replace(/(\d\w*)/, "").trim();
                    var dial = arrTrim.substr(0, 1).toUpperCase() + arrTrim.substr(1).toLowerCase();
                    // console.log("dial" + "'" + dial + "'")
                    var dial2 = dial.replace(/([!?.]\s+)([a-z])/g, function (m, $1, $2) {
                        return $1 + $2.toUpperCase();
                    });
                    // Create array to send to server
                    data.push([name, dial2]);
                    // console.log("data ", data)

                    div.innerHTML = div.innerHTML + "<div class='col-md-3'>" + name + "</div><div class='col-md-9'>" + dial2 + "</div>";
                    
                    // Consolidate dialogue entries with no charactername
                    for (var i = 0; i < data.length; i++) {
                        if (data[i][0] == "") {
                            data[i - 1][1] = data[i - 1][1] + " " + data[i][1];
                            data.splice(i, 1);
                        }
                    }
                }
            }
        data.push(filename);

        
        // Send array to PHP page
        $.ajax({
            type: 'POST',
            url: 'striptest.php',
            data: {json: JSON.stringify(data)},
            dataType: 'json',
        });

        // Activate the download button
        $('#link').attr("href", "http://www.jenspeter.net/dubtools/strip/"+filename+'.xlsx');
        // $('#link').attr("href", "strip/"+filename+'.xlsx');
        $('#download').show();
     

            // console.log("data", data)

    };
    reader.readAsText(file);
    };
};


