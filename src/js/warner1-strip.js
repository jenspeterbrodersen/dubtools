window.onload = function () {

    // Print file properties to screen
    var filename;
    function handleFileSelect(evt) {
                                // console.log("still alive")

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
        var lines = this.result;
        var data = []; // array for PHP
        // var pages = [];
        var chunks = [];
        // var words = [];
        // var names = [];
        var script = [];
        // var charName;
        // console.log("lines", lines, lines.length)
                
        // Print csv data on page
        div = document.getElementById('csv');
        div.innerHTML = "<div class='col-md-3'><strong>NAME</strong></div><div class='col-md-9'><strong>DIALOGUE</strong></div>";


        // Create CHUNKS array
        var regex = /<Chunk[^>]*>([\s\S]*?)<\/Chunk>/g;
        var data = regex.exec(lines);
        // console.log("data", data);
        while (data !== null) {
            chunks.push(data[0]);
            data = regex.exec(lines);
        }
        console.log("chunks ", chunks[3])

        // Find NAMES in CHUNKS
        for (i = 0; i < chunks.length; i++) {

            // check for characternames in CHUNKS
            // if (/<Chunk x1="252"/.exec(chunks[i])) {
            if (/<Chunk x1="90"/.exec(chunks[i])) {
            // if (/<Chunk x1="216"/.exec(chunks[i])) {

                
                int = chunks[i].match(/<Word[^>]*>([\s\S]*?)<\/Word>/g).length; // find # of matches
                matches = chunks[i].match(/<Word[^>]*>([\s\S]*?)<\/Word>/g); 

                // console.log("found a name in ", chunks[i], "#hits ", int, matches)
               
                var regexWord = /<Word[^>]*>([\s\S]*?)<\/Word>/g;
                var data2 = regexWord.exec(chunks[i]);
                var finalName = "";
                
                for (int; int > 0; int--) {
                    finalName = finalName + " " + data2[1].replace(/\d{1,}/, "");
                    // console.log("data2[1] ", data2[1])
                    data2 = regexWord.exec(chunks[i]);
                }
                console.log("finalName ", finalName)

                // names.push(finalName);
            }

            // check for dialogue lines in CHUNKS
            // if (/<Chunk x1="180"/.exec(chunks[i])) {
            if (/<Chunk x1="288"/.exec(chunks[i])) {
                
                int = chunks[i].match(/<Word[^>]*>([\s\S]*?)<\/Word>/g).length; // find # of matches
                matches = chunks[i].match(/<Word[^>]*>([\s\S]*?)<\/Word>/g); 

                // console.log("found a dialogue in ", chunks[i], "#hits ", int, matches)

                var regexWord = /<Word[^>]*>([\s\S]*?)<\/Word>/g;
                var data3 = regexWord.exec(chunks[i]);
                var finalDialogue = "";
                
                for (int; int > 0; int--) {
                    finalDialogue = finalDialogue +" "+ data3[1];
                    data3 = regexWord.exec(chunks[i]);
                }
                console.log("finalDialogue ", finalDialogue)
                finalDialogue_CC = finalDialogue.substr(0, 1).toUpperCase() + finalDialogue.substr(1).toLowerCase();;
                // var dial2 = finalDialogue_CC.replace(/([!?.]\s+)([a-z])/g, function (m, $1, $2) {
                //     return $1 + $2.toUpperCase();
                //     console.log("dial2 ", dial2)
                // });
                // finalDialogue_CC = finalDialogue_CC.charAt(0).toUpperCase();
                

                console.log("finalDialogue_CC ", finalDialogue_CC)
                

                script.push({
                    "character": finalName.trim(),
                    "dialogue": finalDialogue_CC.trim()
                });
            }
        }    

        console.log("script", script)

        // Print data to screen
        script.forEach(printOut);

        function printOut(item) {
            div.innerHTML = div.innerHTML + "<div class='col-md-3'>" + item.character + "</div><div class='col-md-9'>" + item.dialogue + "</div>";
        }
  
        // Create array to send to server
        // data.push([name, dial2]);
        // console.log("data ", data)


console.log("filename", filename)
        script.push({
            "filename": filename
        });
        console.log("script with filename", script)
        json_script = JSON.stringify(script);
        console.log("json_script ", json_script )

        // Send array to PHP page
        $.ajax({
            type: 'POST',
            url: 'warner1-strip.php',
            data: {json: JSON.stringify(script)},
            dataType: 'json',
        });

        // Activate the download button
        // $('#link').attr("href", "http://www.jenspeter.net/dubtools/strip/"+filename+'.xlsx');
        $('#link').attr("href", filename+'.xlsx');
        $('#download').show();

    };
        reader.readAsText(file);
    };
};


