<?php
include "getconfigs.php";
$layers = $configs->layers;
$choropleths_layer = false;
$symbolmap_layer = false;
for($i =  0; $i < count($layers); $i++){
	if($layers[$i]->type == "choropleths" && $layers[$i]->visible=="true") $choropleths_layer = $layers[$i];
	if($layers[$i]->type == "symbol map" && $layers[$i]->visible=="true") $symbolmap_layer = $layers[$i];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $configs->general->title; ?></title>
</head>
<body>
<style>
body{
	margin:0;
}
.basemap_paths{
	stroke:<?php echo $configs->basemap->bordercolor; ?>;
}
<?php if($symbolmap_layer){?>
.dots{
	stroke:<?php echo $symbolmap_layer->bordercolor; ?>;	
	fill:<?php echo $symbolmap_layer->fillcolor; ?>;	
}
<?php }?>
</style>

<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://d3js.org/topojson.v1.min.js"></script>
<script>
	var data;

	var width = window.innerWidth,
	    height = window.innerHeight;
	    
	var projection = d3.geo.mercator()
		.translate([width / 2, height / 1.5])
		.scale((width - 1) / 2 / Math.PI);

	var zoom = d3.behavior.zoom()
	    .scaleExtent([1, 8])
	    .on("zoom", zoomed);
	    
	var path = d3.geo.path()
	    .projection(projection);

	var svg = d3.selectAll('body')
	    .append('svg')
	        .attr('width',width)
	        .attr('height',height)
	        .call(zoom)

	var g = svg.append("g");



	
	// ----------------------GeoJSON------------------ //
	d3.csv("data/data.csv", function(error, inputData){
		if(error) throw(error);
		data = inputData;

<?php if($choropleths_layer){?>

		var baseMapColorScale = d3.scale.linear()
			.range([d3.rgb("<?php echo $choropleths_layer->startcolor; ?>"), d3.rgb("<?php echo $choropleths_layer->endcolor; ?>")])
			.domain(d3.extent(data, function(d){ return parseFloat(d["<?php echo $choropleths_layer->column; ?>"]); }));

<?php } ?>
<?php if($symbolmap_layer){?>
		var minR = <?php echo $symbolmap_layer->minradius;?>;
		var maxR = <?php echo $symbolmap_layer->maxradius;?>;
		var rScale = d3.scale.linear()
			.range([Math.min(minR,maxR), Math.max(minR,maxR)])
			.domain(d3.extent(data, function(d){ return parseFloat(d["<?php echo $symbolmap_layer->column; ?>"]); }));
		//console.log(Math.min([minR,maxR]));
<?php } ?>

		d3.json("data/geo.json", function(error, world) {
		    if(error) throw(error);
		        g.selectAll('path')
		            .data(world.features)
		            .enter().append('path')
<?php if($choropleths_layer || $symbolmap_layer){?>
		            .attr("class",function(d){
		            	var key = "<?php echo $configs->data->geo_join_key; ?>";
		            	return "basemap_paths basemap_path_" + formatString(d.properties[key]);
		            })
<?php }else {?>			    .attr("class","basemap_paths")
<? }?>
		            .attr("d", path)
		            .attr("fill","<?php echo $configs->basemap->fillcolor; ?>");
<?php if($choropleths_layer){?>
		    var len = data.length;
		    for(var i = 0; i < len; i++){
		    	var d = data[i];
		    	var key = "<?php echo $configs->data->data_join_key; ?>";
		    	g.selectAll(".basemap_path_" + formatString(d[key]))
		    		.attr("fill",function(){
						var value = parseFloat(d["<?php echo $choropleths_layer->column; ?>"]);
						if(!isNaN(value)) return baseMapColorScale(value);
						else return "<?php echo $configs->basemap->fillcolor; ?>";
					});
		    }
<?php } ?>
<?php if($symbolmap_layer){
?>
	g.selectAll("circle")
		.data(data).enter()
		.append("circle")
		.attr("class", "dots")
		.attr("r", function(d){
			var value = d["<?php echo $symbolmap_layer->column?>"];
			if(!isNaN(parseFloat(value))){
				return rScale(parseFloat(value));
			}
		})
		.attr("cx", function(d){
			var key = "<?php echo $configs->data->data_join_key; ?>";
			if(!g.select(".basemap_path_" + formatString(d[key])).empty()){
				<?php if($symbolmap_layer->coordssource == "automatic"){?>
				return path.centroid(g.select(".basemap_path_" + formatString(d[key])).datum())[0];
				<?php } else {?>
					return projection([parseFloat(d["<?php echo $symbolmap_layer->longitude?>"]),parseFloat(d["<?php echo $symbolmap_layer->latitude?>"])])[0];
				<?php }?>
			}
			else d3.select(this).remove();
		})
		.attr("cy", function(d){
			var key = "<?php echo $configs->data->data_join_key; ?>";
			if(!g.select(".basemap_path_" + formatString(d[key])).empty()){
				<?php if($symbolmap_layer->coordssource == "automatic"){?>
				return path.centroid(g.select(".basemap_path_" + formatString(d[key])).datum())[1];
				<?php } else {?>
					return projection([parseFloat(d["<?php echo $symbolmap_layer->longitude?>"]),parseFloat(d["<?php echo $symbolmap_layer->latitude?>"])])[1];
				<?php }?>
			}
		});

<?php
	}
?>
		});

	});

	function zoomed() {
  		g.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
	}

	/*-------------- helpers ------------------*/
	function formatString(s){
		if(s){
			s = String(s);
			return s.replace(/[^a-z0-9\s]/gi, '').replace(/ /g,'').toLowerCase();
		}
	}

</script>
</body>
</html>