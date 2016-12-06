<?php

function listsections(){
    global $configs;
?>
<div class="sections">
            <div class="section_titles">
                General
            </div>
            <div class="section_contents">
                <div class="row">
                    <div class="input_box col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="input_title">Title</label>
                            <input type="text" value="<?php echo $configs->general->title; ?>" class="input_fields form-control" id="input_title" placeholder="Title" key="title" group="general">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input_box col-md-12">
                        <div class="form-group">
                            <label for="input_description">Description</label>
                            <textarea type="text" class="input_fields form-control" id="input_description" placeholder="Description" key="description" group="general"><?php echo $configs->general->description; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="sections">
            <div class="section_titles">
                Data
            </div>
            <div class="section_contents">
                <div class="row">
                    <div class="input_box col-md-12 col-xs-12">
                        <label>Join By</label>
                        <div class="row">
                            <div class="form-group col-md-4 col-xs-12">
                                <select class="data_columns_selects input_fields form-control" group="data" key="data_join_key" selectedoption="<?php echo $configs->data->data_join_key;?>">
                                    <option disabled selected>Please select</option>
                                </select>
                            </div>
                            <div id="data_link_icon" class="col-md-1 col-xs-12">
                                <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
                            </div>
                            <div class="form-group col-md-4 col-xs-12">
                                <select class="geo_columns_selects input_fields form-control" group="data" key="geo_join_key" selectedoption="<?php echo $configs->data->geo_join_key;?>">
                                    <option disabled selected>Please select</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="sections">
            <div class="section_titles">
                Base Map
            </div>
            <div class="section_contents">
                <div class="row">
                    <div class="input_box col-md-6 col-xs-12">
                        <label for="input_description">Fill colour</label>
                        <div class="input-group colorpicker-component">
                            <input id="input_basemap_fillcolor" type="text" value="<?php echo $configs->basemap->fillcolor; ?>" class="input_fields form-control" group="basemap" key="fillcolor"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                    <div class="input_box col-md-6 col-xs-12">
                        <label for="input_description">Border colour</label>
                        <div class="input-group colorpicker-component">
                            <input id="input_basemap_bordercolor" type="text" value="<?php echo $configs->basemap->bordercolor; ?>" class="input_fields form-control" group="basemap" key="bordercolor"/>
                            <span class="input-group-addon"><i></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="sections" id="layers_section">
            <div class="section_titles">
                Layers
            </div>
            <?php
            $layers = $configs->layers;
            for($i = 0; $i < count($layers); $i++){
                $l = $layers[$i];
                ?>
                <div class="layers">
                    <div class="layer_titles">
                        <?php echo $l->type;?> layer 
                    </div>
                    <div class="row">
                        <div class="input_box col-md-6 col-xs-12">
                            <label>Visible?</label>
                            <select class="input_fields form-control" group="layers" layerindex="<?php echo $i;?>" key="visible" selectedoption="<?php echo $configs->layers[$i]->visible?>">
                                <option>false</option>
                                <option>true</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input_box col-md-6 col-xs-12">
                            <label>Column to visualize</label>
                            <select class="data_columns_numerial_selects input_fields form-control" group="layers" layerindex="<?php echo $i;?>" key="column" selectedoption="<?php echo $configs->layers[$i]->column?>">
                                <option disabled selected>Please select</option>
                            </select>
                        </div>
                    </div>
                    <?php if($l->type == "choropleths"){?>
                    <div class="row">
                        <div class="input_box col-md-12">
                            <label>Color Gradient</label>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    from
                                    <div class="input-group colorpicker-component">
                                        <input type="text" class="input_fields form-control" group="layers" value="<?php echo $configs->layers[$i]->startcolor?>" layerindex="<?php echo $i;?>" key="startcolor"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    to
                                    <div class="input-group colorpicker-component">
                                        <input type="text" class="input_fields form-control" group="layers" value="<?php echo $configs->layers[$i]->endcolor?>" layerindex="<?php echo $i;?>" key="endcolor"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                    <?php if($l->type == "symbol map"){?>
                    <div class="row">
                        <div class="input_box col-md-12">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <label>Coordinates</label>
                                    <select id="coordssource" class="input_fields form-control" group="layers" layerindex="<?php echo $i;?>" key="coordssource" selectedoption="<?php echo $configs->layers[$i]->coordssource?>">
                                        <option>automatic</option>
                                        <option>from data</option>
                                    </select>
                                </div>
                                <div id="select_coords_from_data" class="col-md-6 col-xs-12">
                                    <div class="col-md-6 col-xs-12">
                                        <label>Latitude</label>
                                        <select class="data_columns_numerial_selects input_fields form-control" group="layers" layerindex="<?php echo $i;?>" key="latitude" selectedoption="<?php echo $configs->layers[$i]->latitude?>">
                                            <option disabled selected>Please select</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <label>Longitude</label>
                                        <select class="data_columns_numerial_selects input_fields form-control" group="layers" layerindex="<?php echo $i;?>" key="longitude" selectedoption="<?php echo $configs->layers[$i]->longitude?>">
                                            <option disabled selected>Please select</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input_box col-md-12">
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="symbolmap_fillcolor">Fill colour</label>
                                    <div class="input-group colorpicker-component">
                                        <input id="symbolmap_fillcolor" type="text" group="layers" value="<?php echo $configs->layers[$i]->fillcolor; ?>" class="input_fields form-control" layerindex="<?php echo $i;?>" key="fillcolor"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="symbolmap_bordercolor">Border colour</label>
                                    <div class="input-group colorpicker-component">
                                        <input id="symbolmap_bordercolor" type="text" group="layers" value="<?php echo $configs->layers[$i]->bordercolor; ?>" class="input_fields form-control" layerindex="<?php echo $i;?>" key="bordercolor"/>
                                        <span class="input-group-addon"><i></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-12">
                                    <label for="symbolmap_minradius">Minimum radius</label>
                                    <div class="form-group">
                                        <input id="symbolmap_minradius" type="number" group="layers" value="<?php echo $configs->layers[$i]->minradius; ?>" class="input_fields form-control" layerindex="<?php echo $i;?>" key="minradius"/>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <label for="symbolmap_maxradius">Maximum radius</label>
                                    <div class="form-group">
                                        <input id="symbolmap_maxradius" type="number" group="layers" value="<?php echo $configs->layers[$i]->maxradius; ?>" class="input_fields form-control" layerindex="<?php echo $i;?>" key="maxradius"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
            </div>
            <?php
            }
            ?>
        </div>
<?php
}