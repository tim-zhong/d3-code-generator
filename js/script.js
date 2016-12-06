var dataColumns = [];
var geoColumns = [];
var dataColumnsNumerial = [];
var configs;

d3.select("#save_btn").on("click",saveConfig);

d3.json("configs.json", function(error, data){
	if(error) throw(error);
	configs = data;
	colorpickersInit();
});

d3.select("#coordssource").on("change",function(){
	if(this.value == "automatic"){
		d3.select("#select_coords_from_data").style("display","none");
	} else {
		d3.select("#select_coords_from_data").style("display","block");
	}
});

d3.csv("data/data.csv", function(error, data){
	if(error) throw(error);
	
	d3.json("data/geo.json", function(error, geo){
		if(error) throw(error);
		
		geoColumns = getKeys(geo.features[0].properties);
		dataColumns = getKeys(data[0]);

		for(var i = 0; i < dataColumns.length; i++){
			var key = dataColumns[i];
			var dataLen = data.length;
			for(var j = 0; j < dataLen; j++){
				if(!isNaN(parseFloat(data[j][key]))){
					dataColumnsNumerial.push(key);
					break;
				}
			}
		}
		selectsInit();
	});
});

function getKeys(obj){
	var keys = [];
	for (var key in obj) {
        if (!obj.hasOwnProperty(key)) continue;
        if(keys.indexOf(key) == -1) keys.push(key);
    }
    //console.log(keys);
    return keys;
}

function saveConfig(){
	var newConfigs = configs;
	var fields = document.getElementsByClassName("input_fields");
	var fields_count = fields.length;
	for(var i = 0; i < fields_count; i++){
		var field = fields[i];
		var field_group = field.getAttribute("group");
		var field_key = field.getAttribute("key");
		if(field_group == "layers"){
			layerIndex = field.getAttribute("layerindex");
			newConfigs[field_group][layerIndex][field_key] = field.value;
			continue;
		}
		if(configs.hasOwnProperty(field_group) && configs[field_group].hasOwnProperty(field_key)){
			newConfigs[field_group][field_key] = field.value;
		}
	}
	ajxpgn_json("updateconfigs.php?json=" + encodeURIComponent(JSON.stringify(newConfigs)),"",function(){
		return true;
	});
}


function colorpickersInit(){
    $(function() {
        colorpickers = $('.colorpicker-component').colorpicker();
    });
}


function selectsInit(){
	d3.selectAll(".data_columns_numerial_selects").selectAll("option")
		.data(dataColumnsNumerial).enter()
		.append("option")
		.html(function(d,i){
			if(d == this.parentNode.getAttribute("selectedoption")) this.parentNode.selectedIndex = i;
			return d;
		});
	d3.selectAll(".data_columns_selects").selectAll("option")
		.data(dataColumns).enter()
		.append("option")
		.html(function(d,i){
			if(d == this.parentNode.getAttribute("selectedoption")) this.parentNode.selectedIndex = i;
			return d;
		});
	d3.selectAll(".geo_columns_selects").selectAll("option")
		.data(geoColumns).enter()
		.append("option")
		.html(function(d,i){
			if(d == this.parentNode.getAttribute("selectedoption")) this.parentNode.selectedIndex = i;
			return d;
		});
} 