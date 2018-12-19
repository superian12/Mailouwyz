
	var stateObject = {
    "NCR": {
        "Mandaluyong": ["Addition Hills", "Bagong Silang" , "Barangka Drive","Highway Hills","Hulo"],
        "San Juan": ["Berkeley","Torronto"]
    }
    //,
    //"Pr": {
  //      "Douglas": ["Roseburg", "Winston"],
   //     "Mc Arthur":["Highyaw","CornerStone"]
   // }
}
window.onload = function () {
    var stateSel = document.getElementById("reg"),
        countySel = document.getElementById("city"),
        citySel = document.getElementById("brgy");
    for (var state in stateObject) {
        stateSel.options[stateSel.options.length] = new Option(state, state);
    }
    stateSel.onchange = function () {
        countySel.length = 1;
        citySel.length = 1; 
        if (this.selectedIndex < 1) {
          countySel.options[0].text = "Please select Region first"
          citySel.options[0].text = "Please select Region first"
          return; // done   
        }  
        countySel.options[0].text = "Please select Region"
        for (var county in stateObject[this.value]) {
            countySel.options[countySel.options.length] = new Option(county, county);
        }
        if (countySel.options.length==2) {
          countySel.selectedIndex=1;
          countySel.onchange();
        }  
        
    }
    stateSel.onchange(); // reset in case page is reloaded
    countySel.onchange = function () {
        citySel.length = 1; // remove all options bar first
        if (this.selectedIndex < 1) {
          citySel.options[0].text = "Please select Region first"
          return; // done   
        }  
        citySel.options[0].text = "Please select city"
        
        var cities = stateObject[stateSel.value][this.value];
        for (var i = 0; i < cities.length; i++) {
            citySel.options[citySel.options.length] = new Option(cities[i], cities[i]);
        }
        if (citySel.options.length==2) {
          citySel.selectedIndex=1;
          citySel.onchange();
        }  
        
    }
}
