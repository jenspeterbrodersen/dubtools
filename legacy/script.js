window.onload = function () {
  console.log("loaded");

  // print file properties to screen
  function handleFileSelect(evt) {
    var f = evt.target.files[0];
    document.getElementById('list').innerHTML = '<strong>' + f.name + '</strong>, (type: ' + f.type + ')' + f.size + ' bytes';
  }
  
  document.getElementById('inputfile').addEventListener('change', handleFileSelect, false);
  document.getElementById('inputfile').onchange = function(){

  // Add each line to array 
  var file = this.files[0];

  var reader = new FileReader();
  reader.onload = function(progressEvent){

  // Match name, tcin, tcout and duration
  var newLines = [];
  var lines = this.result.split('\n');
 
  for (var line = 0; line < lines.length; line++){
    check = lines[line]; 
    
    if (check.match(/^1/)) {
      var split = check.split(/\t/);
      var name = split[2].replace(/char_/, "");
      var tcin = split[3];
      var tcout = split[4];
      var duration = split[5]
      
      // convert tcin to sec for sorting
      var _ti_sec = tcin.split(':'); 
      var ti_sec = (+_ti_sec[0]) * 60 * 60 + (_ti_sec[1]) * 60 + (_ti_sec[2]); 
      
      name = name.replace(/_\d\d(?=[^_]*$)/, "");
      newLines.push({ ti_sec,tcin, tcout, name, duration });
      // console.log(tcin + "\t", ti_sec, tcout + "\t", name + "\t", duration)
    }
  }
  
  // sort array by tcin seconds
  newLines.sort(function(a, b) {
    return a.ti_sec - b.ti_sec;
  });
    
  // remove ti_sec for 
  newLines.forEach(function(){  
    delete newLines[0].ti_sec;
  });    
  console.log(newLines);

  var csv = Papa.unparse(newLines, { quoteChar:"" , delimiter:';', fields: ["tcin", "tcout", "name"]});
    console.log(csv)
  };
  reader.readAsText(file);
  };
}  


