window.onload = function () {

    // print file properties to screen
    var filename;  
    function handleFileSelect(evt) {
        var f = evt.target.files[0];
        document.getElementById('list').innerHTML = 'Source file: <strong>' + f.name;
        filename = f.name;   
    }

    document.getElementById('inputfile').addEventListener('change', handleFileSelect, false);
    document.getElementById('inputfile').onchange = function () {
       
        // Add each line to array 
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function (progressEvent) {
            //   Match name, tcin, tcout and duration
            var newLines = [];
            var names = [];
            var lines = this.result.split('\n');
            var epsdur = 0;
 
            for (var line = 0; line < lines.length; line++) {
                check = lines[line];
            
                if (check.match(/^1/)) {
                    var split = check.split(/\t/);
                    var name = split[2].replace(/char_/, "").trim();
                    var tcin = split[3].trim();
                    var tcout = split[4].trim();
                    var duration = split[5]

                    // convert tcin to sec for sorting
                    var _ti_sec = tcin.split(':');
                    var ti_sec = (+_ti_sec[0]) * 60 * 60 + (_ti_sec[1]) * 60 + (_ti_sec[2]);
                    // do the same for duration 
                    var _duration_sec = duration.split(':');
                    var duration_sec = parseInt(_duration_sec[1]) * 60 + parseInt(_duration_sec[2]);
                   
                    // keep accumulated duration time, but skip movies
                    if (duration_sec > 500) {
                        //   console.log(name, duration_sec)
                        continue;
                    } else {                  
                        epsdur = epsdur + duration_sec;
                    }
                    
                    // clean up name
                    name = name.replace(/_\d{2,3}|-\d{2,3}/g, "");
                    name = name.replace(/\.dup\d{0,3}/g, "")
                    newLines.push({ ti_sec, tcin, tcout,name, duration, duration_sec });
                    names.push(name);
                }
            }

        // sort array by tcin seconds
        newLines.sort(function (a, b) {
            return a.ti_sec - b.ti_sec;
        });

        // print csv data on page
        div = document.getElementById('csv');
        div.innerHTML = "<div class='col-md-3'><strong>TC-IN</strong></div><div class='col-md-3'><strong>TC - OUT</strong></div><div class='col-md-6'><strong>CHARACTER</strong></div>";

        var csvObj = [];

        for (var i = 0; i < newLines.length; i++){
            div.innerHTML = div.innerHTML + "<div class='col-md-3'>" + newLines[i].tcin + "</div><div class='col-md-3'>" + newLines[i].tcout + "</div><div class='col-md-6'>" + newLines[i].name + "</div>";

            // Create array to send to server
            csvObj.push(["spotting", newLines[i].tcin, newLines[i].tcout, newLines[i].name]);
        };

        // remove .txt from filename
        filename = filename.replace(/.[^.]*$/, "");

        // Summarize duration for 
        var holder = {};          
        newLines.forEach(function (d) {
            if (holder.hasOwnProperty(d.name)) {
                holder[d.name] = holder[d.name] + d.duration_sec;
            }
            else {
                holder[d.name] = d.duration_sec;
            }
        });  

        var obj2 = [];
        for (var prop in holder) {
            obj2.push({ name: prop, duration_sec: holder[prop] });
        }
        
        obj2.sort(function(a, b){
            var keyA = (a.name),
                keyB = (b.name);
            if(keyA < keyB) return -1;
            if(keyA > keyB) return 1;
            return 0;
            });

        // prepare summary data for AJAX
        var summary = [];

        // print unique names to screen
        div_uniq = document.getElementById('names');
        div_uniq.innerHTML = "<div class='col-md-9'><strong>ALL CHARACTERS</strong></div><div class='col-md-3'><strong>DURATION</strong></div>";
        for (var i = 0; i < obj2.length; i++) {
            div_uniq.innerHTML = div_uniq.innerHTML + "<div class='col-md-9'>" + obj2[i].name + "</div><div class='col-md-3'>" + obj2[i].duration_sec + " sec</div><br />";
            
            // Prepare Data to send to PHP
            // summary.push([obj2[i].name, obj2[i].duration_sec])
            csvObj.push(["summary", obj2[i].name, obj2[i].duration_sec]);

        };
        
        div_uniq.innerHTML = div_uniq.innerHTML + "<div class='col-md-9 total'><strong>TOTAL</div>" + "<div class='col-md-3 total'><strong>" + epsdur + " sec</div><br />";

        csvObj.push(epsdur);  
        csvObj.push(filename);

        var myJSON = JSON.stringify(csvObj);
        // Send JSON to server         
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {json: JSON.stringify(csvObj)},
            dataType: 'json',
        });

        // Activate the download button
        // $('#link').attr("href", "http://www.jenspeter.net/dubtools/pt/"+filename+'.xlsx');
        $('#link').attr("href", "/test/pt/"+filename+'.xlsx');
        $('#download').show();
      };
      reader.readAsText(file);
   };  
}; 
   

